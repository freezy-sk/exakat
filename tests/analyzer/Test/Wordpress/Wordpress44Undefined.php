<?php

namespace Test\Wordpress;

use Test\Analyzer;

include_once dirname(__DIR__, 4).'/library/Autoload.php';
spl_autoload_register('Autoload::autoload_test');
spl_autoload_register('Autoload::autoload_phpunit');
spl_autoload_register('Autoload::autoload_library');

class Wordpress44Undefined extends Analyzer {
    /* 1 methods */

    public function testWordpress_Wordpress44Undefined01()  { $this->generic_test('Wordpress/Wordpress44Undefined.01'); }
}
?>