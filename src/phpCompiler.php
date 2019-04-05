<?php

/**
 * LICENSE: MIT License
 *
 * Copyright (c) 2019 Emin Mühəmmədi (EmiGa)
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 * @package    phpCompiler
 * @author     Emin Muhammadi
 * @copyright  2019 Emin Muhammadi (EmiGa)
 * @license    https://github.com/eminmuhammadi/phpCompiler/blob/master/LICENSE  MIT License
 * @version    1.0.0
 * @link       https://github.com/eminmuhammadi/phpCompiler
 *
 *  Tested in Linux Debian Arch
 *
 *	apt-get install g++
 *	apt-get install gcc
 *	apt-get install clang
 *	apt-get install javac
 *	apt-get install python
 *
 *  Supported Languages : C++ , C , C11 , Java , Python (2.7 or 3)
 *  		 
 * ========== Commands =========
 *
 *  FOR C++  = g++
 *  FOR C    = gcc
 *  FOR C11  = g++ -std=c++11
 *  FOR JAVA = javac
 *
 * ========== Out ============== 
 *
 *  FOR C++  = timeout 5s ./a.out
 *  FOR C    = timeout 5s ./a.out
 *  FOR C11  = timeout 5s ./a.out
 *  FOR JAVA = timeout 5s java Main
 *
 * ======= Executable =========
 *
 *  FOR C++  = a.out
 *  FOR C    = a.out
 *  FOR C11  = a.out
 *  FOR JAVA = *.class
 *
 * ======== File Extension ======
 *
 *  FOR C++  = main.cpp
 *  FOR C    = main.c
 *  FOR C11  = main.cpp
 *  FOR JAVA = main.java
 *
 * ======== Python ==============
 * [ Beta ]
 * COMMANDS: python , python2 , python3
 * Extension : main.py
 */
namespace eminmuhammadi;

class phpCompiler
{

	/**
	*  Constructor (Checking System)
	*/
	function __construct()
	{

		/*
			ToDo Task
			Create exec command is executable
			Create CPU Limit

		*/

	}

	public function setTimeOut($time)
	{
		/*for microtime*/
		ini_set('max_execution_time',$time);
		set_time_limit($time);

		return $time;

	}

	public function runPython($cmd,$time,$run,$runFile,$code,$input,$fnCode,$fnInput,$fnError)
	{

	/**
	*  Python Section 
	*  To do List 
	*  Please secure the application using timeout
	*/

	$cmd=$cmd." ".$fnCode;
	$cmd_error=$cmd." 2>".$fnError;

	// Write Files
	$file_code=fopen($fnCode,"w+");
	fwrite($file_code,$code);
	fclose($file_code);

	$fIn=fopen($fnInput,"w+");
	fwrite($fIn,$input);
	fclose($fIn);

	// Write permission for files
	exec("chmod 777 $fnError");

	// Preparation
	shell_exec($cmd_error);
	$error=file_get_contents($fnError);
	$StartTime = microtime(true);


	// Check Error
	if(trim($error)=="")
	{
		if(trim($input)=="") { 
			$output=shell_exec($cmd); 
		}

		else { 
			$cmd=$cmd." < ".$fIn; $output=shell_exec($cmd); 
		}

		$data['output']=$output;
	}

	else
	{
		$data['output']=null;

    }

		// Calculate Execute Time
		$endTime = microtime(true);
		$seconds = $endTime - $StartTime;
		$seconds = sprintf('%0.2f', $seconds);
		$data['time'] = $seconds;

		//Error
		$data['error']=$error;

    	// Clear Trash Files
		exec("rm $fnCode");
		exec("rm *.txt");

		return $data;

		//stops function

	}

