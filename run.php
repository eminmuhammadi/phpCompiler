<?php

  require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/build/compiler.php';

  $COMPILER = new Compiler();

  $env = [
   'command'=> 'g++',
   'executable' => 'a.out',
   'time'   => '5', //seconds
   'code'   => $_POST['code'] ,
   'input'  => $_POST['input'],
   'fnCode' => 'main.cpp',
   'fnInput'=> 'input.txt',
   'fnError'=> 'error.txt'
  ];

  $time = 1000*$env['time'];
  $COMPILER->setTimeOut($time);

  $RESULT = $COMPILER->Run(
                 $env['command'],
                 $env['time'],
                 $env['executable'],
                 $env['code'],
                 $env['input'],
                 $env['fnCode'],
                 $env['fnInput'],
                 $env['fnError']
               );
  header('Content-Type: application/json');

  $data = [
    'code'   => $env['code'] ,
    'time_limit' => $time,
    'input'  => $env['input'],
    'result' => $RESULT
  ];
  echo json_encode($data,JSON_PRETTY_PRINT);
