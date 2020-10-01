<?php

$expected     = array('opencensus_trace_add_annotation(\'abc\')',
                      'opencensus_trace_add_annotation(\'asdf\', [\'spanId\' => \'1234\'])',
                      'opencensus_trace_begin(\'inner\', [ ])',
                      'opencensus_trace_add_annotation(\'foo\')',
                      'opencensus_trace_list( )',
                      'opencensus_trace_finish( )',
                      'opencensus_trace_finish( )',
                      'opencensus_trace_begin(\'root\', [\'spanId\' => \'1234\'])',
                     );

$expected_not = array('opencensus_trace_stop(\'root\', [\'spanId\' => \'1234\'])',
                     );

?>