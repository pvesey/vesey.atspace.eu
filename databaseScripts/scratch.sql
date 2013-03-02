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















