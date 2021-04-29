<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class Welcome extends CI_Controller {

	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function create_repo() {
		 $powerShell = 'C:/Windows/System32/WindowsPowerShell/v1.0/powershell.exe';
		 $repository_name = 'test_repo_' . date('YmdHis');
		 $process = new Process([$powerShell, 'New-SvnRepository', $repository_name]);
		//  $process->run();
		//  // executes after the command finishes
		//  if ( ! $process->isSuccessful()) {
		//  	throw new ProcessFailedException($process);
		 
		//  echo $process->getOutput();
			system('C:/Windows/System32/WindowsPowerShell/v1.0/powershell.exe New-SvnRepository lopk');

		// $process= new Process('C:/Windows/System32/WindowsPowerShell/v1.0/powershell.exe New-SvnRepository lappet');
		// $process->mustRun();
		// if ( ! $process->isSuccessful()) {
		//  	throw new ProcessFailedException($process);
		 
		//  echo $process->getIncrementalErrorOutput();
		//}
	}
}
