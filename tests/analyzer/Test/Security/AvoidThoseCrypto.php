<?php

namespace Test\Security;

use Test\Analyzer;

include_once dirname(__DIR__, 4).'/library/Autoload.php';
spl_autoload_register('Autoload::autoload_test');
spl_autoload_register('Autoload::autoload_phpunit');
spl_autoload_register('Autoload::autoload_library');

class AvoidThoseCrypto extends Analyzer {
    /* 2 methods */

    public function testSecurity_AvoidThoseCrypto01()  { $this->generic_test('Security_AvoidThoseCrypto.01'); }
    public function testSecurity_AvoidThoseCrypto02()  { $this->generic_test('Security/AvoidThoseCrypto.02'); }
}
?>