<?php
/**
 * Created by PhpStorm.
 * User: Tran Tinh Chi
 * Date: 12/2/15
 * Time: 4:34 PM
 */

require_once FILE_PATH('model') . 'DatabaseDef.php';
require_once FILE_PATH('model') . 'ModelState.php';
require_once FILE_PATH('algorithms') . 'MatchingListAlgorithm.php';
require_once FILE_PATH('algorithms') . 'MatchingPercentageAlgorithm.php';
require_once FILE_PATH('algorithms') . 'RecentActivityAlgorithm.php';
require_once FILE_PATH('algorithms') . 'NullAlgorithm.php';


class StateMainPage implements ModelState
{

    const DEF_GET_SINGLE_MATCHED = 'GET_SINGLE_MATCHED';
    const DEF_GET_MATCHING_LIST = 'GET_MATCHING_LIST';
    const DEF_GET_RECENT_ACTIVITY = 'GET_RECENT_ACTIVITY';

    private function __construct()
    {
    }

    private static $instance;

    public static function Instance()
    {
        if (StateMainPage::$instance == null) {
            StateMainPage::$instance = new StateMainPage();
        }
        return StateMainPage::$instance;
    }

    public function process(Package $messagePackage)
    {

        $conn = ModelManager::getDatabaseConnection($this);
        $def = $messagePackage->getValue(DatabaseDef::DEFINITION_STATE);

        switch ($def) {
            case StateMainPage::DEF_GET_MATCHING_LIST:
                $algorithms = new MatchingListAlgorithm();
                break;

            case StateMainPage::DEF_GET_SINGLE_MATCHED:
                $algorithms = new MatchingPercentageAlgorithm();
                break;

            case StateMainPage::DEF_GET_RECENT_ACTIVITY:
                $algorithms = new RecentActivityAlgorithm();
                break;

            default:
                error_log('StateMainPage - Wrong parameter ');
                return false;
        }

        if (!$algorithms->execute($conn, $messagePackage)) {
            (new NullAlgorithm())->execute($conn, $messagePackage);
            return false;
        }

        return true;
    }
}



