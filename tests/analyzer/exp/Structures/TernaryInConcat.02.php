<?php

$expected     = array('\'E\' . \'F\' . $b > 1 ? \'G\' : \'H\' . \'I\' . J(\'K\', $c) . \'L\' . $b > 1 ? \'M\' : \'N\' . \'O\'',
                      '\'H\' . \'I\' . J(\'K\', $c) . \'L\' . $b > 1 ? \'M\' : \'N\' . \'O\'',
                      '\'B\' . $b . \'C\' . $b > 1 ? \'D\' : \'E\' . \'F\' . $b > 1 ? \'G\' : \'H\' . \'I\' . J(\'K\', $c) . \'L\' . $b > 1 ? \'M\' : \'N\' . \'O\'',
                     );

$expected_not = array('\'E1\' . \'F1\' . $b > 1 ? \'G1\' : \'H1\' . \'I1\' . J(\'K1\', $c) . \'L1\' . $b > 1 ? \'M1\' : \'N1\' . \'O1\'',
                      '\'H1\' . \'I1\' . J(\'K1\', $c) . \'L1\' . $b > 1 ? \'M1\' : \'N1\' . \'O1\'',
                     );

?>