<?php

  // Pay Attention for writing Permission for creating files

  require_once 'vendor/autoload.php';

  // Create new Class
  $COMPILER = new eminmuhammadi\phpCompiler();

  // Declare variables

  // Python mode (other 5 languages support // please read about in source code)

  $env = [
   'command'    => 'python3',
   'time'       => '5', //seconds
   'code'       => $_POST['code'] ,
   'input'      => $_POST['input'],
   'fnCode'     => 'main.py',
   'fnInput'    => 'input.txt',
   'fnError'    => 'error.txt'
  ];

  // Set time for compiler
  $time = 1000*$env['time'];
  $COMPILER->setTimeOut($time);

  // Result Compilation
  $RESULT = $COMPILER->Run(
                 $env['command'],
                 $env['time'],
                 false,
                 false,
                 $env['code'],
                 $env['input'],
                 $env['fnCode'],
                 $env['fnInput'],
                 $env['fnError']
               );

  // Start JSON
  header('Content-Type: application/json');

  // Join Datas
  $data = [
    'code'       => $env['code'] ,
    'time_limit' => $time,
    'input'      => $env['input'],
    'result'     => $RESULT
  ];

  // Print Json
  echo json_encode($data,JSON_PRETTY_PRINT);
