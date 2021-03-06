CREATE DATABASE My_Restaurant;

USE My_Restaurant;

# Alter ERD Diagram, many to many relationship between employee and skill
# Missing GPS Location,Payment

CREATE TABLE Users
(
	UserId nvarchar(100) UNIQUE NOT NULL,
	UserName nvarchar(16) NOT NULL,
	Birthday date,
	Password nvarchar(50)NOT NULL,
	FName  nvarchar (20),
	MName  nvarchar (20),
	LName  nvarchar (20),
	Address  nvarchar (150),
	District nvarchar(25),
	Province nvarchar(25),
	Phone nvarchar(20),
	Email nvarchar(50) UNIQUE,
	Approval int,
	Gender char(1),
	RegisterDate date NOT NULL,

	
	
	PRIMARY KEY (UserId)
);

CREATE TABLE RestaurantOwner
(
	ROID int UNIQUE NOT NULL,
	RestaurantNum int NOT NULL,
	UserID nvarchar(100) UNIQUE NOT NULL,
	PRIMARY KEY (ROID)	
);

CREATE TABLE Restaurant
(
	RID int UNIQUE NOT NULL,
	RName nvarchar(100) NOT NULL,
	Address  nvarchar (150) NOT NULL,
	District nvarchar(25) NOT NULL,
	Province nvarchar(25)  NOT NULL,
	Phone int,
	Descriptions  nvarchar (500),
	CloseTime datetime,
	OpenTime datetime,
	Status char NOT NULL,
	EstablishDate date NOT NULL,
	ROID int UNIQUE NOT NULL,
	PRIMARY KEY (RID)
	
);

CREATE TABLE HasType
(
	TID int NOT NULL,
	RID int UNIQUE NOT NULL,
	PRIMARY KEY (TID,RID)
);

CREATE TABLE Type
(
	TID int UNIQUE NOT NULL,
	Category  nvarchar (150),
	Country  nvarchar (30),
	PRIMARY KEY (TID)
);


CREATE TABLE Employee
(
	EID int UNIQUE NOT NULL,
	TotalSalary int,
	UserID nvarchar(100) UNIQUE NOT NULL,
	PRIMARY KEY (EID)

);

CREATE TABLE Skill
(
	SkillID int UNIQUE NOT NULL,
	Descriptions  nvarchar (150),
	Level int,
	PRIMARY KEY (SkillID)
);
# Alter ERD Diagram, many to many relationship between employee and skill

CREATE TABLE EmployeeHasSkill
(
	EID int NOT NULL,
	SkillID int  NOT NULL,
	ExpertiseLevel float NOT NULL,
	PRIMARY KEY (EID,SkillID)

);



CREATE TABLE PostNeedSkill
(
	RequireLevelPercentage float NOT NULL,
	SkillID int NOT NULL,
	RPID int NOT NULL,
	PRIMARY KEY (RPID,SkillID)
);

CREATE TABLE RecruitmentPost
(
	RPID int UNIQUE NOT NULL,
	RecruitmentTitle nvarchar(50) NOT NULL,
	PromissedSalary float NOT NULL,
	StartDate date NOT NULL,
	WorkingTime time NOT NULL,
	Job nvarchar(18)NOT NULL,
	MinAge int NOT NULL,
	MaxAge int NOT NULL,
	Gender int NOT NULL,
	RID int  NOT NULL,
	DateCreated date,
	PRIMARY KEY (RPID)
	 
	
);


CREATE TABLE District
(
	DistrictName nvarchar(25) UNIQUE NOT NULL,
	PRIMARY KEY(DistrictName)
);

CREATE TABLE Province
(
	ProvinceName nvarchar(25) UNIQUE NOT NULL,
	PRIMARY KEY(ProvinceName)
);

CREATE TABLE UserImage
(
	UsersID nvarchar(100) NOT NULL,
	ImageLink nvarchar(200),
	PRIMARY KEY(UsersID, ImageLink)
	
);


CREATE TABLE RestaurantImage
(
	RestaurantID nvarchar(100) NOT NULL,
	ImageLink nvarchar(200),
	PRIMARY KEY(RestaurantID, ImageLink)
	
);

CREATE TABLE BANNER
(
	BannerId nvarchar(50) UNIQUE NOT NULL,
	LinkPic nvarchar(200),
	LinkPage nvarchar(200),
	PRIMARY KEY (BannerId)
	
);