	public function runJava($cmd,$time,$run,$runFile,$code,$input,$fnCode,$fnInput,$fnError,$fnRunTime)
	{

		$out        = "timeout ".$time."s ".$runFile;
		$cmd        = $cmd." ".$fnCode;	
		$cmd_error  = $cmd." 2>".$fnError;
		$cmd_error_runtime = $out." 2>".$fnRunTime;

		//Create Files
		$fCode=fopen($fnCode,"w+");
		fwrite($fCode,$code);
		fclose($fCode);

		$fIn=fopen($fnInput,"w+");
		fwrite($fIn,$input);
		fclose($fIn);

		// Write Permission
		exec("chmod 777 $run"); 
		exec("chmod 777 $fnError");	

		shell_exec($cmd_error);

		$error=file_get_contents($fnError);

		$StartTime = microtime(true);


		// Checking Error
		if(trim($error)=="")
		{
			if(trim($input)=="")
			{
				shell_exec($cmd_error_runtime);
				$runtime_error=file_get_contents($fnRunTime);
				$output=shell_exec($out);
			}
			else
			{
				shell_exec($cmd_error_runtime);
				$runtime_error=file_get_contents($fnRunTime);
				$out=$out." < ".$fIn;
				$output=shell_exec($out);
			}
			$data['output']=$output;
			$data['error']=$runtime_error;			
		}

		
		else if(!strpos($error,"error"))
		{
	
			if(trim($input)=="")
			{
				$output=shell_exec($out);
			}
			else
			{
				$out=$out." < ".$fIn;
				$output=shell_exec($out);
			}
				$data['output']=$output;
				$data['error']=$error;
		}	
			
		else
		{
		$data['output']=$error;
		}


		// Calculate Execute Time
		$endTime = microtime(true);
		$seconds = $endTime - $StartTime;
		$seconds = sprintf('%0.2f', $seconds);
		$data['time'] = $seconds;


		//Verdict
		if($seconds>$time) { $data['verdict']='TLE'; }
		else { $data['verdict']='AC'; }


		// Remove Trash Files
		exec("rm $fnCode");
		exec("rm *.txt");
		exec("rm $run");
		return $data;

		//stops function

	}


	public function runClang($cmd,$time,$run,$runFile,$code,$input,$fnCode,$fnInput,$fnError)
	{

		/**
		*  Clang Section
		*/ 

		$cmd       = $cmd." -lm " .$fnCode;
		$cmd_error = $cmd."  2> " .$fnError;
		$out = "timeout ".$time."s ".$runFile;
		$check = 0;

		/**
		*  Create file
		*/
		$fCode=fopen($fnCode,"w+");
		fwrite($fCode,$code);
		fclose($fCode);

		/**
		*  Create file
		*/
		$fIn=fopen($fnInput,"w+");
		fwrite($fIn,$input);
		fclose($fIn);

		/**
		*  Create write and read permission
		*/
		exec("chmod -R 777 $fnInput");
		exec("chmod -R 777 $fnCode");
		exec("chmod -R 777 $fnError");

		/**
		*  Run statemant
		*/
		shell_exec($cmd_error);
		exec("chmod -R 777 $run");


		$error=file_get_contents($fnError);
		$startTime = microtime(true);

		/**
		*  If input & error empty
		*/
		if(trim($error)=="")
		{
			if(trim($input)=="")
			{
				$output=shell_exec($out);
			}
			else
			{
				$out=$out." < ".$fnInput;
				$output=shell_exec($out);

			}
			$data['output']=$output;
		}


		/* Else */
		else if(!strpos($error,"error"))
		{
			if(trim($input)==""){$output=shell_exec($out);}

			else
			{
				$out=$out." < ".$fnInput;
				$output=shell_exec($out);
			}
			$data['output']=$output;
		}

		else
		{
			$data['output']=$error;
			$check=1;
		}

		/**
		*  Time Limit (Executing time)
		*/
		$endTime = microtime(true);
		$seconds = $endTime - $startTime;
		// The format string supports argument numbering/swapping. 
		$seconds = sprintf('%0.2f', $seconds);
		$data['time'] = $seconds;


		/**
		*  Verdicts
		*/

		// Compilation Error
		if($check==1){$data['verdict']="CE";}

		// Time Limit Exceed
		else if($check==0 && $seconds>$time){$data['verdict']="TLE";}

		// Run Time Error
		else if(trim($output)==""){$data['verdict']="RTE";}

		// Accepted
		else if($check==0){$data['verdict']="AC";}

		/**
		*  Remove Trash Files
		*/
		exec("rm $fnCode");
		exec("rm *.o");
		exec("rm *.txt");
		exec("rm $run");

		return $data;
		// stops function

	}


  	public function run($cmd,$time,$run,$runFile,$code,$input,$fnCode,$fnInput,$fnError,$fnRunTime=false)
	{

		if (($cmd=='python2') || ($cmd=='python3') || ($cmd=='python')){

				return self::runPython($cmd,$time,$run,$runFile,$code,$input,$fnCode,$fnInput,$fnError);

		}

		else if(($cmd=='g++') || ($cmd=='gcc') || ($cmd=='g++ -std=c++11')){

				return self::runClang($cmd,$time,$run,$runFile,$code,$input,$fnCode,$fnInput,$fnError);
  		}

  		else if($cmd=='javac'){

				return self::runJava($cmd,$time,$run,$runFile,$code,$input,$fnCode,$fnInput,$fnError,$fnRunTime);  				
  		}

  		else {
			$data['output']  = 'Error in compiling. Please contact with your webmaster';
			$data['vardict'] = 'RTE' ;
			$data['time']    = '0' ;
			return $data;
		}

	}

}