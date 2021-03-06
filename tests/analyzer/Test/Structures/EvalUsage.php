<?php

namespace Test\Structures;

use Test\Analyzer;

include_once dirname(__DIR__, 4).'/library/Autoload.php';
spl_autoload_register('Autoload::autoload_test');
spl_autoload_register('Autoload::autoload_phpunit');
spl_autoload_register('Autoload::autoload_library');

class EvalUsage extends Analyzer {
    /* 2 methods */

    public function testStructures_EvalUsage01()  { $this->generic_test('Structures_EvalUsage.01'); }
    public function testStructures_EvalUsage02()  { $this->generic_test('Structures/EvalUsage.02'); }
}
?>