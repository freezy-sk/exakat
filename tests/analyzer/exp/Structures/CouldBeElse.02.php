<?php

$expected     = array('if($a != 2) { /**/ } ',
                      'if($a == 1) { /**/ } ',
                      'if($a !== 4) { /**/ } ',
                      'if($a === 3) { /**/ } ',
                      'if($a < 6) { /**/ } ',
                      'if($a > 5) { /**/ } ',
                      'if($a <= 8) { /**/ } ',
                      'if($a >= 7) { /**/ } ',
                     );

$expected_not = array('if($c < 9) { /**/ } ',
                      'if($a > 9) { /**/ } ',
                     );

?>