ALTER TABLE Users
ADD CONSTRAINT chk_Password check(len(Password)>=6);
ALTER TABLE Users
ADD CONSTRAINT chk_UserName check(len(UserName)>=3 AND len(UserName)<=15);

ALTER TABLE RecruitmentPost
ADD CONSTRAINT chk_Job check(len(Job)<=18);

ALTER TABLE Users
ADD CONSTRAINT chk_Gender check(Gender='F' OR Gender='M');


ALTER TABLE Users
ADD CONSTRAINT chk_UserId check (UserId NOT LIKE  '%[^A-Z0-9]%' );

ALTER TABLE Users
ADD CONSTRAINT chk_Address check (Addr NOT LIKE  '%[^A-Z0-9a-z,._ ]%');

ALTER TABLE Users
ADD CONSTRAINT chk_Approval check(Approval>=0);

ALTER TABLE Skill
ADD CONSTRAINT chk_level check(level between 0 And 10);

ALTER TABLE EmployeeHasSkill
ADD CONSTRAINT chk_Expertise check(ExpertiseLevel between 0 And 10);

ALTER TABLE PostNeedSkill
ADD CONSTRAINT chk_RequireLevel check(RequireLevelPercentage between 0 And 10);

ALTER TABLE Users
ADD CONSTRAINT chk_Phone check (LEFT(Phone,1)='+'AND substring(Phone,2,10) NOT LIKE '%[^0-9]%'OR Phone NOT LIKE '%[^0-9]%');


ALTER TABLE Users
ADD CONSTRAINT chk_EMail check (EMail LIKE '%_@_%_.__%');


 
ALTER TABLE RestaurantOwner 
ADD CHECK (RestaurantNum>0);

ALTER TABLE RecruitmentPost 
ADD CHECK (PromissedSalary>0);

ALTER TABLE Restaurant
ADD FOREIGN KEY (ROID) REFERENCES  RestaurantOwner (ROID);

ALTER TABLE RestaurantOwner
ADD FOREIGN KEY (UserID) REFERENCES  Users (UserId);

ALTER TABLE Employee
ADD FOREIGN KEY (UserID) REFERENCES  Users (UserId);



ALTER TABLE RecruitmentPost
ADD CONSTRAINT chk_Title check (RecruitmentTitle NOT LIKE  '%[^A-Z0-9_ ]%' );


ALTER TABLE Users
ADD FOREIGN KEY (District) REFERENCES  District (DistrictName);

ALTER TABLE Users
ADD FOREIGN KEY (Province) REFERENCES  Province (ProvinceName);

ALTER TABLE Restaurant
ADD FOREIGN KEY (District) REFERENCES  District (DistrictName);

ALTER TABLE Restaurant
ADD FOREIGN KEY (Province) REFERENCES  Province (ProvinceName);



ALTER TABLE HasType 
ADD FOREIGN KEY (TID) REFERENCES  Type (TID);

ALTER TABLE EmployeeHasSkill 
ADD FOREIGN KEY (EID) REFERENCES  Employee (EID);

ALTER TABLE EmployeeHasSkill 
ADD FOREIGN KEY (SkillID) REFERENCES  Skill (SkillID);

ALTER TABLE PostNeedSkill 
ADD FOREIGN KEY (RPID) REFERENCES  RecruitmentPost (RPID);

ALTER TABLE PostNeedSkill 
ADD FOREIGN KEY (SkillID) REFERENCES  Skill (SkillID);

ALTER TABLE Users
ADD FOREIGN KEY (District) REFERENCES District (DistrictName);

ALTER TABLE Users
ADD FOREIGN KEY (Province) REFERENCES Province (ProvinceName);

INSERT INTO District (DistrictName)
VALUES 
('1'),
('2'),
('3'),
('4'),
('5'),
('6'),
('Ninh Kieu'),
('Binh Thanh');

INSERT INTO Province (ProvinceName)
VALUES 
('HCM'),
('Can Tho');


 

