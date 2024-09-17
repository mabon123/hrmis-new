DELIMITER $$

USE `hrmis_db`$$

DROP PROCEDURE IF EXISTS `sp_rptstafflist_workplaces`$$

CREATE PROCEDURE `sp_rptstafflist_workplaces`(
    IN param_pro_code VARCHAR(2),
    IN param_dis_code VARCHAR(4),
    IN param_loc_code VARCHAR(11)
)
BEGIN	
	-- Get current academic year	
	SELECT year_id, CONVERT(SUBSTRING(year_en, 1, 4), UNSIGNED INTEGER), CONVERT(SUBSTRING(year_en, -4, 4), UNSIGNED INTEGER), CURDATE() 
	FROM sys_academic_years WHERE cur_year=1 LIMIT 1 INTO @academic_id, @year_start, @year_end, @cur_date;
		
	/*-----School------*/
	IF param_loc_code <> '' THEN
		SELECT l.location_kh AS workplace_kh, IF(p.`position_id` IS NULL AND sys_offices.`office_id` IS NULL,'បុគ្គលិក/មន្ត្រីកិច្ចសន្យា',sys_offices.`office_kh`) AS office_kh, com.name_kh AS commune_kh, dis.name_kh AS district_kh, pro.name_kh AS province_kh, 
		wh.location_code, com.name_en AS commune_en, dis.name_en AS district_en, pro.name_en AS province_en, l.location_en AS workplace_en, 
		s.payroll_id, CONCAT(s.surname_kh, ' ', s.name_kh) AS fullname_kh, CONCAT(s.surname_en, ' ', s.name_en) AS fullname_en, s.sex, s.dob,  
		 CONCAT(temp2.salary_level_kh, '.', temp2.salary_degree) AS salary_level, IF(p.`position_id` IS NOT NULL,p.`position_kh`,c.`cont_pos_kh`)AS position_kh, s.start_date, s.staff_status_id AS status_id, 
		 sstatus.status_kh, temp3.grade_id, 
		(SELECT qc.qualification_kh 
		   FROM hrmis_staff_qualifications AS q
		   INNER JOIN sys_qualification_codes AS qc ON q.qualification_code=qc.qualification_code
		   WHERE payroll_id=s.payroll_id
		   ORDER BY qualification_hierachy DESC LIMIT 1
        ) AS qualification_kh 
		FROM hrmis_staffs AS s  
		LEFT JOIN ( hrmis_work_histories AS wh  
			 LEFT JOIN sys_positions AS p ON p.position_id=wh.position_id 
			 LEFT JOIN `sys_contstaff_positions` c ON wh.`cont_pos_id`=c.`cont_pos_id`
			 LEFT JOIN sys_locations AS l ON l.location_code=wh.location_code 
			 LEFT JOIN sys_offices ON wh.sys_admin_office_id=sys_offices.office_id
			 LEFT JOIN sys_provinces AS pro ON l.pro_code=pro.pro_code
			 LEFT JOIN sys_districts AS dis ON l.dis_code=dis.dis_code
			 LEFT JOIN sys_communes AS com ON l.com_code=com.com_code
		 ) ON s.payroll_id=wh.payroll_id 
		LEFT JOIN sys_staff_status AS sstatus ON s.staff_status_id=sstatus.status_id
		LEFT JOIN ( 
		   SELECT ss.payroll_id, ss.salary_degree, sl.salary_level_kh FROM hrmis_staff_salaries AS ss 
		   LEFT JOIN salary_levels AS sl ON sl.salary_level_id=ss.salary_level_id 
		   WHERE ss.salary_type_shift_date=(
		    	SELECT MAX(salary_type_shift_date) FROM hrmis_staff_salaries WHERE payroll_id=ss.payroll_id
			)
		) AS temp2 ON s.payroll_id=temp2.payroll_id 
		LEFT JOIN ( 
		 SELECT DISTINCT payroll_id, IF(MAX(grade_id)=0,1,MAX(grade_id)) AS grade_id FROM `timetable_teacher_subjects` 
		 INNER JOIN `timetables`  ON `timetables`.`teacher_subject_id`=`timetable_teacher_subjects`.`teacher_subject_id` WHERE `timetable_teacher_subjects`.`academic_id`=@academic_id AND `timetable_teacher_subjects`.grade_id NOT IN (32,33,34) GROUP BY  payroll_id
		UNION
		SELECT `timetable_teacher_primary`.payroll_id, IF(MAX(`timetable_grades`.grade_id)=0,1,MAX(`timetable_grades`.grade_id)) AS grade_id FROM `timetable_teacher_primary` INNER JOIN `timetable_grades` ON `timetable_teacher_primary`.`tgrade_id`=`timetable_grades`.`tgrade_id`
		WHERE `timetable_teacher_primary`.`academic_id`=@academic_id AND `timetable_grades`.grade_id NOT IN (32,33,34) GROUP BY  `timetable_teacher_primary`.payroll_id
		 ) AS temp3 ON s.payroll_id=temp3.payroll_id 
		WHERE s.staff_status_id IN (1,2,7,8,10) AND wh.cur_pos=1 AND (wh.`contract_type_id` IS NULL OR wh.`contract_type_id` !=4 )
			-- AND wh.pro_code=param_pro_code 
			AND wh.location_code=param_loc_code
			-- AND @cur_date BETWEEN IFNULL(wh.start_date, CURDATE()) AND IFNULL(wh.end_date, CURDATE())
		ORDER BY wh.location_code, wh.sys_admin_office_id,s.`is_cont_staff` ASC, p.position_hierarchy  ASC;
	/*----End School-----*/
		
	/*----District Search-----*/	
	ELSEIF param_dis_code<>'' THEN
		SELECT l.location_kh AS workplace_kh, IF(p.`position_id` IS NULL AND sys_offices.`office_id` IS NULL,'បុគ្គលិក/មន្ត្រីកិច្ចសន្យា',sys_offices.`office_kh`) AS office_kh, com.name_kh AS commune_kh, dis.name_kh AS district_kh, pro.name_kh AS province_kh, 
		wh.location_code, com.name_en AS commune_en, dis.name_en AS district_en, pro.name_en AS province_en, l.location_en AS workplace_en, 
		s.payroll_id, CONCAT(s.surname_kh, ' ', s.name_kh) AS fullname_kh, CONCAT(s.surname_en, ' ', s.name_en) AS fullname_en, s.sex, s.dob,  
		 CONCAT(temp2.salary_level_kh, '.', temp2.salary_degree) AS salary_level, IF(p.`position_id` IS NOT NULL,p.`position_kh`,c.`cont_pos_kh`)AS position_kh, s.start_date, s.staff_status_id AS status_id, 
		 sstatus.status_kh, temp3.grade_id, 
		(SELECT qc.qualification_kh 
		   FROM hrmis_staff_qualifications AS q
		   INNER JOIN sys_qualification_codes AS qc ON q.qualification_code=qc.qualification_code
		   WHERE payroll_id=s.payroll_id
		   ORDER BY qualification_hierachy DESC LIMIT 1
        ) AS qualification_kh 
		FROM hrmis_staffs AS s  
		LEFT JOIN ( hrmis_work_histories AS wh  
			 LEFT JOIN sys_positions AS p ON p.position_id=wh.position_id 
			 LEFT JOIN `sys_contstaff_positions` c ON wh.`cont_pos_id`=c.`cont_pos_id`
			 LEFT JOIN sys_locations AS l ON l.location_code=wh.location_code 
			 LEFT JOIN sys_offices ON wh.sys_admin_office_id=sys_offices.office_id
			 LEFT JOIN sys_provinces AS pro ON l.pro_code=pro.pro_code
			 LEFT JOIN sys_districts AS dis ON l.dis_code=dis.dis_code
			 LEFT JOIN sys_communes AS com ON l.com_code=com.com_code
		 ) ON s.payroll_id=wh.payroll_id 
		LEFT JOIN sys_staff_status AS sstatus ON s.staff_status_id=sstatus.status_id
		LEFT JOIN ( 
		   SELECT ss.payroll_id, ss.salary_degree, sl.salary_level_kh FROM hrmis_staff_salaries AS ss 
		   LEFT JOIN salary_levels AS sl ON sl.salary_level_id=ss.salary_level_id 
		   WHERE ss.salary_type_shift_date=(
		    	SELECT MAX(salary_type_shift_date) FROM hrmis_staff_salaries WHERE payroll_id=ss.payroll_id
			)
		) AS temp2 ON s.payroll_id=temp2.payroll_id 
		LEFT JOIN ( 
		 SELECT DISTINCT payroll_id, IF(MAX(grade_id)=0,1,MAX(grade_id)) AS grade_id FROM `timetable_teacher_subjects` 
		 INNER JOIN `timetables`  ON `timetables`.`teacher_subject_id`=`timetable_teacher_subjects`.`teacher_subject_id` WHERE `timetable_teacher_subjects`.`academic_id`=@academic_id AND `timetable_teacher_subjects`.grade_id NOT IN (32,33,34) GROUP BY  payroll_id
		UNION
		SELECT `timetable_teacher_primary`.payroll_id, IF(MAX(`timetable_grades`.grade_id)=0,1,MAX(`timetable_grades`.grade_id)) AS grade_id FROM `timetable_teacher_primary` INNER JOIN `timetable_grades` ON `timetable_teacher_primary`.`tgrade_id`=`timetable_grades`.`tgrade_id`
		WHERE `timetable_teacher_primary`.`academic_id`=@academic_id AND `timetable_grades`.grade_id NOT IN (32,33,34) GROUP BY  `timetable_teacher_primary`.payroll_id
		 ) AS temp3 ON s.payroll_id=temp3.payroll_id 
		WHERE s.staff_status_id IN (1,2,7,8,10,14) AND wh.cur_pos=1 AND (wh.`contract_type_id` IS NULL OR wh.`contract_type_id` !=4 )
			-- AND wh.pro_code=param_pro_code 
			AND LEFT(wh.location_code,4)=param_dis_code 
			-- AND @cur_date BETWEEN IFNULL(wh.start_date, CURDATE()) AND IFNULL(wh.end_date, CURDATE())
		ORDER BY wh.location_code, wh.sys_admin_office_id,s.`is_cont_staff` ASC, p.position_hierarchy ASC;
	     
	/*----End District Search-----*/
	
	/*----Province Search----*/
	ELSE
		SELECT l.location_kh AS workplace_kh, IF(p.`position_id` IS NULL AND sys_offices.`office_id` IS NULL,'បុគ្គលិក/មន្ត្រីកិច្ចសន្យា',sys_offices.`office_kh`) AS office_kh, com.name_kh AS commune_kh, dis.name_kh AS district_kh, pro.name_kh AS province_kh, 
		wh.location_code, com.name_en AS commune_en, dis.name_en AS district_en, pro.name_en AS province_en, l.location_en AS workplace_en, 
		s.payroll_id, CONCAT(s.surname_kh, ' ', s.name_kh) AS fullname_kh, CONCAT(s.surname_en, ' ', s.name_en) AS fullname_en, s.sex, s.dob,  
		CONCAT(temp2.salary_level_kh, '.', temp2.salary_degree) AS salary_level, IF(p.`position_id` IS NOT NULL,p.`position_kh`,c.`cont_pos_kh`)AS position_kh, s.start_date, s.staff_status_id AS status_id, 
		sstatus.status_kh, temp3.grade_id, 
		(SELECT qc.qualification_kh 
		   FROM hrmis_staff_qualifications AS q
		   INNER JOIN sys_qualification_codes AS qc ON q.qualification_code=qc.qualification_code
		   WHERE payroll_id=s.payroll_id
		   ORDER BY qualification_hierachy DESC LIMIT 1
        ) AS qualification_kh 
		FROM hrmis_staffs AS s  
		LEFT JOIN ( hrmis_work_histories AS wh  
			 LEFT JOIN sys_positions AS p ON p.position_id=wh.position_id
			 LEFT JOIN `sys_contstaff_positions` c ON wh.`cont_pos_id`=c.`cont_pos_id`
			 LEFT JOIN sys_locations AS l ON l.location_code=wh.location_code 
			 LEFT JOIN sys_offices ON wh.sys_admin_office_id=sys_offices.office_id
			 LEFT JOIN sys_provinces AS pro ON l.pro_code=pro.pro_code
			 LEFT JOIN sys_districts AS dis ON l.dis_code=dis.dis_code
			 LEFT JOIN sys_communes AS com ON l.com_code=com.com_code
		 ) ON s.payroll_id=wh.payroll_id 
		LEFT JOIN sys_staff_status AS sstatus ON s.staff_status_id=sstatus.status_id
		LEFT JOIN ( 
		   SELECT ss.payroll_id, ss.salary_degree, sl.salary_level_kh FROM hrmis_staff_salaries AS ss 
		   INNER JOIN salary_levels AS sl ON sl.salary_level_id=ss.salary_level_id 
		   WHERE ss.salary_type_shift_date=(
		    	SELECT MAX(salary_type_shift_date) FROM hrmis_staff_salaries WHERE payroll_id=ss.payroll_id
			)
		) AS temp2 ON s.payroll_id=temp2.payroll_id 
		LEFT JOIN ( 
		SELECT DISTINCT payroll_id, IF(MAX(grade_id)=0,1,MAX(grade_id)) AS grade_id FROM `timetable_teacher_subjects` 
		 INNER JOIN `timetables`  ON `timetables`.`teacher_subject_id`=`timetable_teacher_subjects`.`teacher_subject_id` WHERE `timetable_teacher_subjects`.`academic_id`=@academic_id AND `timetable_teacher_subjects`.grade_id NOT IN (32,33,34) GROUP BY  payroll_id
		UNION
		SELECT `timetable_teacher_primary`.payroll_id, IF(MAX(`timetable_grades`.grade_id)=0,1,MAX(`timetable_grades`.grade_id)) AS grade_id FROM `timetable_teacher_primary` INNER JOIN `timetable_grades` ON `timetable_teacher_primary`.`tgrade_id`=`timetable_grades`.`tgrade_id`
		WHERE `timetable_teacher_primary`.`academic_id`=@academic_id AND `timetable_grades`.grade_id NOT IN (32,33,34) GROUP BY  `timetable_teacher_primary`.payroll_id
		 ) AS temp3 ON s.payroll_id=temp3.payroll_id 
		WHERE s.staff_status_id IN (1,2,7,8,10,14) AND wh.cur_pos=1 AND (wh.`contract_type_id` IS NULL OR wh.`contract_type_id` !=4 ) AND wh.pro_code=param_pro_code 
			AND LEFT(wh.location_code,2)=param_pro_code 
			-- AND IFNULL(wh.sys_admin_office_id,0)=0
			-- AND @cur_date BETWEEN IFNULL(wh.start_date, CURDATE()) AND IFNULL(wh.end_date, CURDATE())
		ORDER BY wh.location_code, wh.sys_admin_office_id,s.`is_cont_staff` ASC, p.position_hierarchy ASC;
	END IF;
	/*----End province search---*/
END$$

DELIMITER ;