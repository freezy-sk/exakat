<?php

namespace Test\Functions;

use Test\Analyzer;

include_once dirname(__DIR__, 4).'/library/Autoload.php';
spl_autoload_register('Autoload::autoload_test');
spl_autoload_register('Autoload::autoload_phpunit');
spl_autoload_register('Autoload::autoload_library');

class RealFunctions extends Analyzer {
    /* 1 methods */

    public function testFunctions_RealFunctions01()  { $this->generic_test('Functions/RealFunctions.01'); }
}
?>