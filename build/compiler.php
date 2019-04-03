<?php

/**
 *  For Linux Debian Arch
 */

class Compiler
{

	/**
	*  Constructor (Checking Class System)
	*/
	function __construct()
	{

		/*
			ToDo Task
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

  public function run($cmd,$time,$run,$code,$input,$fnCode,$fnInput,$fnError)
	{

	$cmd       = $cmd." -lm " .$fnCode;
	$cmd_error = $cmd."  2> " .$fnError;
	$out = "timeout ".$time."s ./".$run;
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
			$return['output']=$output;
	}


	/* Else */
	else if(!strpos($error,"error"))
	{
		if(trim($input)==""){$output=shell_exec($out);}

		else
		{
			$out=$out." < ".$filename_in;
			$output=shell_exec($out);
		}
			$return['output']=$output;
	}

	else
	{
		$return['output']=$error;
		$check=1;
	}

	/**
	*  Time Limit (Executing time)
	*/
	$endTime = microtime(true);
	$seconds = $endTime - $startTime;
	$seconds = sprintf('%0.2f', $seconds);
	$return['time'] = $seconds;


	/**
	*  Verdict Error
	*/
	if($check==1){$return['verdict']="CE";}

	else if($check==0 && $seconds>$time){$return['verdict']="TLE";}

	else if(trim($output)==""){$return['verdict']="RTE";}

	else if($check==0){$return['verdict']="AC";}



	/**
	*  Remove Trash Files
	*/
	exec("rm $fnCode");
	exec("rm *.o");
	exec("rm *.txt");
	exec("rm $run");

	return $return;

	}




}
