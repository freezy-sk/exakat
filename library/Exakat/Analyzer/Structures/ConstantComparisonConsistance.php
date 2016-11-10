<?php
/*
 * Copyright 2012-2016 Damien Seguy – Exakat Ltd <contact(at)exakat.io>
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


namespace Exakat\Analyzer\Structures;

use Exakat\Analyzer\Analyzer;

class ConstantComparisonConsistance extends Analyzer {

    public function analyze() {

        $literalsList = '"' . join('", "', self::$LITERALS) . '"';
        $query = <<<GREMLIN
g.V().hasLabel("Comparison").out("LEFT").map{ if (it.get().label() in [$literalsList]) { 
                x2 = "left"; 
            } else { 
                x2 = "right"; 
            }; }.groupCount("gf").cap("gf")
            .sideEffect{ s = it.get().values().sum(); }.next().findAll{ it.value < s * 0.1; }.keySet()
GREMLIN;
        
        $types = $this->query($query);
        if (count($types) == 0) {
            return;
        }
       
        $types = $types[0];

        $this->atomIs('Comparison')
             ->outIs('LEFT')
             ->raw('sideEffect{ if (it.get().label() in ['.$literalsList.']) { 
                x2 = "left"; 
            } else { 
                x2 = "right"; 
            } }')
              ->raw('filter{ x2 == "'.$types.'"}')
              ->back('first');
         $this->prepareQuery();
    }
}

?>