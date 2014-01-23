<?php

namespace Test;

include_once(dirname(dirname(dirname(__DIR__))).'/library/Autoload.php');
spl_autoload_register('Autoload::autoload_test');
spl_autoload_register('Autoload::autoload_phpunit');

class Type_Octal extends Analyzer {
    /* 1 methods */

    public function testType_Octal01()  { $this->generic_test('Type_Octal.01'); }
}
?>