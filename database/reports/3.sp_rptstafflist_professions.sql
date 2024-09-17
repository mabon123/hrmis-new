DELIMITER $$

USE `hrmis_db`$$

DROP PROCEDURE IF EXISTS `sp_rptstafflist_professions`$$

CREATE PROCEDURE `sp_rptstafflist_professions`(
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
		SELECT l.location_kh AS workplace_kh, sys_offices.office_kh, com.name_kh AS commune_kh, dis.name_kh AS district_kh, pro.name_kh AS province_kh, 
		wh.location_code, com.name_en AS commune_en, dis.name_en AS district_en, pro.name_en AS province_en, l.location_en AS workplace_en, 
		s.payroll_id, CONCAT(s.surname_kh, ' ', s.name_kh) AS fullname_kh, CONCAT(s.surname_en, ' ', s.name_en) AS fullname_en, s.sex, s.dob,  
		CONCAT(temp2.salary_level_kh, '.', temp2.salary_degree) AS salary_level, p.position_kh, 
		(SELECT subject_kh FROM hrmis_staff_professions 
			INNER JOIN sys_professional_categories 
			ON hrmis_staff_professions.prof_category_id = sys_professional_categories.prof_category_id
			 INNER JOIN sys_subjects ON hrmis_staff_professions.subject_id1=sys_subjects.subject_id
			    WHERE hrmis_staff_professions.payroll_id=s.payroll_id
			ORDER BY sys_professional_categories.prof_hierachy LIMIT 1
		) AS subject_1, 
        (SELECT subject_kh FROM hrmis_staff_professions 
			INNER JOIN sys_professional_categories 
			ON hrmis_staff_professions.prof_category_id = sys_professional_categories.prof_category_id
			 INNER JOIN sys_subjects ON hrmis_staff_professions.subject_id2=sys_subjects.subject_id
			    WHERE hrmis_staff_professions.payroll_id=s.payroll_id
			ORDER BY sys_professional_categories.prof_hierachy LIMIT 1
		) AS subject_2,
        (SELECT prof_category_kh FROM hrmis_staff_professions 
            INNER JOIN sys_professional_categories 
            ON hrmis_staff_professions.prof_category_id=sys_professional_categories.prof_category_id
            WHERE hrmis_staff_professions.payroll_id=s.payroll_id
            ORDER BY sys_professional_categories.prof_hierachy LIMIT 1
		) AS profession_kh,
        (SELECT qc.qualification_kh 
		   FROM hrmis_staff_qualifications AS q
		   INNER JOIN sys_qualification_codes AS qc ON q.qualification_code=qc.qualification_code
		   WHERE payroll_id=s.payroll_id
		   ORDER BY qualification_hierachy DESC LIMIT 1
        ) AS qualification_kh,
		s.start_date, s.staff_status_id AS status_id, sstatus.status_kh, temp3.grade_id
		FROM hrmis_staffs AS s  
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
		   WHERE ss.salary_type_shift_date=(
		    	SELECT MAX(salary_type_shift_date) FROM hrmis_staff_salaries WHERE payroll_id=ss.payroll_id
			)
		) AS temp2 ON s.payroll_id=temp2.payroll_id
		LEFT JOIN ( 
		SELECT payroll_id, IF(MAX(grade_id)=0,1,MAX(grade_id)) AS grade_id FROM hrmis_teaching_subjects
		 WHERE year_id=@academic_id GROUP BY  payroll_id
		 ) AS temp3 ON s.payroll_id=temp3.payroll_id 
		WHERE s.staff_status_id IN (1,2,7,8,10) AND wh.cur_pos=1 
			-- AND wh.pro_code=param_pro_code 
			AND wh.location_code=param_loc_code
			-- AND @cur_date BETWEEN IFNULL(wh.start_date, CURDATE()) AND IFNULL(wh.end_date, CURDATE())
		ORDER BY wh.location_code, wh.sys_admin_office_id, p.position_hierarchy;
	/*----End School-----*/
		
	/*----District Search-----*/	
	ELSEIF param_dis_code<>'' THEN
		SELECT l.location_kh AS workplace_kh, sys_offices.office_kh, com.name_kh AS commune_kh, dis.name_kh AS district_kh, pro.name_kh AS province_kh, 
		wh.location_code, com.name_en AS commune_en, dis.name_en AS district_en, pro.name_en AS province_en, l.location_en AS workplace_en, 
		s.payroll_id, CONCAT(s.surname_kh, ' ', s.name_kh) AS fullname_kh, CONCAT(s.surname_en, ' ', s.name_en) AS fullname_en, s.sex, s.dob,  
		CONCAT(temp2.salary_level_kh, '.', temp2.salary_degree) AS salary_level, p.position_kh, 
		(SELECT subject_kh FROM hrmis_staff_professions 
			INNER JOIN sys_professional_categories 
			ON hrmis_staff_professions.prof_category_id = sys_professional_categories.prof_category_id
			 INNER JOIN sys_subjects ON hrmis_staff_professions.subject_id1=sys_subjects.subject_id
			    WHERE hrmis_staff_professions.payroll_id=s.payroll_id
			ORDER BY sys_professional_categories.prof_hierachy LIMIT 1
		) AS subject_1, 
        (SELECT subject_kh FROM hrmis_staff_professions 
			INNER JOIN sys_professional_categories 
			ON hrmis_staff_professions.prof_category_id = sys_professional_categories.prof_category_id
			 INNER JOIN sys_subjects ON hrmis_staff_professions.subject_id2=sys_subjects.subject_id
			    WHERE hrmis_staff_professions.payroll_id=s.payroll_id
			ORDER BY sys_professional_categories.prof_hierachy LIMIT 1
		) AS subject_2,
        (SELECT prof_category_kh FROM hrmis_staff_professions 
            INNER JOIN sys_professional_categories 
            ON hrmis_staff_professions.prof_category_id=sys_professional_categories.prof_category_id
            WHERE hrmis_staff_professions.payroll_id=s.payroll_id
            ORDER BY sys_professional_categories.prof_hierachy LIMIT 1
		) AS profession_kh,
        (SELECT qc.qualification_kh 
		   FROM hrmis_staff_qualifications AS q
		   INNER JOIN sys_qualification_codes AS qc ON q.qualification_code=qc.qualification_code
		   WHERE payroll_id=s.payroll_id
		   ORDER BY qualification_hierachy DESC LIMIT 1
        ) AS qualification_kh, 
		s.start_date, s.staff_status_id AS status_id, sstatus.status_kh, temp3.grade_id
		FROM hrmis_staffs AS s  
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
		   WHERE ss.salary_type_shift_date=(
		    	SELECT MAX(salary_type_shift_date) FROM hrmis_staff_salaries WHERE payroll_id=ss.payroll_id
			)
		) AS temp2 ON s.payroll_id=temp2.payroll_id 
		LEFT JOIN ( 
		SELECT payroll_id, IF(MAX(grade_id)=0,1,MAX(grade_id)) AS grade_id FROM hrmis_teaching_subjects
		 WHERE year_id=@academic_id GROUP BY  payroll_id
		 ) AS temp3 ON s.payroll_id=temp3.payroll_id 
		WHERE s.staff_status_id IN (1,2,7,8,10) AND wh.cur_pos=1 
			-- AND wh.pro_code=param_pro_code 
			AND LEFT(wh.location_code,4)=param_dis_code 
			AND @cur_date BETWEEN IFNULL(wh.start_date, CURDATE()) AND IFNULL(wh.end_date, CURDATE())
		ORDER BY wh.location_code, wh.sys_admin_office_id, p.position_hierarchy;
	     
	/*----End District Search-----*/
	
	/*----Province Search----*/
	ELSE
		SELECT l.location_kh AS workplace_kh, sys_offices.office_kh, com.name_kh AS commune_kh, dis.name_kh AS district_kh, pro.name_kh AS province_kh, 
		wh.location_code, com.name_en AS commune_en, dis.name_en AS district_en, pro.name_en AS province_en, l.location_en AS workplace_en, 
		s.payroll_id, CONCAT(s.surname_kh, ' ', s.name_kh) AS fullname_kh, CONCAT(s.surname_en, ' ', s.name_en) AS fullname_en, s.sex, s.dob,  
		CONCAT(temp2.salary_level_kh, '.', temp2.salary_degree) AS salary_level, p.position_kh, 
		(SELECT subject_kh FROM hrmis_staff_professions 
			INNER JOIN sys_professional_categories 
			ON hrmis_staff_professions.prof_category_id = sys_professional_categories.prof_category_id
			 INNER JOIN sys_subjects ON hrmis_staff_professions.subject_id1=sys_subjects.subject_id
			    WHERE hrmis_staff_professions.payroll_id=s.payroll_id
			ORDER BY sys_professional_categories.prof_hierachy LIMIT 1
		) AS subject_1, 
        (SELECT subject_kh FROM hrmis_staff_professions 
			INNER JOIN sys_professional_categories 
			ON hrmis_staff_professions.prof_category_id = sys_professional_categories.prof_category_id
			 INNER JOIN sys_subjects ON hrmis_staff_professions.subject_id2=sys_subjects.subject_id
			    WHERE hrmis_staff_professions.payroll_id=s.payroll_id
			ORDER BY sys_professional_categories.prof_hierachy LIMIT 1
		) AS subject_2,
        (SELECT prof_category_kh FROM hrmis_staff_professions 
            INNER JOIN sys_professional_categories 
            ON hrmis_staff_professions.prof_category_id=sys_professional_categories.prof_category_id
            WHERE hrmis_staff_professions.payroll_id=s.payroll_id
            ORDER BY sys_professional_categories.prof_hierachy LIMIT 1
		) AS profession_kh,
        (SELECT qc.qualification_kh 
		   FROM hrmis_staff_qualifications AS q
		   INNER JOIN sys_qualification_codes AS qc ON q.qualification_code=qc.qualification_code
		   WHERE payroll_id=s.payroll_id
		   ORDER BY qualification_hierachy DESC LIMIT 1
        ) AS qualification_kh,
		s.start_date, s.staff_status_id AS status_id, sstatus.status_kh, temp3.grade_id
		FROM hrmis_staffs AS s  
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
		   WHERE ss.salary_type_shift_date=(
		    	SELECT MAX(salary_type_shift_date) FROM hrmis_staff_salaries WHERE payroll_id=ss.payroll_id
			)
		) AS temp2 ON s.payroll_id=temp2.payroll_id 
		LEFT JOIN ( 
		SELECT payroll_id, IF(MAX(grade_id)=0,1,MAX(grade_id)) AS grade_id FROM hrmis_teaching_subjects
		 WHERE year_id=@academic_id GROUP BY  payroll_id
		 ) AS temp3 ON s.payroll_id=temp3.payroll_id 
		WHERE s.staff_status_id IN (1,2,7,8,10) AND wh.cur_pos=1 AND wh.pro_code=param_pro_code 
			AND LEFT(wh.location_code,2)=param_pro_code 
			-- AND IFNULL(wh.sys_admin_office_id,0)=0
			AND @cur_date BETWEEN IFNULL(wh.start_date, CURDATE()) AND IFNULL(wh.end_date, CURDATE())
		ORDER BY wh.location_code, wh.sys_admin_office_id, p.position_hierarchy;
	END IF;
	/*----End province search---*/
END$$

DELIMITER ;