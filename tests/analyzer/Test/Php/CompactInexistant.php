<?php

namespace Test\Php;

use Test\Analyzer;

include_once dirname(__DIR__, 4).'/library/Autoload.php';
spl_autoload_register('Autoload::autoload_test');
spl_autoload_register('Autoload::autoload_phpunit');
spl_autoload_register('Autoload::autoload_library');

class CompactInexistant extends Analyzer {
    /* 2 methods */

    public function testPhp_CompactInexistant01()  { $this->generic_test('Php/CompactInexistant.01'); }
    public function testPhp_CompactInexistant02()  { $this->generic_test('Php/CompactInexistant.02'); }
}
?>