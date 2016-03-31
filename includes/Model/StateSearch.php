<?php

/**
 * Tran Tinh Chi
 * Search State - 2/12/2015
 */

require_once FILE_PATH('algorithms') . 'SearchAlgorithm.php';
require_once FILE_PATH('algorithms') . 'SearchUserAlgorithm.php';
require_once FILE_PATH('algorithms') . 'SearchRestaurantAlgorithm.php';
require_once FILE_PATH('algorithms') . 'SearchRecruitmentAlgorithm.php';
require_once FILE_PATH('algorithms') . 'NullAlgorithm.php';


class StateSearch implements ModelState
{

    private static $instance;

    private function __construct()
    {
    }

    public static function Instance()
    {
        if (StateSearch::$instance == null) {
            StateSearch::$instance = new StateSearch();
        }
        return StateSearch::$instance;
    }

    public function process(Package $messagePackage)
    {
        $conn = ModelManager::getDatabaseConnection($this);
        $target = $messagePackage->getValue(DatabaseDef::KEY_TARGET);

        switch ($target) {
            case DatabaseDef::TAR_USERS:
                $algorithms = new SearchUserAlgorithm();
                break;

            case DatabaseDef::TAR_RESTAURANT:
                $algorithms = new SearchRestaurantAlgorithm();
                break;

            case DatabaseDef::TAR_RECRUITMENT:
                $algorithms = new SearchRecruitmentAlgorithm();
                break;

            default:
                error_log('StateSearch - Wrong parameter ');
                return false;
                break;
        }

            if (!$algorithms->execute($conn, $messagePackage)) {
                (new NullAlgorithm)->execute($conn, $messagePackage);
                return false;
        }

        return true;

    }
}

?>