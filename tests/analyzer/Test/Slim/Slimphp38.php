<?php

namespace Test\Slim;

use Test\Analyzer;

include_once dirname(__DIR__, 4).'/library/Autoload.php';
spl_autoload_register('Autoload::autoload_test');
spl_autoload_register('Autoload::autoload_phpunit');
spl_autoload_register('Autoload::autoload_library');

class Slimphp38 extends Analyzer {
    /* 1 methods */

    public function testSlim_Slimphp3801()  { $this->generic_test('Slim/Slimphp38.01'); }
}
?>