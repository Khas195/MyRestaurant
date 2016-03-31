<?php
	/**
	* Tran Tinh Chi
	* The Model Manager - 2/12/2015
	*/

	require_once FILE_PATH('patterns')  . 'IReceiver.php';

	class ModelManager implements IReceiver
	{
		private static $instance;
		private $state;
		private static $conn = null;

		private function __construct(){ 
			// Create connection
			ModelManager::$conn = new mysqli(DatabaseDef::DB_SERVER_NAME, DatabaseDef::DB_USER_NAME, DatabaseDef::DB_PASSWORD, DatabaseDef::DB_DATABASE_NAME);
			// Check connection
			if (ModelManager::$conn->connect_error) {
	    		die("Connection failed: "."\n" . ModelManager::$conn->connect_error);
			}
			ModelManager::$conn->query("SET character_set_results=utf8");

			mb_language('uni');
		    mb_internal_encoding('UTF-8');
		}

		public static function getDatabaseConnection ($state){
			if (ModelManager::$conn == null || ModelManager::$conn->connect_error) {
				die(get_class($state)." - Connection failed: "."\n" . ModelManager::$conn->connect_error);
			}

			return ModelManager::$conn; 
		}

		public static function Instance(){
			if ( ModelManager::$instance == null){
				ModelManager::$instance = new ModelManager();
			}
			return ModelManager::$instance;
		}

		public function setState(ModelState $state) {
			$this->state = $state; 
		}
        public function changeState($stateName){
			switch ($stateName) {
				case DatabaseDef::STATE_LOGIN:
					require_once FILE_PATH('model').'StateLogin.php';
					$this->state = StateLogin::Instance();
					break;

				case DatabaseDef::STATE_SIGNUP:

					require_once FILE_PATH('model').'StateSignUp.php';
					$this->state = StateSignUp::Instance();
					break;

				case DatabaseDef::STATE_SEARCH:
					require_once FILE_PATH('model').'StateSearch.php';
					$this->state = StateSearch::Instance();
					break;

				case DatabaseDef::STATE_MAIN_PAGE:
					require_once FILE_PATH('model').'StateMainPage.php';
					$this->state = StateMainPage::Instance();
					break;

				default:
					return null;
					break;
			}
        }
		public function receivePackage(Package $messagePackage) {

			require_once FILE_PATH('model').'DatabaseDef.php';
			require_once FILE_PATH('model').'ModelState.php';
            switch($messagePackage->getValue(ControllerDef::COMMAND))
            {
                case ControllerCommand::STATE_CHANGE:
                    $this->changeState($messagePackage->getValue(DatabaseDef::NAME_STATE));
                    break;
                case ControllerCommand::GET_DATA:
                    $this->state->process($messagePackage);
                    break;
                default:
                    return;

            }

			// ['login', ....]
			// [NAME_STATE, STATE_X]
		}

	}
?>
