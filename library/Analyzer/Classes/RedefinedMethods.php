<?php
/*
 * Copyright 2012-2016 Damien Seguy – Exakat Ltd <contact(at)exakat.io>
 * This file is part of Exakat.
 *
 * Exakat is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Exakat is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with Exakat.  If not, see <http://www.gnu.org/licenses/>.
 *
 * The latest code can be found at <http://exakat.io/>.
 *
*/


namespace Analyzer\Classes;

use Analyzer;

class RedefinedMethods extends Analyzer\Analyzer {
    public function analyze() {
        $this->atomIs('Class')
             ->outIs('BLOCK')
             ->outIs('ELEMENT')
             ->atomIs('Function')
             ->_as('results')
             ->outIs('NAME')
             ->savePropertyAs('code', 'method')
             ->inIs('NAME')
             ->inIs('ELEMENT')
             ->inIs('BLOCK')
             ->goToAllParents()
             ->hasNoOut('ABSTRACT') // abstract methods are not redefined. 
             ->outIs('BLOCK')
             ->outIs('ELEMENT')
             ->atomIs('Function')
             ->hasNoOut('ABSTRACT') // abstract methods are not redefined. 
             ->outIs('NAME')
             ->samePropertyAs('code', 'method')
             ->back('results')
             ;
        $this->prepareQuery();
    }
}

?>
