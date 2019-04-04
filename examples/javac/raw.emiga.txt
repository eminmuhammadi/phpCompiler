<?php

  // Pay Attention for writing Permission for creating files 

  require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/src/compiler.emiga.php';

  // Create new Class
  $COMPILER = new Compiler();

  // Declare variables

  // Java mode (other 5 languages support // please read about in source code)

  $env = [
   'command'    => 'javac',
   'executable' => '*.class',
   'runFile'    => 'java Main' , //out
   'time'       => '10', //seconds
   'code'       => $_POST['code'] ,
   'input'      => $_POST['input'],
   'fnCode'     => 'Main.java',
   'fnInput'    => 'input.txt',
   'fnError'    => 'error.txt',

   // Pay attention for new Condition
   'fnRunTime'  => 'runtime.txt'
  ];

  // Set time for compiler
  $time = 1000*$env['time'];
  $COMPILER->setTimeOut($time);

  // Result Compilation
  $RESULT = $COMPILER->Run(
                 $env['command'],
                 $env['time'],
                 $env['executable'],
                 $env['runFile'],
                 $env['code'],
                 $env['input'],
                 $env['fnCode'],
                 $env['fnInput'],
                 $env['fnError'],
                 $env['fnRunTime']
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