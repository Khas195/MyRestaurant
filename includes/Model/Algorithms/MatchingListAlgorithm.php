<?php
/**
 * Created by PhpStorm.
 * User: Tran Tinh Chi
 * Date: 12/20/15
 * Time: 1:18 PM
 */


require_once FILE_PATH('algorithms').'Algorithms.php';
require_once FILE_PATH('algorithms').'MatchingPercentageAlgorithm.php';

class MatchingListAlgorithm implements Algorithms {
    public function execute (mysqli $conn, Package $messagePackage) {
        $userId = $messagePackage->getValue(DatabaseDef::ATTRIBUTE_USER_USERID);

        if ($userId == null) {
            return false;
        }
        $pack = $this->getMatchingList($conn, $userId);

        $messagePackage->setValue(DatabaseDef::RESULT, $pack);

        return true;
    }

    private function getMatchingList($conn, $userId)
    {
        $RPID = DatabaseDef::ATTRIBUTE_RECRUITMENT_RPID;
        $sql = "SELECT TableResult.$RPID, TableResult.Job, TableResult.RecruitmentTitle, TableResult.Province, TableResult.District, TableResult.MatchedPercentage "
            . " From (SELECT PostNeedSkill.$RPID, RecruitmentPost.Job, RecruitmentPost.RecruitmentTitle, Restaurant.Province, Restaurant.District, SUM((Skill.Level * EmployeeHasSkill.ExpertiseLevel)) / SUM(Skill.Level * PostNeedSkill.RequireLevelPercentage) AS MatchedPercentage "
            . " From (((((Users JOIN Employee ON Users.UserId = Employee.EID)  "
            . "     JOIN EmployeeHasSkill ON Employee.EID = EmployeeHasSkill.EID) "
            . "     JOIN Skill ON EmployeeHasSkill.SkillID = Skill.SkillID) "
            . "     JOIN PostNeedSkill ON PostNeedSkill.SkillID = Skill.SkillID) "
            . "     JOIN RecruitmentPost ON RecruitmentPost.$RPID = PostNeedSkill.$RPID) "
            . "     JOIN Restaurant ON Restaurant.RID = RecruitmentPost.RID "
            . "     WHERE Users.UserId = '$userId' "
            . "     GROUP BY PostNeedSkill.$RPID) AS TableResult ";

        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $pack = PackagePool::Instance()->requestPackage();
            while ($row = $result->fetch_assoc()) {
                $row[DatabaseDef::MATCHED_PERCENTAGE] = MatchingPercentageAlgorithm::adjustResult($row[DatabaseDef::MATCHED_PERCENTAGE]);
                $pack->setValue($row["$RPID"], $row);
            }
            return $pack;
        } else {
            return null;
        }
    }
}