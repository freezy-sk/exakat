<?php

namespace Test\Constants;

use Test\Analyzer;

include_once dirname(__DIR__, 4).'/library/Autoload.php';
spl_autoload_register('Autoload::autoload_test');
spl_autoload_register('Autoload::autoload_phpunit');
spl_autoload_register('Autoload::autoload_library');

class IsPhpConstant extends Analyzer {
    /* 2 methods */

    public function testConstants_IsPhpConstant01()  { $this->generic_test('Constants_IsPhpConstant.01'); }
    public function testConstants_IsPhpConstant02()  { $this->generic_test('Constants/IsPhpConstant.02'); }
}
?>