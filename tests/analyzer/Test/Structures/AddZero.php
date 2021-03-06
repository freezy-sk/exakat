<?php

namespace Test\Structures;

use Test\Analyzer;

include_once dirname(__DIR__, 4).'/library/Autoload.php';
spl_autoload_register('Autoload::autoload_test');
spl_autoload_register('Autoload::autoload_phpunit');
spl_autoload_register('Autoload::autoload_library');

class AddZero extends Analyzer {
    /* 8 methods */

    public function testStructures_AddZero01()  { $this->generic_test('Structures_AddZero.01'); }
    public function testStructures_AddZero02()  { $this->generic_test('Structures_AddZero.02'); }
    public function testStructures_AddZero03()  { $this->generic_test('Structures/AddZero.03'); }
    public function testStructures_AddZero04()  { $this->generic_test('Structures/AddZero.04'); }
    public function testStructures_AddZero05()  { $this->generic_test('Structures/AddZero.05'); }
    public function testStructures_AddZero06()  { $this->generic_test('Structures/AddZero.06'); }
    public function testStructures_AddZero07()  { $this->generic_test('Structures/AddZero.07'); }
    public function testStructures_AddZero08()  { $this->generic_test('Structures/AddZero.08'); }
}
?>