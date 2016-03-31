<?php 
	/**
	* Tran Tinh Chi
	* Model State - 2/12/2015
	*/

	require_once FILE_PATH('patterns')  . 'Package.php';

	interface ModelState {
		public function process (Package $messagePackage); 
	}	
?>