# DELIMITER $$
# CREATE TRIGGER `InsertAge`
# BEFORE INSERT ON `Users`
# FOR EACH ROW
# BEGIN
#	SET NEW.Age  =  year(NOW())- year(NEW.Birthday);
# END;
# $$
# DELIMITER ;

 
INSERT INTO Users (UserName,UserId,Password,FName, MName, LName,Phone,Address, District,Province,Approval,EMail,Birthday,RegisterDate)
VALUES ('Fck1','A1', '123a11', 'An', N'Văn', N'Lê', 0908311000,N'1 Nguyễn Trãi,Phường 2 ','5', 'HCM', 1,'Manager1@B1tches.vn','19/2/1995','2003-11-15'),
('Fck1','A2', '123a00', 'Anh', N'Kim', N'Nguyễn', 09083112,N'1 Nguyễn Trãi','1', 'HCM', 1,'Manager2@B1tches.vn','19/2/1995','2003-12-11'),
 ('Fck2','A3', '123a01', 'Can', N'Văn', N'Đinh', 0908888000,N'1 Nguyễn Trãi','2', 'HCM', 1,'Manager3@B1tches.vn','19/2/1995','2003-9-8'),
 ('Fck3','A4', '123a02', N'Tiến', N'Văn', N'Vũ', 0908311000,N'1 Nguyễn Trãi','1', 'HCM', 1,'Manager4@B1tches.vn','19/2/1995','2003-7-1'),
 ('Fck4','A5', '123a03', N'Ánh', N'Văn', N'Mai', 0908999000,N'1 Nguyễn Trãi','Ninh Kieu', 'Can Tho', 1,'Manager5@B1tches.vn','10/8/1995','2003-6-6'),
 ('Fck5','A6', '123a04', N'Duy', N'Văn', N'Lê', 0908311000,N'1 Nguyễn Trãi','5', 'HCM', 1,'Manager6@B1tches.vn','19/2/1995','2003-1-2'),
 ('Fck6','A7', '123a05', N'Phương', N'Hồng', N'Lê', 0908311000,N'1 Nguyễn Trãi','Binh Thanh', 'HCM', 1,'Manager7@B1tches.vn','19/6/1995','2003-5-5'),
 ('Fck7','A8', '123a06', N'Bảo', N'Văn', N'Nguyễn', 0908311000,N'1 Nguyễn Trãi','4', 'HCM', 1,'Manager8@B1tches.vn','19/2/1995','2003-4-4'),
 ('Fck8','A9', '123a07', N'Chí', N'Văn', N'Lê', 0908311000,N'1 Nguyễn Trãi','6', 'HCM', 1,'Manager9@B1tches.vn','19/2/1995','2003-3-3'),
 ('Fck9','A10', '123a08', N'Chánh', N'Văn', N'Lê', 0908311000,N'1 Nguyễn Trãi','1', 'HCM', 1,'Manager10@B1tches.vn','19/2/1995','2003-2-2'),
 ('Fck10','A11', '123a09', N'Hoa', N'Thị', N'Lê', 0908311000,N'1 Nguyễn Trãi','2', 'HCM',1,'Manager11@B1tches.vn','19/2/1995','2003-1-1');


INSERT INTO RestaurantOwner(UserID,ROID,RestaurantNum)
VALUES('A1',100,1),
('A2',101,1),
('A3',102,1),
('A4',103,1),
('A5',104,2),
('A6',105,1),
('A7',106,3),
('A8',107,1),
('A9',108,1),
('A10',109,4),
('A11',110,2);

INSERT INTO Restaurant(ROID,RID,Address, District,Province,Descriptions,OpenTime,CloseTime,Phone,Status,EstablishDate,RName)
VALUES(100,1000,' ','1', 'HCM',' ',0800,2200,090123456,1,'20001209','Sakura'),
(101,1001,' ','2', 'HCM',' ',0800,2200,090123456,1,'20001209','Sakura'),
(102,1002,' ','5', 'HCM',' ',0800,2200,090123456,1,'20001209','Sumo'),
(103,1003,' ','3', 'HCM',' ',0800,2200,090123456,1,'20001209','Sakura'),
(104,1004,' ','Binh Thanh', 'HCM',' ',0800,2200,090123456,1,'20001209','Sakura'),
(105,1005,' ','Ninh Kieu', 'Can Tho',' ',0800,2200,090123456,1,'20001209','Sakura'),
(106,1006,' ','6', 'HCM',' ',0800,2200,090123456,1,'20001209','Sakura'),
(107,1007,' ','1', 'HCM',' ',0800,2200,090123456,1,'20001209','Sakura'),
(108,1008,' ','2', 'HCM',' ',0800,2200,090123456,1,'20001209','Sakura'),
(109,1009,' ','Binh Thanh', 'HCM',' ',0800,2200,090123456,1,'20001209','Sakura'),
(110,1010,' ','5', 'HCM',' ',0800,2200,090123456,1,'20001209','Sakura');
 
 INSERT INTO Type (TID,Category,Country)
 VALUES (3000, 'BBQ', 'Korea'),
 (3001, 'Sushi', 'Japan');
 
 INSERT INTO HasType(RID,TID)
 VALUES(1000,3000),
