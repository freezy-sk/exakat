<?php
/*
 * Copyright 2012-2018 Damien Seguy – Exakat Ltd <contact(at)exakat.io>
 * This file is part of Exakat.
 *
 * Exakat is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Exakat is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with Exakat.  If not, see <http://www.gnu.org/licenses/>.
 *
 * The latest code can be found at <http://exakat.io/>.
 *
*/

namespace Exakat\Graph;

use Exakat\Graph\Graph;
use Exakat\Graph\Helpers\GraphResults;
use Exakat\Exceptions\GremlinException;
use Exakat\Tasks\Tasks;
use Brightzone\GremlinDriver\Connection;

class Tinkergraph extends Graph {
    const CHECKED = true;
    const UNCHECKED = false;
    const UNAVAILABLE = 1;
    
    private $status     = self::UNCHECKED;
    
    public function __construct($config) {
        parent::__construct($config);

        if (!file_exists("{$this->config->tinkergraph_folder}/lib/")) {
            // No local production, just skip init.
            $this->status = self::UNAVAIALBLE;
            return;
        }

        $this->db = new Connection(array(
                                     'host'     => $this->config->tinkergraph_host,
                                     'port'     => $this->config->tinkergraph_port,
                                     'graph'    => 'graph',
                                     'emptySet' => true,
                                   ));
    }

    public function resetConnection() {
        unset($this->db);
        $this->db = new Connection(array( 'host'  => $this->config->tinkergraph_host,
                                          'port'  => $this->config->tinkergraph_port,
                                          'graph' => 'graph',
                                          'emptySet' => true,
                                   ) );
        $this->status = self::UNCHECKED;
    }

    private function checkConfiguration() {
        $this->db->timeout = 1200;
        $this->db->open();
    }

    public function query($query, $params = array(), $load = array()) {
        if ($this->status === self::UNAVAILABLE) {
            return new GraphResults();
        } elseif ($this->status === self::UNCHECKED) {
            $this->checkConfiguration();
        }

        assert(is_array($params), 'Params must be an array, '.gettype($params).' provided.'.PHP_EOL.$query);
        foreach($params as $name => $value) {
            $this->db->message->bindValue($name, $value);
        }
        $result = $this->db->send($query);
        
        if (empty($result)) {
            return new GraphResults();
        } elseif($result[0] === null) {
            return new GraphResults();
        } elseif(is_array($result[0])) {
            if (isset($result[0]['processed'])) {
                $result = array('processed' => empty($result[0]['processed']) ? 0 : array_shift($result[0]['processed']),
                                'total'     => empty($result[0]['total'])     ? 0 : array_shift($result[0]['total']));
            }

            if (isset($result[0]['type'])) {
                $result = $this->simplifyArray($result);
            }

            return new GraphResults($result);
        } elseif (is_array($result)) {
            return new GraphResults($result);
        } elseif ($result instanceof \stdclass) {
            return new GraphResults($result);
        }
        
        assert(false, "Processing unknown type ".gettype($result).PHP_EOL.var_dump($result, false));
    }
    
    public function queryOne($query, $params = array(), $load = array()) {
        if ($this->status === self::UNCHECKED) {
            $this->checkConfiguration();
        }

        $res = $this->query($query, $params, $load);
        if (!($res instanceof \Stdclass) || !isset($res->results)) {
            throw new GremlinException('Server is not responding');
        }
        
        if (is_array($res->results)) {
            return $res->results[0];
        } else {
            return $res->results;
        }
    }

    public function checkConnection() {
        $res = @stream_socket_client('tcp://' . $this->config->tinkergraph_host .':'.$this->config->tinkergraph_port,
                                     $errno,
                                     $errorMessage,
                                     1,
                                     STREAM_CLIENT_CONNECT
                                     );

        return is_resource($res);
    }

    public function serverInfo() {
        if ($this->status === self::UNCHECKED) {
            $this->checkConfiguration();
        }
        
        $res = $this->query('Gremlin.version();');

        return $res;
    }

    public function clean() {
        // This is memory only Database
        $this->stop();
        $this->start();
    }
    
