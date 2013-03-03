
-- Overall Report with each class and student listed.

SELECT 	`1293294_cmi`.`tblAttend`.`bAttend`, 
		`1293294_cmi`.`tblClass`.`dateClassStart`,
		`1293294_cmi`.`tblUsers`.`txtUsername`,
		`1293294_cmi`.`tblUsers`.`txtFirstName`,
		`1293294_cmi`.`tblUsers`.`txtSurname`


FROM 	`1293294_cmi`.`tblAttend`

JOIN 	`1293294_cmi`.`tblClass` 

ON 		`1293294_cmi`.`tblClass`.`intClass` = `1293294_cmi`.`tblAttend`.`fkeyClass`

JOIN 	`1293294_cmi`.`tblUsers` 

ON 		`1293294_cmi`.`tblUsers`.`intUserID` = `1293294_cmi`.`tblAttend`.`fkeyUserID`


WHERE 	`1293294_cmi`.`tblClass`.`fkeyModule` = 2 

ORDER BY `1293294_cmi`.`tblClass`.`dateClassStart`;


-- Overall Report with Summation

SELECT 	
		`1293294_cmi`.`tblUsers`.`txtUsername`,
		`1293294_cmi`.`tblUsers`.`txtFirstName`,
		`1293294_cmi`.`tblUsers`.`txtSurname`,
		SUM(`1293294_cmi`.`tblAttend`.`bAttend`) AS Attended

FROM 	`1293294_cmi`.`tblAttend`

JOIN 	`1293294_cmi`.`tblClass` 

ON 		`1293294_cmi`.`tblClass`.`intClass` = `1293294_cmi`.`tblAttend`.`fkeyClass`

JOIN 	`1293294_cmi`.`tblUsers` 

ON 		`1293294_cmi`.`tblUsers`.`intUserID` = `1293294_cmi`.`tblAttend`.`fkeyUserID`


WHERE 	`1293294_cmi`.`tblClass`.`fkeyModule` = 2 

GROUP BY `1293294_cmi`.`tblAttend`.`fkeyUserID`;


-- Overall Report with Percentage


SELECT @numClasses:= COUNT(`1293294_cmi`.`tblClass`.`intClass`)
FROM `1293294_cmi`.`tblClass`
WHERE `1293294_cmi`.`tblClass`.`fkeyModule` = 12;


SELECT 	
		`1293294_cmi`.`tblUsers`.`txtUsername`,
		`1293294_cmi`.`tblUsers`.`txtFirstName`,
		`1293294_cmi`.`tblUsers`.`txtSurname`,
		SUM(`1293294_cmi`.`tblAttend`.`bAttend`) AS Attended,
		(SUM(`1293294_cmi`.`tblAttend`.`bAttend`)/@numClasses)*100 AS Percent

FROM 	`1293294_cmi`.`tblAttend`

JOIN 	`1293294_cmi`.`tblClass` 

ON 		`1293294_cmi`.`tblClass`.`intClass` = `1293294_cmi`.`tblAttend`.`fkeyClass`

JOIN 	`1293294_cmi`.`tblUsers` 

ON 		`1293294_cmi`.`tblUsers`.`intUserID` = `1293294_cmi`.`tblAttend`.`fkeyUserID`


WHERE 	`1293294_cmi`.`tblClass`.`fkeyModule` = 12 

-- ORDER BY `1293294_cmi`.`tblClass`.`dateClassStart`;
GROUP BY `1293294_cmi`.`tblAttend`.`fkeyUserID`;







-- Individual Report for a Student


SELECT 	
		`1293294_cmi`.`tblUsers`.`txtUsername`,
		`1293294_cmi`.`tblUsers`.`txtFirstName`,
		`1293294_cmi`.`tblUsers`.`txtSurname`,
		`1293294_cmi`.`tblAttend`.`bAttend`, 
		`1293294_cmi`.`tblClass`.`dateClassStart`

FROM 	`1293294_cmi`.`tblAttend`

JOIN 	`1293294_cmi`.`tblClass` 

ON 		`1293294_cmi`.`tblClass`.`intClass` = `1293294_cmi`.`tblAttend`.`fkeyClass`

JOIN 	`1293294_cmi`.`tblUsers` 

