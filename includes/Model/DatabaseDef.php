<?php

	/**
	* Tran Tinh Chi
	* 2/12/2015
	* DatabaseDef
	*/
	class DatabaseDef
	{
		//Table constants
		const TABLE_USER = 'Users';
		const TABLE_RESTAURANT_OWNER = 'RestaurantOwner';
		const TABLE_RESTAURANT = 'Restaurant';
		const TABLE_HAS_TYPE = 'HasType';
		const TABLE_TYPE = 'Type';
		const TABLE_EMPLOYEE = 'Employee';
		const TABLE_SKILL = 'Skill';
		const TABLE_EMPLOYEE_SKILL = 'EmployeeHasSkill';
		const TABLE_POST_NEED_SKILL = 'PostNeedSkill';
		const TABLE_RECRUITMENT_POST = 'RecruitmentPost';

		//Attribute constants
		const ATTRIBUTE_USER_USERID = 'UserId';
		const ATTRIBUTE_USER_PASSWORD = 'Password';
		const ATTRIBUTE_USER_EMAIL = 'Email';
		const ATTRIBUTE_USER_USERNAME = 'UserName';
		const ATTRIBUTE_USER_BIRTHDAY = 'Birthday';
		const ATTRIBUTE_USER_FNAME = 'FName';
		const ATTRIBUTE_USER_MNAME = 'MName';
		const ATTRIBUTE_USER_LNAME = 'LName';
		const ATTRIBUTE_USER_ADDRESS = 'Address';
		const ATTRIBUTE_USER_DISTRICT = 'District';
		const ATTRIBUTE_USER_PROVINCE = 'Province';
	 	const ATTRIBUTE_USER_PHONE = 'Phone';
		const ATTRIBUTE_USER_GENDER = 'Gender';

		const ATTRIBUTE_RECRUITMENT_RPID = 'RPID';
		const ATTRIBUTE_RECRUITMENT_TITLE = 'RecruitmentTitle';
		const ATTRIBUTE_RECRUITMENT_POST_NAME = 'RecruitmentTitle';
		const ATTRIBUTE_RECRUITMENT_JOB = 'Job';
		const ATTRIBUTE_RECRUITMENT_STARTDATE = 'StartDate';
		const ATTRIBUTE_RECRUITMENT_SALARY = 'PromissedSalary';
		const ATTRIBUTE_RECRUITMENT_DATE_CREATED = 'DateCreated';
		const ATTRIBUTE_RESTAURANT_NAME = 'Name';
		const ATTRIBUTE_RESTAURANT_SKILL = 'Skill';

		const ATTRIBUTE_RESTAURANT_PROVINCE = 'Province';
		const ATTRIBUTE_RESTAURANT_DISTRICT = 'District';
		const ATTRIBUTE_RESTAURANT_RID = 'RID';
		const ATTRIBUTE_RESTAURANT_ADDRESS = 'Address';

		//Target constants 
		const TAR_USERS = 1; 
		const TAR_RESTAURANT = 2;
		const TAR_RECRUITMENT = 3; 

		//Constraint constants 
		const CTR_DISTRICT = 'District'; 
		const CTR_PROVINCE = 'Province'; 

		//Server constants 
		const DB_SERVER_NAME = 'localhost';
		const DB_USER_NAME = 'root';
		const DB_PASSWORD = '123';
		const DB_DATABASE_NAME = 'My_Restaurant';

		//Key constants 
		const KEY_TARGET = 'TARGET';
		const KEY_ATTRIBUTE = 'ATTRIBUTE'; 
		const KEY_CONSTRAINT = 'CONSTRAINT'; 
		const KEY_CONTENT = 'CONTENT'; 

		//State constants
		const NAME_STATE = 'NAME_STATE';
		const DEFINITION_STATE = 'DEFINITION_STATE';

		const STATE_LOGIN = 'LOGIN';
		const STATE_SIGNUP = 'SIGNUP';
		const STATE_SEARCH = 'SEARCH';
		const STATE_MAIN_PAGE = 'MAIN_PAGE';
		const STATE_RESTAURANT_PAGE = 'RESTAURANT_PAGE';

		//Query constants
		const MATCHED_PERCENTAGE = 'MatchedPercentage';

		//Recent activity constants
		const MAX_NUMBER_RESULTS = 'MAX_NUMBER_RESULTS';

		// Other
		const RESULT = 'RESULT'; 
	}

?>