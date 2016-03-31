<?php
/**
 * Created by PhpStorm.
 * User: Tran Tinh Chi
 * Date: 12/20/15
 * Time: 1:31 PM
 */

require_once FILE_PATH('algorithms').'Algorithms.php';

class RecentActivityAlgorithm implements Algorithms {

    public function execute (mysqli $conn, Package $messagePackage) {
        // [MAX_NUMBER_RESULTS, unsigned int]
        // [KEY_TARGET, TAR_X]
        // [ATTRIBUTE_USER_USERID, ...]  (for case TAR_RECRUITMENT)

        $max = $messagePackage->getValue(DatabaseDef::MAX_NUMBER_RESULTS);
        $target = $messagePackage->getValue(DatabaseDef::KEY_TARGET);

        if ($max == null || $target == null) {
            return false;
        }

        switch ($target) {
            case DatabaseDef::TAR_USERS:
                $pack = $this->getRecentUser($conn, $max);
                break;

            case DatabaseDef::TAR_RESTAURANT:
                $pack = $this->getRecentRestaurant($conn, $max);
                break;

            case DatabaseDef::TAR_RECRUITMENT:
                $userId = $messagePackage->getValue(DatabaseDef::ATTRIBUTE_USER_USERID);
                if ($userId == null)
                    return false;

                $pack = $this->getRecentRecruitment($conn, $max, $userId);
                break;

            default:
                error_log('RecentActivityAlgorithm - Wrong parameter ');
                return false;
        }

        $messagePackage->setValue(DatabaseDef::RESULT, $pack);

        return true;
    }

    private function getRecentUser($conn, $max)
    {
        $sql = "SELECT *\n"
            . "FROM Users\n"
            . "order by Users.RegisterDate DESC\n"
            . "LIMIT $max";

        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $pack = PackagePool::Instance()->requestPackage();
            while ($row = $result->fetch_assoc()) {
                $pack->setValue($row["UserId"], $row);
            }
            return $pack;
        } else {
            return null;
        }
    }

    private function getRecentRestaurant($conn, $max)
    {
        $sql = "SELECT *\n"
            . "FROM Restaurant\n"
            . "order by Restaurant.EstablishDate DESC\n"
            . "LIMIT $max";

        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $pack = PackagePool::Instance()->requestPackage();
            while ($row = $result->fetch_assoc()) {
                $pack->setValue($row["RID"], $row);
            }
            return $pack;
        } else {
            return null;
        }
    }

    private function getRecentRecruitment($conn, $max, $userId)
    {
        $RPID = DatabaseDef::ATTRIBUTE_RECRUITMENT_RPID;

        $sql =
             "Select * "
            ."FROM "
            ."  (SELECT TableResult.DateCreated, TableResult.$RPID, TableResult.RecruitmentTitle, TableResult.Job, TableResult.Province, TableResult.District, TableResult.MatchedPercentage "
            ."  From "
            ."      (SELECT RecruitmentPost.DateCreated, RecruitmentPost.RecruitmentTitle, PostNeedSkill.RPID, RecruitmentPost.Job, Restaurant.Province, Restaurant.District, "
            ."         SUM((Skill.Level * EmployeeHasSkill.ExpertiseLevel)) / SUM(Skill.Level * PostNeedSkill.RequireLevelPercentage) AS MatchedPercentage "
            ."      From (((((Users JOIN Employee ON Users.UserId = Employee.EID) "
            ."                JOIN EmployeeHasSkill ON Employee.EID = EmployeeHasSkill.EID) "
            ."                JOIN Skill ON EmployeeHasSkill.SkillID = Skill.SkillID) "
            ."                JOIN PostNeedSkill ON PostNeedSkill.SkillID = Skill.SkillID) "
            ."                JOIN RecruitmentPost ON RecruitmentPost.RPID = PostNeedSkill.RPID) "
            ."                JOIN Restaurant ON Restaurant.RID = RecruitmentPost.RID "
            ."WHERE Users.UserId = $userId "
            ."GROUP BY PostNeedSkill.$RPID) AS TableResult "
    .       ") AS OUTERTABLE  "
            ."ORDER BY OUTERTABLE.DateCreated DESC "
            ."LIMIT $max ";

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
