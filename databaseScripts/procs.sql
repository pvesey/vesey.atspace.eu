
USE `1293294_cmi`;

DELIMITER $$
--
-- Procedures
--

DROP PROCEDURE IF EXISTS `procLogin`$$
CREATE PROCEDURE `procLogin`(in USERNAME VARCHAR(45), in PASS VARCHAR(45))
BEGIN
	SELECT 	txtFirstName, 
			txtSurname,
			intUserID
	FROM 	`1293294_cmi`.`tblUsers`
	WHERE
			(txtUsername = USERNAME) AND 
			(ecrPassword = PASS);
END$$




DROP PROCEDURE IF EXISTS `procModAccessLevel`$$
CREATE PROCEDURE `procModAccessLevel`(IN ModID INT, IN UserID INT)
BEGIN

SELECT 	`1293294_cmi`.`tblEnrole`.`fkeyUserCat` 

FROM 	`1293294_cmi`.`tblEnrole`

WHERE 	`1293294_cmi`.`tblEnrole`.`fkeyModule` = ModID
		AND `1293294_cmi`.`tblEnrole`.`fkeyUserID` = UserID;

END$$




DROP PROCEDURE IF EXISTS `procOverallAttendRpt`$$
CREATE PROCEDURE `procOverallAttendRpt`(IN ModID INT)
BEGIN

SELECT `1293294_cmi`.`tblAttend`.`bAttend`, 
       `1293294_cmi`.`tblClass`.`dateClassStart`,
        `1293294_cmi`.`tblAttend`.`fkeyUserID`

FROM 	`1293294_cmi`.`tblAttend`

JOIN 	`1293294_cmi`.`tblClass` 

ON 		`1293294_cmi`.`tblClass`.`intClass` = `1293294_cmi`.`tblAttend`.`fkeyClass`

WHERE 	`1293294_cmi`.`tblClass`.`fkeyModule` = ModID 

ORDER BY `1293294_cmi`.`tblClass`.`dateClassStart`;


END$$



DROP PROCEDURE IF EXISTS `procStuAttendRpt`$$
CREATE PROCEDURE `procStuAttendRpt`(IN UserID INT, IN ModID INT)
BEGIN

SELECT  `1293294_cmi`.`tblAttend`.`bAttend`, 
		`1293294_cmi`.`tblAttend`.`txtReason`,
		`1293294_cmi`.`tblClass`.`dateClassStart`

FROM 	`1293294_cmi`.`tblAttend`

JOIN 	`1293294_cmi`.`tblClass` 

ON 		`1293294_cmi`.`tblClass`.`intClass` = `1293294_cmi`.`tblAttend`.`fkeyClass`

WHERE 	`1293294_cmi`.`tblAttend`.`fkeyUserID` = UserID AND `1293294_cmi`.`tblClass`.`fkeyModule` = ModID 

ORDER BY `1293294_cmi`.`tblClass`.`dateClassStart`;

END$$



DROP PROCEDURE IF EXISTS `procUserCourses`$$
CREATE PROCEDURE `procUserCourses`(IN UserID INT)
BEGIN

SELECT  `1293294_cmi`.`tblModule`.`txtModuleName`,
		`1293294_cmi`.`tblModule`.`intModule`

FROM 	`1293294_cmi`.`tblModule`

JOIN 	`1293294_cmi`.`tblEnrole`

ON 		`1293294_cmi`.`tblEnrole`.`fkeyModule` = `1293294_cmi`.`tblModule`.`intModule`

WHERE 	`1293294_cmi`.`tblEnrole`.`fkeyUserID` = UserID;


END$$



DROP PROCEDURE IF EXISTS `procQRAttend`$$
CREATE PROCEDURE `procQRAttend`(IN KEYCLASS INT, IN USERID INT)
BEGIN
INSERT INTO `1293294_cmi`.`tblAttend`
			(`fkeyClass`,
			`fkeyUserID`,
			`dateQRLogDate`,
			`bAttend`,
			`txtReason`)
VALUES
			(
			KEYCLASS,
			USERID,
			CURRENT_TIMESTAMP,
			1,
			'NA'
			);
END$$



DROP PROCEDURE IF EXISTS `procClassMD5`$$
CREATE PROCEDURE `procClassMD5`(IN QRMD5 VARCHAR(32))
BEGIN
SELECT  `1293294_cmi`.`tblClass`.`intClass`

FROM  `1293294_cmi`.`tblClass`

WHERE 	`1293294_cmi`.`tblClass`.`qrMD5` = QRMD5;

END$$




DROP PROCEDURE IF EXISTS `procCreateClass`$$
CREATE PROCEDURE `procCreateClass`(IN MODID INT, IN CSTART DATETIME, IN CEND DATETIME, IN QR VARCHAR(32))
BEGIN
INSERT INTO `1293294_cmi`.`tblClass`
			(`fkeyModule`,
			`dateClassStart`,
			`dateClassFinish`,
			`qrMD5`)
VALUES
			(
			MODID,
			CSTART,
			CEND,
			QR
			);
END$$


DELIMITER ;


