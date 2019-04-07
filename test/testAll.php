<?php

  require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/vendor/autoload.php';

  $COMPILER = new eminmuhammadi\phpCompiler();

  	//C
	try{
    	$result['c'] = $COMPILER->post('http://'.$_SERVER['HTTP_HOST'].'/runC.php', array(
        	'code' =>  file_get_contents('main.c'),
        	'input' => ''
    	));

    	
	} 

	catch(Exception $e){
		die($e->getMessage());
	}

	sleep(1);

	// Cpp
	try{
    	$result['cpp'] = $COMPILER->post('http://'.$_SERVER['HTTP_HOST'].'/runCpp.php', array(
        	'code' => file_get_contents('main.cpp'),
        	'input' => ''
    	));
    	
	} 

	catch(Exception $e){
		die($e->getMessage());
	}	

	sleep(1);

	// C11
	try{
    	$result['c11'] = $COMPILER->post('http://'.$_SERVER['HTTP_HOST'].'/runC11.php', array(
        	'code' => file_get_contents('main11.cpp'),
        	'input' => ''
    	));
    	
	} 

	catch(Exception $e){
		die($e->getMessage());
	}	

	sleep(1);

	// Java
	try{
    	$result['java'] = $COMPILER->post('http://'.$_SERVER['HTTP_HOST'].'/runJavac.php', array(
        	'code' => file_get_contents('main.java'),
        	'input' => ''
    	));
    	
	} 

	catch(Exception $e){
		die($e->getMessage());
	}	

	sleep(1);	


	// Python
	try{
    	$result['python'] = $COMPILER->post('http://'.$_SERVER['HTTP_HOST'].'/runPython.php', array(
        	'code' =>  file_get_contents('main.py'),
        	'input' => ''
    	));
    	
	} 

	catch(Exception $e){
		die($e->getMessage());
	}	

	sleep(1);	

    

    // Result

    $data['c']       = json_decode($result['c']);
    $data['cpp']     = json_decode($result['cpp']);
    $data['c11']     = json_decode($result['c11']);
    $data['java']    = json_decode($result['java']);
    $data['pyhon']   = json_decode($result['python']);

 	
    ?>
    <!DOCTYPE html>
    <html>
    <head>
    	<meta charset="utf-8">
    	<title>TestMode &mdas; C,Cpp,C11,Java,Pyhon</title>
    </head>
    <body>
    <pre><code><?php echo var_dump($data);?></code></pre>
    </body>
    </html>