ON 		`1293294_cmi`.`tblUsers`.`intUserID` = `1293294_cmi`.`tblAttend`.`fkeyUserID`


WHERE 	`1293294_cmi`.`tblClass`.`fkeyModule` = 2
AND 	`1293294_cmi`.`tblAttend`.`fkeyUserID` = 15

ORDER BY `1293294_cmi`.`tblClass`.`dateClassStart`;


-- STUDENTS REGISTERED ON PROGRAMME

SELECT 	
		`1293294_cmi`.`tblProgramme`.`txtProgName`,
		`1293294_cmi`.`tblUsers`.`txtUsername`,
		`1293294_cmi`.`tblUsers`.`txtFirstName`,
		`1293294_cmi`.`tblUsers`.`txtSurname`

FROM 	`1293294_cmi`.`tblEnrole`

JOIN 	`1293294_cmi`.`tblProgramme` 

ON 		`1293294_cmi`.`tblProgramme`.`intProg` = `1293294_cmi`.`tblEnrole`.`fkeyProg`

JOIN 	`1293294_cmi`.`tblUsers` 

ON 		`1293294_cmi`.`tblUsers`.`intUserID` = `1293294_cmi`.`tblEnrole`.`fkeyUserID`

WHERE 	`1293294_cmi`.`tblProgramme`.`intProg` = 2
AND 	`1293294_cmi`.`tblEnrole`.`fkeyUserCat` = 1		

GROUP BY `1293294_cmi`.`tblUsers`.`intUserID`;


-- Academics REGISTERED ON PROGRAMME

SELECT 	
		`1293294_cmi`.`tblProgramme`.`txtProgName`,
		`1293294_cmi`.`tblUsers`.`txtUsername`,
		`1293294_cmi`.`tblUsers`.`txtFirstName`,
		`1293294_cmi`.`tblUsers`.`txtSurname`

FROM 	`1293294_cmi`.`tblEnrole`

JOIN 	`1293294_cmi`.`tblProgramme` 

ON 		`1293294_cmi`.`tblProgramme`.`intProg` = `1293294_cmi`.`tblEnrole`.`fkeyProg`

JOIN 	`1293294_cmi`.`tblUsers` 

ON 		`1293294_cmi`.`tblUsers`.`intUserID` = `1293294_cmi`.`tblEnrole`.`fkeyUserID`

WHERE 	`1293294_cmi`.`tblProgramme`.`intProg` = 2
AND 	`1293294_cmi`.`tblEnrole`.`fkeyUserCat` = 2		

GROUP BY `1293294_cmi`.`tblUsers`.`intUserID`;



-- Students REGISTERED ON A Module

SELECT 	
		`1293294_cmi`.`tblModule`.`txtModuleName`,
		`1293294_cmi`.`tblUsers`.`txtUsername`,
		`1293294_cmi`.`tblUsers`.`txtFirstName`,
		`1293294_cmi`.`tblUsers`.`txtSurname`

FROM 	`1293294_cmi`.`tblEnrole`

JOIN 	`1293294_cmi`.`tblModule` 

ON 		`1293294_cmi`.`tblModule`.`intModule` = `1293294_cmi`.`tblEnrole`.`fkeyModule`

JOIN 	`1293294_cmi`.`tblUsers` 

ON 		`1293294_cmi`.`tblUsers`.`intUserID` = `1293294_cmi`.`tblEnrole`.`fkeyUserID`

WHERE 	`1293294_cmi`.`tblModule`.`intModule` = 2
AND 	`1293294_cmi`.`tblEnrole`.`fkeyUserCat` = 1		

GROUP BY `1293294_cmi`.`tblUsers`.`intUserID`;





-- New User

INSERT INTO `1293294_cmi`.`tblusers`
(`intUserID`,
`txtFirstName`,
`txtSurname`,
`txtUsername`,
`ecrPassword`)
VALUES
(
<{intUserID: }>,
<{txtFirstName: }>,
<{txtSurname: }>,
<{txtUsername: }>,
<{ecrPassword: }>
);


-- New Module

INSERT INTO `1293294_cmi`.`tblmodule`
(`intModule`,
`fkeyDept`,
`txtModuleName`,
`Modulecol`)
VALUES
(
<{intModule: }>,
<{fkeyDept: }>,
<{txtModuleName: }>,
<{Modulecol: }>
);

























