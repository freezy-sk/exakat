<?php

namespace Test\Vendors;

use Test\Analyzer;

include_once dirname(__DIR__, 4).'/library/Autoload.php';
spl_autoload_register('Autoload::autoload_test');
spl_autoload_register('Autoload::autoload_phpunit');
spl_autoload_register('Autoload::autoload_library');

class Drupal extends Analyzer {
    /* 1 methods */

    public function testVendors_Drupal01()  { $this->generic_test('Vendors/Drupal.01'); }
}
?>