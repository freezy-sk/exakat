<?php

namespace Test\Extensions;

use Test\Analyzer;

include_once dirname(__DIR__, 4).'/library/Autoload.php';
spl_autoload_register('Autoload::autoload_test');
spl_autoload_register('Autoload::autoload_phpunit');
spl_autoload_register('Autoload::autoload_library');

class Extfann extends Analyzer {
    /* 2 methods */

    public function testExtensions_Extfann01()  { $this->generic_test('Extensions_Extfann.01'); }
    public function testExtensions_Extfann02()  { $this->generic_test('Extensions/Extfann.02'); }
}
?>