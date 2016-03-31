<?php
	
/**
	* Tran Tinh Chi
	* Login State - 2/12/2015
	*/

	require_once FILE_PATH('model').'DatabaseDef.php';
	require_once FILE_PATH('model').'ModelState.php';
	require_once FILE_PATH('algorithms').'LoginDataAlgorithm.php';

	class StateLogin implements ModelState {	

		private function __construct(){}

		private static $instance;
		public static function Instance(){
			if (StateLogin::$instance == null){
				StateLogin::$instance = new StateLogin();
			}
			return StateLogin::$instance;
		}

		public function process (Package $messagePackage){

			$conn = ModelManager::getDatabaseConnection($this);
			if (!(new LoginDataAlgorithm())->execute($conn,$messagePackage)) {
				(new NullAlgorithm)->execute($conn, $messagePackage);
				return false;
			}

			return true;
		}
	}
?>