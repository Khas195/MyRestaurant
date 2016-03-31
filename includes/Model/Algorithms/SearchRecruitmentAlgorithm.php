<?php
/**
 * Created by PhpStorm.
 * User: Tran Tinh Chi
 * Date: 12/20/15
 * Time: 11:58 AM
 */



require_once FILE_PATH('algorithms').'SearchAlgorithm.php';

class SearchRecruitmentAlgorithm extends  SearchAlgorithm {

    public function search (mysqli $conn, $content, $constraints = []) {
        $RPID = DatabaseDef::ATTRIBUTE_RECRUITMENT_RPID;
        $title = DatabaseDef::ATTRIBUTE_RECRUITMENT_TITLE;
        $curUserId = $constraints[DatabaseDef::ATTRIBUTE_USER_USERID];

        $sql = "SELECT TableResult.$RPID, TableResult.Province, TableResult.Job, TableResult.RecruitmentTitle, TableResult.Province, TableResult.District, TableResult.MatchedPercentage "
            ." From (SELECT PostNeedSkill.$RPID, Restaurant.Province, RecruitmentPost.Job, RecruitmentPost.RecruitmentTitle, Restaurant.Province, Restaurant.District, SUM((Skill.Level * EmployeeHasSkill.ExpertiseLevel)) / SUM(Skill.Level * PostNeedSkill.RequireLevelPercentage) AS MatchedPercentage "
            ." From (((((Users JOIN Employee ON Users.UserId = Employee.EID)  "
            ."     JOIN EmployeeHasSkill ON Employee.EID = EmployeeHasSkill.EID) "
            ."     JOIN Skill ON EmployeeHasSkill.SkillID = Skill.SkillID) "
            ."     JOIN PostNeedSkill ON PostNeedSkill.SkillID = Skill.SkillID) "
            ."     JOIN RecruitmentPost ON RecruitmentPost.$RPID = PostNeedSkill.$RPID) "
            ."     JOIN Restaurant ON Restaurant.RID = RecruitmentPost.RID "
            ."     WHERE Users.UserId = '$curUserId' AND "
            ."	   RecruitmentPost.$title = '$content' ";

        //var_dump($constraints);z
        unset($constraints[DatabaseDef::ATTRIBUTE_USER_USERID]);

        if (sizeof($constraints) > 0) {
            $keylist = array_keys($constraints);
            foreach ($keylist as $key) {
                $s = sizeof($constraints[$key]);

                if ($s > 0) {
                    $sql .= " AND (";
                }
                $sql .= "(1 = 2) ";

                var_dump($constraints);
                foreach ($constraints[$key] as $val) {
                    $sql .= " OR (TableResult.$key = '$val')";
                }
                if ($s > 0) {
                    $sql .= ")";
                }
            }
        }

        $sql .= "     GROUP BY PostNeedSkill.$RPID) AS TableResult ";

        echo $sql;
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