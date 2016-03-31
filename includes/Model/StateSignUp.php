<?php
	
/**
	* Tran Tinh Chi
	* Sign Up State - 2/12/2015
	*/

	class StateSignUp implements ModelState {

		private function __construct(){}

		private static $instance;
		public static function Instance(){
			if (StateSignUp::$instance == null){
				StateSignUp::$instance = new StateSignUp();
			}
			return StateSignUp::$instance;
		}

		public function process (Package $messagePackage){

			$conn = ModelManager::getDatabaseConnection($this);
			if (!(new SignUpDataAlgorithm())->execute($conn,$messagePackage)) {
				(new NullAlgorithm)->execute($conn, $messagePackage);
				return false;
			}

			return true;
		}
	}
	
?>