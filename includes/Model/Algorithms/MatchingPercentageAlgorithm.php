<?php
/**
 * Created by PhpStorm.
 * User: Tran Tinh Chi
 * Date: 12/20/15
 * Time: 12:36 PM
 */

require_once FILE_PATH('algorithms').'Algorithms.php';

class MatchingPercentageAlgorithm implements Algorithms {
    public function execute (mysqli $conn, Package $messagePackage) {
        // [ATTRIBUTE_USER_USERID, ...]
        // [ATTRIBUTE_RECRUITMENT_RPID, ...]
        // [ATTRIBUTE_RECRUITMENT_ID, ...]

        $userId = $messagePackage->getValue(DatabaseDef::ATTRIBUTE_USER_USERID);
        $recruitmentId = $messagePackage->getValue(DatabaseDef::ATTRIBUTE_RECRUITMENT_RPID);

        if ($userId == null || $recruitmentId == null) {
            return false;
        }

        $RPID = DatabaseDef::ATTRIBUTE_RECRUITMENT_ID;
        $sql = 'SELECT SUM((Skill.Level * EmployeeHasSkill.ExpertiseLevel)) / SUM(Skill.Level * PostNeedSkill.RequireLevelPercentage) AS MatchedPercentage '
            .'From (((Users JOIN Employee ON Users.UserId = Employee.EID) '
            .'JOIN EmployeeHasSkill ON Employee.EID = EmployeeHasSkill.EID) '
            .'JOIN Skill ON EmployeeHasSkill.SkillID = Skill.SkillID) '
            .'JOIN PostNeedSkill ON PostNeedSkill.SkillID = Skill.SkillID '
            ."WHERE Users.UserId = '$userId' AND PostNeedSkill.$RPID = '$recruitmentId'";

        $result = $conn->query($sql);
        $result = floatval($result[DatabaseDef::MATCHED_PERCENTAGE]);

        $result = adjustResult($result);

        $messagePackage->setValue(DatabaseDef::RESULT, $result);

        return true;
    }

    public static function adjustResult($result){
        if ($result < 1) {
            $result = round(MatchingPercentageAlgorithm::sigmoid($result), 2);
        }
        else if ($result > 1) {
            $result = round(MatchingPercentageAlgorithm::sigmoid(-$result), 2);
        }
        return $result;
    }

    private static function sigmoid ($x) {
        return 2/(1 + exp($x));
    }
}