    public function start() {
        if (!file_exists($this->config->tinkergraph_folder.'/conf/tinkergraph.yaml')) {
            copy( $this->config->dir_root.'/server/tinkergraph/conf/tinkergraph.yaml',
                  $this->config->tinkergraph_folder.'/conf/tinkergraph.yaml');
        }

        $gremlinJar = glob($this->config->tinkergraph_folder.'/lib/gremlin-core-*.jar');
        $gremlinVersion = basename(array_pop($gremlinJar));
        //gremlin-core-3.2.5.jar
        $gremlinVersion = substr($gremlinVersion, 13, -4);
        $version = version_compare('3.3.0', $gremlinVersion) ? '.3.2' : '.3.3';

        if ($version === '.3.3') {
            exec('cd '.$this->config->tinkergraph_port_folder.'; rm -rf db/neo4j; ./bin/gremlin-server.exakat.sh start conf/tinkergraph.yaml  &');
        } elseif ($version === '.3.2') {
            exec('cd '.$this->config->tinkergraph_port_folder.'; rm -rf db/neo4j; ./bin/gremlin-server.sh conf/tinkergraph.yaml  > gremlin.log 2>&1 & echo $! > db/tinkergraph.pid ');
        }
        $this->resetConnection();
        sleep(1);
        
        $b = microtime(true);
        $round = -1;
        do {
            $res = $this->checkConnection();
            ++$round;
            usleep(100000 * $round);
        } while (empty($res) && $round < 20);
        $e = microtime(true);
        
        display("Restarted in $round rounds\n");

        if (file_exists($this->config->tinkergraph_folder.'/run/gremlin.pid')) {
            $pid = trim(file_get_contents($this->config->tinkergraph_folder.'/run/gremlin.pid'));
        } elseif ( file_exists($this->config->tinkergraph_folder.'/db/tinkergraph.pid')) {
            $pid = trim(file_get_contents($this->config->tinkergraph_folder.'/db/tinkergraph.pid'));
        } else {
            $pid = 'Not yet';
        }


        display('started ['.$pid.'] in '.number_format(($e - $b) * 1000, 2).' ms' );
    }

    public function stop() {
        if (file_exists($this->config->tinkergraph_folder.'/run/gremlin.pid')) {
            display('stop gremlin server 3.3.x');
            shell_exec('cd '.$this->config->tinkergraph_folder.'; ./bin/gremlin-server.sh stop');
            unlink($this->config->tinkergraph_folder.'/run/gremlin.pid');
        }
        
        if (file_exists($this->config->tinkergraph_folder.'/db/tinkergraph.pid')) {
            display('stop gremlin server 3.2.x');
            shell_exec('kill -9 $(cat '.$this->config->tinkergraph_folder.'/db/tinkergraph.pid) 2>> gremlin.log; rm -f '.$this->config->tinkergraph_folder.'/db/tinkergraph.pid');
        }
    }

    public function getId() {
        $query = 'g.V().id().max()';
        $resId = $this->query($query);
        
        return $resId->toInt() + 1;
    }

    private function simplifyArray($result) {
        $return = array();
        
        if (!isset($result[0]['properties'])) {
            return $result;
        }

        foreach($result as $r) {
            $row = array('id'    => $r['id'],
                         'label' => $r['label']);
            foreach($r['properties'] as $property => $value) {
                $row[$property] = $value[0]['value'];
            }
            
            $return[] = $row;
        }
        
        return $return;
    }

    public function getDefinitionSQL() {
        return <<<SQL
SELECT DISTINCT CASE WHEN definitions.id IS NULL THEN definitions2.id ELSE definitions.id END AS definition, calls.id AS call
FROM calls
LEFT JOIN definitions 
    ON definitions.type       = calls.type       AND
       definitions.fullnspath = calls.fullnspath
LEFT JOIN definitions definitions2
    ON definitions2.type       = calls.type       AND
       definitions2.fullnspath = calls.globalpath 
WHERE (definitions.id IS NOT NULL OR definitions2.id IS NOT NULL)
GROUP BY calls.id
SQL;
    }

}

?>
