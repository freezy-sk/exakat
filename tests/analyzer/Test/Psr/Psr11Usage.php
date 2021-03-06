<?php

namespace Test\Psr;

use Test\Analyzer;

include_once dirname(__DIR__, 4).'/library/Autoload.php';
spl_autoload_register('Autoload::autoload_test');
spl_autoload_register('Autoload::autoload_phpunit');
spl_autoload_register('Autoload::autoload_library');

class Psr11Usage extends Analyzer {
    /* 1 methods */

    public function testPsr_Psr11Usage01()  { $this->generic_test('Psr/Psr11Usage.01'); }
}
?>