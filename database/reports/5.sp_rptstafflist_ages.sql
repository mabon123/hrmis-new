DELIMITER $$

USE `hrmis_db`$$

DROP PROCEDURE IF EXISTS `sp_rptstafflist_ages`$$

CREATE PROCEDURE `sp_rptstafflist_ages`(
    IN param_pro_code VARCHAR(2),
    IN param_dis_code VARCHAR(4),
    IN param_loc_code VARCHAR(11),
    IN age_from INT,
    IN age_to INT
)
BEGIN	
	-- Cteate temp table to store result
	DROP TEMPORARY TABLE IF EXISTS `tmptbl_results`;
	CREATE TEMPORARY TABLE `tmptbl_results` (
		id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		workplace_kh VARCHAR(300) NULL,
		office_kh VARCHAR(250) NULL,
		/*---header fields---*/
		commune_kh VARCHAR(150) NULL,
		district_kh VARCHAR(150) NULL,
		province_kh VARCHAR(150) NULL,
		location_code VARCHAR(11) NULL,
		commune_en VARCHAR(50) NULL,
		district_en VARCHAR(50) NULL,
		province_en VARCHAR(50) NULL,
		workplace_en VARCHAR(100) NULL,
		/*--end header fields---*/
		
		-- Data fields
		payroll_id VARCHAR(10) NULL,
		fullname_kh VARCHAR(100) NULL,
		fullname_en VARCHAR(50) NULL,
		age INT NULL,
		sex TINYINT NULL,
		dob DATE NULL,
		salary_level VARCHAR(15) NULL,
		position_kh VARCHAR(150) NULL,
		teaching_id INT NULL,
		-- End Data fields
		
		-- Footer fields
		total_staff INT NULL,
		total_female INT NULL,
		teaching_staff INT NULL,
		non_teaching_staff INT NULL
		-- End footer fields
	) ENGINE=MYISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
	
	-- Get current academic year	
	SELECT year_id, CONVERT(SUBSTRING(year_en, 1, 4), UNSIGNED INTEGER), CONVERT(SUBSTRING(year_en, -4, 4), UNSIGNED INTEGER), CURDATE() 
	FROM sys_academic_years WHERE cur_year=1 LIMIT 1 INTO @academic_id, @year_start, @year_end, @cur_date;
	
	/*-----School------*/
	IF param_loc_code <> '' THEN
		-- Insert staff inside workplace/school
		SET @sql_str = CONCAT('INSERT INTO `tmptbl_results` (workplace_kh, office_kh, commune_kh, district_kh, province_kh, location_code, 
		commune_en, district_en, province_en, workplace_en, payroll_id, fullname_kh, fullname_en, age, sex, dob, salary_level, position_kh, teaching_id)
		SELECT l.location_kh, sys_offices.office_kh, com.name_kh, dis.name_kh, pro.name_kh, wh.location_code, com.name_en, dis.name_en, pro.name_en, 
		l.location_en, s.payroll_id, CONCAT(s.surname_kh, \' \', s.name_kh), CONCAT(s.surname_en, \' \', s.name_en), func_getAge(s.dob), s.sex, s.dob, 
		CONCAT(temp2.salary_level_kh, \'.\', temp2.salary_degree), p.position_kh, temp3.grade_id FROM hrmis_staffs AS s  
			 INNER JOIN ( hrmis_work_histories AS wh  
			 INNER JOIN sys_positions AS p ON p.position_id=wh.position_id 
			 INNER JOIN sys_locations AS l ON l.location_code=wh.location_code 
			 LEFT JOIN sys_offices ON wh.sys_admin_office_id=sys_offices.office_id
			 LEFT JOIN sys_provinces AS pro ON l.pro_code=pro.pro_code
			 LEFT JOIN sys_districts AS dis ON l.dis_code=dis.dis_code
			 LEFT JOIN sys_communes AS com ON l.com_code=com.com_code
		 ) ON s.payroll_id=wh.payroll_id
		INNER JOIN sys_staff_status AS sstatus ON s.staff_status_id=sstatus.status_id
		LEFT JOIN ( 
		   SELECT ss.payroll_id, ss.salary_degree, sl.salary_level_kh FROM hrmis_staff_salaries AS ss 
		   INNER JOIN salary_levels AS sl ON sl.salary_level_id=ss.salary_level_id 
		   WHERE ss.staff_sal_id=(
		    SELECT MAX(staff_sal_id) FROM hrmis_staff_salaries WHERE payroll_id=ss.payroll_id
			    )
		   ) AS temp2 ON s.payroll_id=temp2.payroll_id 
		LEFT JOIN ( 
		  SELECT payroll_id, IF(MAX(grade_id)=0,1,MAX(grade_id)) AS grade_id FROM hrmis_teaching_subjects
		 WHERE year_id=@academic_id GROUP BY  payroll_id
		 ) AS temp3 ON s.payroll_id=temp3.payroll_id 
		WHERE s.staff_status_id IN (1,2,7,8,10,14) AND wh.cur_pos=1 AND (wh.`contract_type_id` IS NULL OR wh.`contract_type_id` !=4 ) AND wh.location_code=\'',param_loc_code,'\' 
		AND \'',@cur_date,'\' BETWEEN IFNULL(wh.start_date, CURDATE()) AND IFNULL(wh.end_date, CURDATE())');
		 
		IF age_from > 0 THEN
			SET @sql_str := CONCAT(@sql_str, ' AND func_getAge(s.dob)>=', age_from);
		END IF;
		 
		IF age_to > 0 THEN
			SET @sql_str := CONCAT(@sql_str, ' AND func_getAge(s.dob)<=', age_to);
		END IF; 
		
		SET @sql_str := CONCAT(@sql_str, ' ORDER BY wh.location_code, wh.sys_admin_office_id, position_hierarchy;');
		
		PREPARE stmt FROM @sql_str;
		EXECUTE stmt;
		DEALLOCATE PREPARE stmt;
	/*----End School-----*/
		
	/*----District Search-----*/	
	ELSEIF param_dis_code<>'' THEN
		SET @sql_str = CONCAT('INSERT INTO `tmptbl_results` (workplace_kh, office_kh, commune_kh, district_kh, province_kh, location_code, 
		commune_en, district_en, province_en, workplace_en, payroll_id, fullname_kh, fullname_en, age, sex, dob, salary_level, position_kh, teaching_id)
		SELECT l.location_kh, sys_offices.office_kh, com.name_kh, dis.name_kh, pro.name_kh, wh.location_code, com.name_en, dis.name_en, pro.name_en, 
		l.location_en, s.payroll_id, CONCAT(s.surname_kh, \' \', s.name_kh), CONCAT(s.surname_en, \' \', s.name_en), func_getAge(s.dob), s.sex, s.dob, 
		CONCAT(temp2.salary_level_kh, \'.\', temp2.salary_degree), p.position_kh, temp3.grade_id FROM hrmis_staffs AS s  
			 INNER JOIN ( hrmis_work_histories AS wh  
			 INNER JOIN sys_positions AS p ON p.position_id=wh.position_id 
			 INNER JOIN sys_locations AS l ON l.location_code=wh.location_code 
			 LEFT JOIN sys_offices ON wh.sys_admin_office_id=sys_offices.office_id
			 LEFT JOIN sys_provinces AS pro ON l.pro_code=pro.pro_code
			 LEFT JOIN sys_districts AS dis ON l.dis_code=dis.dis_code
			 LEFT JOIN sys_communes AS com ON l.com_code=com.com_code
		 ) ON s.payroll_id=wh.payroll_id
		INNER JOIN sys_staff_status AS sstatus ON s.staff_status_id=sstatus.status_id
		LEFT JOIN ( 
		   SELECT ss.payroll_id, ss.salary_degree, sl.salary_level_kh FROM hrmis_staff_salaries AS ss 
		   INNER JOIN salary_levels AS sl ON sl.salary_level_id=ss.salary_level_id 
		   WHERE ss.staff_sal_id=(
		    SELECT MAX(staff_sal_id) FROM hrmis_staff_salaries WHERE payroll_id=ss.payroll_id
			    )
		   ) AS temp2 ON s.payroll_id=temp2.payroll_id 
		LEFT JOIN ( 
		 SELECT payroll_id, IF(MAX(grade_id)=0,1,MAX(grade_id)) AS grade_id FROM hrmis_teaching_subjects
		 WHERE year_id=@academic_id GROUP BY  payroll_id
		 ) AS temp3 ON s.payroll_id=temp3.payroll_id 
		WHERE s.staff_status_id IN (1,2,7,8,10,14) AND wh.cur_pos=1 AND (wh.`contract_type_id` IS NULL OR wh.`contract_type_id` !=4 ) AND LEFT(wh.location_code,4)=\'',param_dis_code,'\' 
		AND \'',@cur_date,'\' BETWEEN IFNULL(wh.start_date, CURDATE()) AND IFNULL(wh.end_date, CURDATE())');
		 
		IF age_from > 0 THEN
			SET @sql_str := CONCAT(@sql_str, ' AND func_getAge(s.dob)>=', age_from);
		END IF;
		 
		IF age_to > 0 THEN
			SET @sql_str := CONCAT(@sql_str, ' AND func_getAge(s.dob)<=', age_to);
		END IF; 
		
		SET @sql_str := CONCAT(@sql_str, ' ORDER BY wh.location_code, wh.sys_admin_office_id, position_hierarchy;');
		
		PREPARE stmt FROM @sql_str;
		EXECUTE stmt;
		DEALLOCATE PREPARE stmt;
	     
	/*----End District Search-----*/
	
	/*----Province Search----*/
	ELSE
		SET @sql_str = CONCAT('INSERT INTO `tmptbl_results` (workplace_kh, office_kh, commune_kh, district_kh, province_kh, location_code, 
		commune_en, district_en, province_en, workplace_en, payroll_id, fullname_kh, fullname_en, age, sex, dob, salary_level, position_kh, teaching_id)
		SELECT l.location_kh, sys_offices.office_kh, com.name_kh, dis.name_kh, pro.name_kh, wh.location_code, com.name_en, dis.name_en, pro.name_en, 
		l.location_en, s.payroll_id, CONCAT(s.surname_kh, \' \', s.name_kh), CONCAT(s.surname_en, \' \', s.name_en), func_getAge(s.dob), s.sex, s.dob, 
		CONCAT(temp2.salary_level_kh, \'.\', temp2.salary_degree), p.position_kh, temp3.grade_id FROM hrmis_staffs AS s  
			 INNER JOIN ( hrmis_work_histories AS wh  
			 INNER JOIN sys_positions AS p ON p.position_id=wh.position_id 
			 INNER JOIN sys_locations AS l ON l.location_code=wh.location_code 
			 LEFT JOIN sys_offices ON wh.sys_admin_office_id=sys_offices.office_id
			 LEFT JOIN sys_provinces AS pro ON l.pro_code=pro.pro_code
			 LEFT JOIN sys_districts AS dis ON l.dis_code=dis.dis_code
			 LEFT JOIN sys_communes AS com ON l.com_code=com.com_code
		 ) ON s.payroll_id=wh.payroll_id
		INNER JOIN sys_staff_status AS sstatus ON s.staff_status_id=sstatus.status_id
		LEFT JOIN ( 
		   SELECT ss.payroll_id, ss.salary_degree, sl.salary_level_kh FROM hrmis_staff_salaries AS ss 
		   INNER JOIN salary_levels AS sl ON sl.salary_level_id=ss.salary_level_id 
		   WHERE ss.staff_sal_id=(
		    SELECT MAX(staff_sal_id) FROM hrmis_staff_salaries WHERE payroll_id=ss.payroll_id
			    )
		   ) AS temp2 ON s.payroll_id=temp2.payroll_id 
		LEFT JOIN ( 
		 SELECT payroll_id, IF(MAX(grade_id)=0,1,MAX(grade_id)) AS grade_id FROM hrmis_teaching_subjects
		 WHERE year_id=@academic_id GROUP BY  payroll_id
		 ) AS temp3 ON s.payroll_id=temp3.payroll_id 
		WHERE s.staff_status_id IN (1,2,7,8,10,14) AND wh.cur_pos=1 AND (wh.`contract_type_id` IS NULL OR wh.`contract_type_id` !=4 )
		AND wh.pro_code=\'',param_pro_code,'\' 
		AND LEFT(wh.location_code,2)=\'',param_pro_code,'\' 
		AND \'',@cur_date,'\' BETWEEN IFNULL(wh.start_date, CURDATE()) AND IFNULL(wh.end_date, CURDATE())');
		 
		IF age_from > 0 THEN
			SET @sql_str := CONCAT(@sql_str, ' AND func_getAge(s.dob)>=', age_from);
		END IF;
		 
		IF age_to > 0 THEN
			SET @sql_str := CONCAT(@sql_str, ' AND func_getAge(s.dob)<=', age_to);
		END IF; 
		
		SET @sql_str := CONCAT(@sql_str, ' ORDER BY wh.location_code, wh.sys_admin_office_id, position_hierarchy;');
		
		PREPARE stmt FROM @sql_str;
		EXECUTE stmt;
		DEALLOCATE PREPARE stmt;
		/*----End Province Search-----*/
	END IF;
	
	-- Insert summary data
	SELECT COUNT(id), SUM(CASE sex WHEN 2 THEN 1 ELSE 0 END), 
	SUM(CASE WHEN IFNULL(teaching_id,0)>0 THEN 1 ELSE 0 END),
	SUM(CASE WHEN IFNULL(teaching_id,0)=0 THEN 1 ELSE 0 END) 
	FROM `tmptbl_results` WHERE IFNULL(payroll_id,0)<>0 
	INTO @total_staff, @total_female, @teaching_staff, @non_teaching_staff;
	
	INSERT INTO `tmptbl_results` (total_staff, total_female, teaching_staff, non_teaching_staff)
	VALUES (@total_staff, @total_female, @teaching_staff, @non_teaching_staff);
	
	-- Final Result
	SELECT * FROM `tmptbl_results`;
END$$

DELIMITER ;