(1001,3000),
(1002,3000),
(1003,3000),
(1004,3000),
(1005,3000),
(1006,3000),
(1007,3000),
(1008,3000),
(1009,3000),
(1010,3000);

INSERT INTO Employee(EID,TotalSalary,UserId)
VALUES 
(510000,0,'A1'),
(510001,0,'A3'),
(510002,0,'A4'),
(510003,0,'A5'),
(510004,0,'A6'),
(510005,0,'A7'),
(510006,0,'A8'),
(510007,0,'A9'),
(510008,0,'A10'),
(510009,0,'A11');

INSERT INTO Skill(SkillID,Descriptions,Level)
VALUES(6100,' ',2),
(6101,' ',5),
(6102,' ',5),
(6103,' ',8),
(6104,' ',5),
(6105,' ',10),
(6106,' ',9),
(6107,' ',6),
(6108,' ',7),
(6109,' ',6),
(6110,' ',8);

INSERT INTO EmployeeHasSkill(EID,SkillID,ExpertiseLevel)
VALUES 
(510000,6100,0.3),
(510001,6100,0.3),
(510002,6100,0.5),
(510003,6100,0.7),
(510004,6100,0.9),
(510005,6100,1.0),
(510006,6100,0.2),
(510007,6100,0.3),
(510008,6100,0.4),
(510009,6100,0.7),
(510000,6101,0.6),
(510001,6101,0.5),
(510002,6101,0.8),
(510003,6101,0.9),
(510004,6101,1.0),
(510006,6101,0.4),
(510008,6101,0.3),
(510009,6101,1.0),
(510000,6102,0.4),
(510001,6102,0.8),
(510002,6102,0.2),
(510004,6102,0.9),
(510005,6102,0.8),
(510007,6102,0.3),
(510008,6102,0.2),
(510009,6102,0.2),
(510000,6103,0.8),
(510001,6103,0.6),
(510002,6103,0.7),
(510003,6103,0.9),
(510004,6103,0.3),
(510005,6103,0.5),
(510004,6104,0.9),
(510005,6104,1.0),
(510006,6104,0.2),
(510007,6104,0.3),
(510008,6104,0.4),
(510009,6104,0.7),
(510002,6105,0.9),
(510005,6105,1.0),
(510006,6105,0.2),
(510004,6105,0.3),
(510008,6105,0.4),
(510009,6105,0.7),
(510006,6106,0.2),
(510007,6106,0.3),
(510008,6106,0.4),
(510009,6106,0.7),
(510000,6106,0.6),
(510001,6106,0.5),
(510002,6107,0.8),
(510003,6107,0.9),
(510004,6107,1.0),
(510006,6107,0.4),
(510008,6108,0.3),
(510009,6108,0.1),
(510000,6108,0.4),
(510001,6108,0.8),
(510002,6108,0.2),
(510004,6108,0.9),
(510005,6108,0.8);

INSERT INTO RecruitmentPost(RPID,RID,Job,PromissedSalary,StartDate,WorkingTime,RecruitmentTitle,Gender,MinAge,MaxAge)
VALUES (900000,1000,N'Bồi bàn',2000000,'20151130','0800',N'Tuyển nhân viên làm thêm',1,18,25),
(900001,1001,N'Bồi bàn',2000000,'20151130','0800',N'Tuyển nhân viên làm thêm',2,18,25),
(900002,1002,N'Bồi bàn',2000000,'20151130','0800',N'Tuyển nhân viên làm thêm',3,18,25),
(900003,1000,N'Bồi bàn',2000000,'20151130','0800',N'Tuyển nhân viên làm thêm',1,18,25),
(900004,1004,N'Bồi bàn',2000000,'20151130','0800',N'Tuyển nhân viên làm thêm',2,18,25),
(900005,1000,N'Bồi bàn',2000000,'20151130','0800',N'Tuyển nhân viên làm thêm',2,18,25),
(900006,1007,N'Bồi bàn',2000000,'20151130','0800',N'Tuyển nhân viên làm thêm',3,18,25),
(900007,1000,N'Bồi bàn',2000000,'20151130','0800',N'Tuyển nhân viên làm thêm',1,18,25),
(900008,1000,N'Bồi bàn',2000000,'20151130','0800',N'Tuyển nhân viên làm thêm',1,18,25);

