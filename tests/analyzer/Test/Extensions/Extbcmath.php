<?php

namespace Test\Extensions;

use Test\Analyzer;

include_once dirname(__DIR__, 4).'/library/Autoload.php';
spl_autoload_register('Autoload::autoload_test');
spl_autoload_register('Autoload::autoload_phpunit');
spl_autoload_register('Autoload::autoload_library');

class Extbcmath extends Analyzer {
    /* 2 methods */

    public function testExtensions_Extbcmath01()  { $this->generic_test('Extensions_Extbcmath.01'); }
    public function testExtensions_Extbcmath02()  { $this->generic_test('Extensions_Extbcmath.02'); }
}
?>