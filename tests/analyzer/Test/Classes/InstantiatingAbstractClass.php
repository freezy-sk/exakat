<?php

namespace Test\Classes;

use Test\Analyzer;

include_once dirname(__DIR__, 4).'/library/Autoload.php';
spl_autoload_register('Autoload::autoload_test');
spl_autoload_register('Autoload::autoload_phpunit');
spl_autoload_register('Autoload::autoload_library');

class InstantiatingAbstractClass extends Analyzer {
    /* 3 methods */

    public function testClasses_InstantiatingAbstractClass01()  { $this->generic_test('Classes_InstantiatingAbstractClass.01'); }
    public function testClasses_InstantiatingAbstractClass02()  { $this->generic_test('Classes/InstantiatingAbstractClass.02'); }
    public function testClasses_InstantiatingAbstractClass03()  { $this->generic_test('Classes/InstantiatingAbstractClass.03'); }
}
?>