INSERT INTO PostNeedSkill(RPID,SkillID,RequireLevelPercentage)
VALUES 
(900000,6100,1.0),
(900001,6100,0.7),
(900002,6100,0.5),
(900003,6100,0.73),
(900004,6100,0.85),
(900005,6100,0.98),
(900006,6100,0.43),
(900007,6100,0.915),
(900008,6100,0.822),
(900000,6101,0.735),
(900001,6101,0.345),
(900002,6101,0.75),
(900003,6101,0.58),
(900004,6101,0.51),
(900005,6101,0.612),
(900006,6101,0.909),
(900007,6101,0.766),
(900008,6101,0.517),
(900000,6102,0.92),
(900001,6102,0.33),
(900002,6102,0.53),
(900005,6102,1.0),
(900006,6102,0.71),
(900007,6102,0.93),
(900008,6102,0.722),
(900000,6103,0.702),
(900001,6103,0.813),
(900002,6103,0.99),
(900003,6103,0.88),
(900004,6103,0.78),
(900005,6103,0.94),
(900000,6104,0.97),
(900001,6104,0.72),
(900002,6104,0.7),
(900003,6104,0.8),
(900004,6104,0.81),
(900005,6104,0.44),
(900006,6104,0.725),
(900007,6104,0.42),
(900008,6104,0.762),
(900000,6105,0.869),
(900001,6105,0.811),
(900002,6105,0.712),
(900003,6105,0.871),
(900005,6105,0.612),
(900006,6105,0.714),
(900007,6105,0.539),
(900008,6105,0.74),
(900000,6106,0.62),
(900001,6106,0.52),
(900002,6106,0.53),
(900005,6106,0.77),
(900006,6106,0.71),
(900007,6106,0.9),
(900008,6106,0.75),
(900000,6107,0.7),
(900001,6107,0.8),
(900002,6107,0.9),
(900003,6107,0.602),
(900004,6107,0.5),
(900005,6107,1.0);



INSERT INTO UserImage (UsersID,ImageLink)
VALUES ('A1','linkImage01'),
('A2','linkImage01'),
('A1','linkImage05'),
('A2','linkImage03'),
('A3','linkImage02');


INSERT INTO RestaurantImage (RestaurantID,ImageLink)
VALUES ('1001','linkImage01'),
('1002','linkImage01'),
('1003','linkImage05'),
('1004','linkImage03'),
('1005','linkImage02');

INSERT INTO BANNER(BannerId,LinkPage,LinkPic)
VALUES ('B001','http:/linkPage01','linkPic01'),
('B002','http:/linkPage02','linkPic02'),
('B003','http:/linkPage03','linkPic03'),
('B004','http:/linkPage04','linkPic04'),
('B005','http:/linkPage05','linkPic05');







INSERT INTO Users (UserName,UserId,Password,FName, MName, LName,Phone,Address, District,Province,Approval,EMail,Birthday,RegisterDate)
VALUES ('Fck12','A12', '123a11', 'An', N'Văn', N'Lê', 0908311000,N'1 Nguyễn Trãi,Phường 2 ','2', 'HCM', 1,'Manager12@B1tches.vn','1995-10-10','2004-3-4');

INSERT INTO Employee(EID,TotalSalary,UserId)
VALUES 
(510011,0,'A12');

INSERT INTO Skill(SkillID,Descriptions,Level)
VALUES(6111,' ',2);

INSERT INTO EmployeeHasSkill(EID,SkillID,ExpertiseLevel)
VALUES 
(510011,6111,0.4);

INSERT INTO PostNeedSkill(RPID,SkillID,RequireLevelPercentage)
VALUES 
(900000,6111,1.0);


INSERT INTO PostNeedSkill(RPID,SkillID,RequireLevelPercentage)
VALUES 
(900001,6111,1.0);