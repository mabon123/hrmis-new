DELIMITER $$

USE `hrmis_db`$$

DROP PROCEDURE IF EXISTS `sp_rptschool_inform`$$

CREATE PROCEDURE `sp_rptschool_inform`(
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
	SELECT	wh.location_code,
	l.location_kh AS workplace_kh,
	ANY_VALUE(com.name_kh) AS commune_kh,
	ANY_VALUE(dis.name_kh) AS district_kh,
	ANY_VALUE(pro.name_kh) AS province_kh,
	COUNT(wh.payroll_id) AS AmountSt,
	SUM(IF(s.sex="2",1,0)) AS FAmount,
	SUM(IF(s.`is_cont_staff`=1,1,0)) AS AmountConS,
	SUM(IF(temp3.grade_id,1,0)) AS TAmount,
	COUNT(wh.payroll_id)-SUM(IF(temp3.grade_id,1,0)) AS NTAmount,
	any_value(r.`region_kh`) AS region_kh,
	IF(l.`disadvantage`=1,"ជួបការលំបាក",NULL) AS disadvantage,
	ANY_VALUE(hi.`class_num`) AS class_num,
	ANY_VALUE(hi.`tstud_num`) AS tstud_num,
	ANY_VALUE(hi.`fstud_num`) AS fstud_num,
	ANY_VALUE(hi.`preschool_num`+hi.`preschool_medium_num`+hi.`preschool_high_num`+hi.`preschool_mix_num`) AS `preschool_num`,
	ANY_VALUE(hi.`preschoolf_num`+hi.`preschool_mediumf_num`+hi.`preschool_highf_num`+hi.`preschool_mixf_num`) AS `preschoolf_num`,
	ANY_VALUE(hi.`preschool_totalclass_num`+hi.`preschool_mediumtotalclass_num`+hi.`preschool_hightotalclass_num`+hi.`preschool_mixtotalclass_num`) AS `preschool_totalclass_num`,
	ANY_VALUE(hi.`grade1_num`) AS grade1_num,ANY_VALUE(hi.`grade1f_num`) AS grade1f_num,ANY_VALUE(hi.`grade1totalclass_num`) AS grade1totalclass_num,
	ANY_VALUE(hi.`grade2_num`) AS grade2_num,ANY_VALUE(hi.`grade2f_num`) AS grade2f_num,ANY_VALUE(hi.`grade2totalclass_num`) AS grade2totalclass_num,
	ANY_VALUE(hi.`grade3_num`) AS grade3_num,ANY_VALUE(hi.`grade3f_num`) AS grade3f_num,ANY_VALUE(hi.`grade3totalclass_num`) AS grade3totalclass_num,
	ANY_VALUE(hi.`grade4_num`) AS grade4_num,ANY_VALUE(hi.`grade4f_num`) AS grade4f_num,ANY_VALUE(hi.`grade4totalclass_num`) AS grade4totalclass_num,
	ANY_VALUE(hi.`grade5_num`) AS grade5_num,ANY_VALUE(hi.`grade5f_num`) AS grade5f_num,ANY_VALUE(hi.`grade5totalclass_num`) AS grade5totalclass_num,
	ANY_VALUE(hi.`grade6_num`) AS grade6_num,ANY_VALUE(hi.`grade6f_num`) AS grade6f_num,ANY_VALUE(hi.`grade6totalclass_num`) AS grade6totalclass_num,
	ANY_VALUE(hi.`acceleration_class_y1_num`) AS acceleration_class_y1_num,ANY_VALUE(hi.`acceleration_class_y1f_num`) AS acceleration_class_y1f_num,ANY_VALUE(hi.`acceleration_y1totalclass_num`) AS acceleration_y1totalclass_num,
	ANY_VALUE(hi.`acceleration_class_y2_num`) AS acceleration_class_y2_num,ANY_VALUE(hi.`acceleration_class_y2f_num`) AS acceleration_class_y2f_num,ANY_VALUE(hi.`acceleration_y2totalclass_num`) AS acceleration_y2totalclass_num,
	ANY_VALUE(hi.`acceleration_class_y3_num`) AS acceleration_class_y3_num,ANY_VALUE(hi.`acceleration_class_y3f_num`) AS acceleration_class_y3f_num,ANY_VALUE(hi.`acceleration_y3totalclass_num`) AS acceleration_y3totalclass_num,
	ANY_VALUE(hi.`grade7_num`) AS grade7_num,ANY_VALUE(hi.`grade7f_num`) AS grade7f_num,ANY_VALUE(hi.`grade7totalclass_num`) AS grade7totalclass_num,
	ANY_VALUE(hi.`grade8_num`) AS grade8_num,ANY_VALUE(hi.`grade8f_num`) AS grade8f_num,ANY_VALUE(hi.`grade8totalclass_num`) AS grade8totalclass_num,
	ANY_VALUE(hi.`grade9_num`) AS grade9_num,ANY_VALUE(hi.`grade9f_num`) AS grade9f_num,ANY_VALUE(hi.`grade9totalclass_num`) AS grade9totalclass_num,
	ANY_VALUE(hi.`grade10_num`) AS grade10_num,ANY_VALUE(hi.`grade10f_num`) AS grade10f_num,ANY_VALUE(hi.`grade10totalclass_num`) AS grade10totalclass_num,
	ANY_VALUE(hi.`grade11_num`+hi.`grade11so_num`) AS grade11_num,ANY_VALUE(hi.`grade11f_num`+hi.`grade11sof_num`) AS grade11f_num,ANY_VALUE(hi.`grade11totalclass_num`+hi.`grade11sototalclass_num`) AS grade11totalclass_num,
	ANY_VALUE(hi.`grade12_num`+hi.`grade12so_num`) AS grade12_num,ANY_VALUE(hi.`grade12f_num`+hi.`grade12sof_num`) AS grade12f_num,ANY_VALUE(hi.`grade12totalclass_num`+hi.`grade12sototalclass_num`) AS grade12totalclass_num,
	ANY_VALUE(hi.`technical_class_y1_num`) AS technical_class_y1_num,ANY_VALUE(hi.`technical_class_y1f_num`) AS technical_class_y1f_num,ANY_VALUE(hi.`technical_y1totalclass_num`) AS technical_y1totalclass_num,
	ANY_VALUE(hi.`technical_class_y2_num`) AS technical_class_y2_num,ANY_VALUE(hi.`technical_class_y2f_num`) AS technical_class_y2f_num,ANY_VALUE(hi.`technical_y2totalclass_num`) AS technical_y2totalclass_num,
	ANY_VALUE(hi.`technical_class_y3_num`) AS technical_class_y3_num,ANY_VALUE(hi.`technical_class_y3f_num`) AS technical_class_y3f_num,ANY_VALUE(hi.`technical_y3totalclass_num`) AS technical_y3totalclass_num,
	ANY_VALUE(sstatus.status_kh) AS status_kh,
	ANY_VALUE(l.`location_type_id`) AS location_type_id
FROM hrmis_staffs AS s  
LEFT JOIN ( hrmis_work_histories AS wh  
		LEFT JOIN sys_positions AS p ON p.position_id=wh.position_id 
		LEFT JOIN `sys_contstaff_positions` c ON wh.`cont_pos_id`=c.`cont_pos_id`
		LEFT JOIN `hrmis_location_histories` hi ON wh.`location_code`=hi.`location_code` AND hi.`year_id`=@academic_id
		LEFT JOIN `sys_locations` l ON wh.`location_code`=l.`location_code`
		LEFT JOIN sys_offices ON wh.sys_admin_office_id=sys_offices.office_id
		LEFT JOIN sys_provinces AS pro ON LEFT(wh.`location_code`,2)=pro.pro_code
		LEFT JOIN sys_districts AS dis ON LEFT(wh.`location_code`,4)=dis.dis_code
		LEFT JOIN sys_communes AS com ON LEFT(wh.`location_code`,6)=com.com_code
		LEFT JOIN `sys_regions` AS r ON r.`region_id`=l.`region_id`
		) ON s.payroll_id=wh.payroll_id 
LEFT JOIN sys_staff_status AS sstatus ON s.staff_status_id=sstatus.status_id	
		LEFT JOIN ( 
		 SELECT payroll_id, IF(MAX(grade_id)=0,1,MAX(grade_id)) AS grade_id FROM `timetable_teacher_subjects` 
		 INNER JOIN `timetables`  ON `timetables`.`teacher_subject_id`=`timetable_teacher_subjects`.`teacher_subject_id` WHERE `timetable_teacher_subjects`.`academic_id`=@academic_id AND `timetable_teacher_subjects`.grade_id NOT IN (32,33,34) GROUP BY  payroll_id
		UNION
		SELECT `timetable_teacher_primary`.payroll_id, IF(MAX(`timetable_grades`.grade_id)=0,1,MAX(`timetable_grades`.grade_id)) AS grade_id FROM `timetable_teacher_primary` INNER JOIN `timetable_grades` ON `timetable_teacher_primary`.`tgrade_id`=`timetable_grades`.`tgrade_id`
		WHERE `timetable_teacher_primary`.`academic_id`=@academic_id AND `timetable_grades`.grade_id NOT IN (32,33,34) GROUP BY  `timetable_teacher_primary`.payroll_id
		 ) AS temp3 ON s.payroll_id=temp3.payroll_id 
		WHERE s.staff_status_id IN (1,2,7,8,10) AND wh.cur_pos=1 AND (wh.`contract_type_id` IS NULL OR wh.`contract_type_id` !=4 )
			-- AND wh.pro_code=param_pro_code 
AND wh.location_code=param_loc_code
GROUP BY wh.location_code
			-- AND @cur_date BETWEEN IFNULL(wh.start_date, CURDATE()) AND IFNULL(wh.end_date, CURDATE())
		;
	/*----End School-----*/
		
	/*----District Search-----*/	
	ELSEIF param_dis_code<>'' THEN
	SELECT	wh.location_code,
	l.location_kh AS workplace_kh,
	ANY_VALUE(com.name_kh) AS commune_kh,
	ANY_VALUE(dis.name_kh) AS district_kh,
	ANY_VALUE(pro.name_kh) AS province_kh,
	COUNT(wh.payroll_id) AS AmountSt,
	SUM(IF(s.sex="2",1,0)) AS FAmount,
	SUM(IF(s.`is_cont_staff`=1,1,0)) AS AmountConS,
	SUM(IF(temp3.grade_id,1,0)) AS TAmount,
	COUNT(wh.payroll_id)-SUM(IF(temp3.grade_id,1,0)) AS NTAmount,
	any_value(r.`region_kh`) AS region_kh,
	IF(l.`disadvantage`=1,"ជួបការលំបាក",NULL) AS disadvantage,
	ANY_VALUE(hi.`class_num`) AS class_num,
	ANY_VALUE(hi.`tstud_num`) AS tstud_num,
	ANY_VALUE(hi.`fstud_num`) AS fstud_num,
	ANY_VALUE(hi.`preschool_num`+hi.`preschool_medium_num`+hi.`preschool_high_num`+hi.`preschool_mix_num`) AS `preschool_num`,
	ANY_VALUE(hi.`preschoolf_num`+hi.`preschool_mediumf_num`+hi.`preschool_highf_num`+hi.`preschool_mixf_num`) AS `preschoolf_num`,
	ANY_VALUE(hi.`preschool_totalclass_num`+hi.`preschool_mediumtotalclass_num`+hi.`preschool_hightotalclass_num`+hi.`preschool_mixtotalclass_num`) AS `preschool_totalclass_num`,
	ANY_VALUE(hi.`grade1_num`) AS grade1_num,ANY_VALUE(hi.`grade1f_num`) AS grade1f_num,ANY_VALUE(hi.`grade1totalclass_num`) AS grade1totalclass_num,
	ANY_VALUE(hi.`grade2_num`) AS grade2_num,ANY_VALUE(hi.`grade2f_num`) AS grade2f_num,ANY_VALUE(hi.`grade2totalclass_num`) AS grade2totalclass_num,
	ANY_VALUE(hi.`grade3_num`) AS grade3_num,ANY_VALUE(hi.`grade3f_num`) AS grade3f_num,ANY_VALUE(hi.`grade3totalclass_num`) AS grade3totalclass_num,
	ANY_VALUE(hi.`grade4_num`) AS grade4_num,ANY_VALUE(hi.`grade4f_num`) AS grade4f_num,ANY_VALUE(hi.`grade4totalclass_num`) AS grade4totalclass_num,
	ANY_VALUE(hi.`grade5_num`) AS grade5_num,ANY_VALUE(hi.`grade5f_num`) AS grade5f_num,ANY_VALUE(hi.`grade5totalclass_num`) AS grade5totalclass_num,
	ANY_VALUE(hi.`grade6_num`) AS grade6_num,ANY_VALUE(hi.`grade6f_num`) AS grade6f_num,ANY_VALUE(hi.`grade6totalclass_num`) AS grade6totalclass_num,
	ANY_VALUE(hi.`acceleration_class_y1_num`) AS acceleration_class_y1_num,ANY_VALUE(hi.`acceleration_class_y1f_num`) AS acceleration_class_y1f_num,ANY_VALUE(hi.`acceleration_y1totalclass_num`) AS acceleration_y1totalclass_num,
	ANY_VALUE(hi.`acceleration_class_y2_num`) AS acceleration_class_y2_num,ANY_VALUE(hi.`acceleration_class_y2f_num`) AS acceleration_class_y2f_num,ANY_VALUE(hi.`acceleration_y2totalclass_num`) AS acceleration_y2totalclass_num,
	ANY_VALUE(hi.`acceleration_class_y3_num`) AS acceleration_class_y3_num,ANY_VALUE(hi.`acceleration_class_y3f_num`) AS acceleration_class_y3f_num,ANY_VALUE(hi.`acceleration_y3totalclass_num`) AS acceleration_y3totalclass_num,
	ANY_VALUE(hi.`grade7_num`) AS grade7_num,ANY_VALUE(hi.`grade7f_num`) AS grade7f_num,ANY_VALUE(hi.`grade7totalclass_num`) AS grade7totalclass_num,
	ANY_VALUE(hi.`grade8_num`) AS grade8_num,ANY_VALUE(hi.`grade8f_num`) AS grade8f_num,ANY_VALUE(hi.`grade8totalclass_num`) AS grade8totalclass_num,
	ANY_VALUE(hi.`grade9_num`) AS grade9_num,ANY_VALUE(hi.`grade9f_num`) AS grade9f_num,ANY_VALUE(hi.`grade9totalclass_num`) AS grade9totalclass_num,
	ANY_VALUE(hi.`grade10_num`) AS grade10_num,ANY_VALUE(hi.`grade10f_num`) AS grade10f_num,ANY_VALUE(hi.`grade10totalclass_num`) AS grade10totalclass_num,
	ANY_VALUE(hi.`grade11_num`+hi.`grade11so_num`) AS grade11_num,ANY_VALUE(hi.`grade11f_num`+hi.`grade11sof_num`) AS grade11f_num,ANY_VALUE(hi.`grade11totalclass_num`+hi.`grade11sototalclass_num`) AS grade11totalclass_num,
	ANY_VALUE(hi.`grade12_num`+hi.`grade12so_num`) AS grade12_num,ANY_VALUE(hi.`grade12f_num`+hi.`grade12sof_num`) AS grade12f_num,ANY_VALUE(hi.`grade12totalclass_num`+hi.`grade12sototalclass_num`) AS grade12totalclass_num,
	ANY_VALUE(hi.`technical_class_y1_num`) AS technical_class_y1_num,ANY_VALUE(hi.`technical_class_y1f_num`) AS technical_class_y1f_num,ANY_VALUE(hi.`technical_y1totalclass_num`) AS technical_y1totalclass_num,
	ANY_VALUE(hi.`technical_class_y2_num`) AS technical_class_y2_num,ANY_VALUE(hi.`technical_class_y2f_num`) AS technical_class_y2f_num,ANY_VALUE(hi.`technical_y2totalclass_num`) AS technical_y2totalclass_num,
	ANY_VALUE(hi.`technical_class_y3_num`) AS technical_class_y3_num,ANY_VALUE(hi.`technical_class_y3f_num`) AS technical_class_y3f_num,ANY_VALUE(hi.`technical_y3totalclass_num`) AS technical_y3totalclass_num,
	ANY_VALUE(sstatus.status_kh) AS status_kh,
	ANY_VALUE(l.`location_type_id`) AS location_type_id
FROM hrmis_staffs AS s  
LEFT JOIN ( hrmis_work_histories AS wh  
		LEFT JOIN sys_positions AS p ON p.position_id=wh.position_id 
		LEFT JOIN `sys_contstaff_positions` c ON wh.`cont_pos_id`=c.`cont_pos_id`
		LEFT JOIN `hrmis_location_histories` hi ON wh.`location_code`=hi.`location_code` AND hi.`year_id`=@academic_id
		LEFT JOIN `sys_locations` l ON wh.`location_code`=l.`location_code`
		LEFT JOIN sys_offices ON wh.sys_admin_office_id=sys_offices.office_id
		LEFT JOIN sys_provinces AS pro ON LEFT(wh.`location_code`,2)=pro.pro_code
		LEFT JOIN sys_districts AS dis ON LEFT(wh.`location_code`,4)=dis.dis_code
		LEFT JOIN sys_communes AS com ON LEFT(wh.`location_code`,6)=com.com_code
		LEFT JOIN `sys_regions` AS r ON r.`region_id`=l.`region_id`
		) ON s.payroll_id=wh.payroll_id 
LEFT JOIN sys_staff_status AS sstatus ON s.staff_status_id=sstatus.status_id
		LEFT JOIN ( 
		 SELECT payroll_id, IF(MAX(grade_id)=0,1,MAX(grade_id)) AS grade_id FROM `timetable_teacher_subjects` 
		 INNER JOIN `timetables`  ON `timetables`.`teacher_subject_id`=`timetable_teacher_subjects`.`teacher_subject_id` WHERE `timetable_teacher_subjects`.`academic_id`=@academic_id AND `timetable_teacher_subjects`.grade_id NOT IN (32,33,34) GROUP BY  payroll_id
		UNION
		SELECT `timetable_teacher_primary`.payroll_id, IF(MAX(`timetable_grades`.grade_id)=0,1,MAX(`timetable_grades`.grade_id)) AS grade_id FROM `timetable_teacher_primary` INNER JOIN `timetable_grades` ON `timetable_teacher_primary`.`tgrade_id`=`timetable_grades`.`tgrade_id`
		WHERE `timetable_teacher_primary`.`academic_id`=@academic_id AND `timetable_grades`.grade_id NOT IN (32,33,34) GROUP BY  `timetable_teacher_primary`.payroll_id
		 ) AS temp3 ON s.payroll_id=temp3.payroll_id 
		WHERE s.staff_status_id IN (1,2,7,8,10,14) AND wh.cur_pos=1 AND (wh.`contract_type_id` IS NULL OR wh.`contract_type_id` !=4 ) AND l.`location_type_id` IN (9,10,11,14,15,16,17,18)
			-- AND wh.pro_code=param_pro_code 
			AND LEFT(wh.location_code,4)=param_dis_code 
			-- AND @cur_date BETWEEN IFNULL(wh.start_date, CURDATE()) AND IFNULL(wh.end_date, CURDATE())
		GROUP BY wh.location_code
		ORDER BY ANY_VALUE(pro.name_kh),ANY_VALUE(dis.name_kh),l.`location_type_id`,l.`location_kh`;
	     
	/*----End District Search-----*/
	
	/*----Province Search----*/
	ELSE
	SELECT	wh.location_code,
	l.location_kh AS workplace_kh,
	ANY_VALUE(com.name_kh) AS commune_kh,
	ANY_VALUE(dis.name_kh) AS district_kh,
	ANY_VALUE(pro.name_kh) AS province_kh,
	COUNT(wh.payroll_id) AS AmountSt,
	SUM(IF(s.sex="2",1,0)) AS FAmount,
	SUM(IF(s.`is_cont_staff`=1,1,0)) AS AmountConS,
	SUM(IF(temp3.grade_id,1,0)) AS TAmount,
	COUNT(wh.payroll_id)-SUM(IF(temp3.grade_id,1,0)) AS NTAmount,
	any_value(r.`region_kh`) AS region_kh,
	IF(l.`disadvantage`=1,"ជួបការលំបាក",NULL) AS disadvantage,
	ANY_VALUE(hi.`class_num`) AS class_num,
	ANY_VALUE(hi.`tstud_num`) AS tstud_num,
	ANY_VALUE(hi.`fstud_num`) AS fstud_num,
	ANY_VALUE(hi.`preschool_num`+hi.`preschool_medium_num`+hi.`preschool_high_num`+hi.`preschool_mix_num`) AS `preschool_num`,
	ANY_VALUE(hi.`preschoolf_num`+hi.`preschool_mediumf_num`+hi.`preschool_highf_num`+hi.`preschool_mixf_num`) AS `preschoolf_num`,
	ANY_VALUE(hi.`preschool_totalclass_num`+hi.`preschool_mediumtotalclass_num`+hi.`preschool_hightotalclass_num`+hi.`preschool_mixtotalclass_num`) AS `preschool_totalclass_num`,
	ANY_VALUE(hi.`grade1_num`) AS grade1_num,ANY_VALUE(hi.`grade1f_num`) AS grade1f_num,ANY_VALUE(hi.`grade1totalclass_num`) AS grade1totalclass_num,
	ANY_VALUE(hi.`grade2_num`) AS grade2_num,ANY_VALUE(hi.`grade2f_num`) AS grade2f_num,ANY_VALUE(hi.`grade2totalclass_num`) AS grade2totalclass_num,
	ANY_VALUE(hi.`grade3_num`) AS grade3_num,ANY_VALUE(hi.`grade3f_num`) AS grade3f_num,ANY_VALUE(hi.`grade3totalclass_num`) AS grade3totalclass_num,
	ANY_VALUE(hi.`grade4_num`) AS grade4_num,ANY_VALUE(hi.`grade4f_num`) AS grade4f_num,ANY_VALUE(hi.`grade4totalclass_num`) AS grade4totalclass_num,
	ANY_VALUE(hi.`grade5_num`) AS grade5_num,ANY_VALUE(hi.`grade5f_num`) AS grade5f_num,ANY_VALUE(hi.`grade5totalclass_num`) AS grade5totalclass_num,
	ANY_VALUE(hi.`grade6_num`) AS grade6_num,ANY_VALUE(hi.`grade6f_num`) AS grade6f_num,ANY_VALUE(hi.`grade6totalclass_num`) AS grade6totalclass_num,
	ANY_VALUE(hi.`acceleration_class_y1_num`) AS acceleration_class_y1_num,ANY_VALUE(hi.`acceleration_class_y1f_num`) AS acceleration_class_y1f_num,ANY_VALUE(hi.`acceleration_y1totalclass_num`) AS acceleration_y1totalclass_num,
	ANY_VALUE(hi.`acceleration_class_y2_num`) AS acceleration_class_y2_num,ANY_VALUE(hi.`acceleration_class_y2f_num`) AS acceleration_class_y2f_num,ANY_VALUE(hi.`acceleration_y2totalclass_num`) AS acceleration_y2totalclass_num,
	ANY_VALUE(hi.`acceleration_class_y3_num`) AS acceleration_class_y3_num,ANY_VALUE(hi.`acceleration_class_y3f_num`) AS acceleration_class_y3f_num,ANY_VALUE(hi.`acceleration_y3totalclass_num`) AS acceleration_y3totalclass_num,
	ANY_VALUE(hi.`grade7_num`) AS grade7_num,ANY_VALUE(hi.`grade7f_num`) AS grade7f_num,ANY_VALUE(hi.`grade7totalclass_num`) AS grade7totalclass_num,
	ANY_VALUE(hi.`grade8_num`) AS grade8_num,ANY_VALUE(hi.`grade8f_num`) AS grade8f_num,ANY_VALUE(hi.`grade8totalclass_num`) AS grade8totalclass_num,
	ANY_VALUE(hi.`grade9_num`) AS grade9_num,ANY_VALUE(hi.`grade9f_num`) AS grade9f_num,ANY_VALUE(hi.`grade9totalclass_num`) AS grade9totalclass_num,
	ANY_VALUE(hi.`grade10_num`) AS grade10_num,ANY_VALUE(hi.`grade10f_num`) AS grade10f_num,ANY_VALUE(hi.`grade10totalclass_num`) AS grade10totalclass_num,
	ANY_VALUE(hi.`grade11_num`+hi.`grade11so_num`) AS grade11_num,ANY_VALUE(hi.`grade11f_num`+hi.`grade11sof_num`) AS grade11f_num,ANY_VALUE(hi.`grade11totalclass_num`+hi.`grade11sototalclass_num`) AS grade11totalclass_num,
	ANY_VALUE(hi.`grade12_num`+hi.`grade12so_num`) AS grade12_num,ANY_VALUE(hi.`grade12f_num`+hi.`grade12sof_num`) AS grade12f_num,ANY_VALUE(hi.`grade12totalclass_num`+hi.`grade12sototalclass_num`) AS grade12totalclass_num,
	ANY_VALUE(hi.`technical_class_y1_num`) AS technical_class_y1_num,ANY_VALUE(hi.`technical_class_y1f_num`) AS technical_class_y1f_num,ANY_VALUE(hi.`technical_y1totalclass_num`) AS technical_y1totalclass_num,
	ANY_VALUE(hi.`technical_class_y2_num`) AS technical_class_y2_num,ANY_VALUE(hi.`technical_class_y2f_num`) AS technical_class_y2f_num,ANY_VALUE(hi.`technical_y2totalclass_num`) AS technical_y2totalclass_num,
	ANY_VALUE(hi.`technical_class_y3_num`) AS technical_class_y3_num,ANY_VALUE(hi.`technical_class_y3f_num`) AS technical_class_y3f_num,ANY_VALUE(hi.`technical_y3totalclass_num`) AS technical_y3totalclass_num,
	ANY_VALUE(sstatus.status_kh) AS status_kh,
	ANY_VALUE(l.`location_type_id`) AS location_type_id
FROM hrmis_staffs AS s  
LEFT JOIN ( hrmis_work_histories AS wh  
		LEFT JOIN sys_positions AS p ON p.position_id=wh.position_id 
		LEFT JOIN `sys_contstaff_positions` c ON wh.`cont_pos_id`=c.`cont_pos_id`
		LEFT JOIN `hrmis_location_histories` hi ON wh.`location_code`=hi.`location_code` AND hi.`year_id`=@academic_id
		LEFT JOIN `sys_locations` l ON wh.`location_code`=l.`location_code`
		LEFT JOIN sys_offices ON wh.sys_admin_office_id=sys_offices.office_id
		LEFT JOIN sys_provinces AS pro ON LEFT(wh.`location_code`,2)=pro.pro_code
		LEFT JOIN sys_districts AS dis ON LEFT(wh.`location_code`,4)=dis.dis_code
		LEFT JOIN sys_communes AS com ON LEFT(wh.`location_code`,6)=com.com_code
		LEFT JOIN `sys_regions` AS r ON r.`region_id`=l.`region_id`
		) ON s.payroll_id=wh.payroll_id 
LEFT JOIN sys_staff_status AS sstatus ON s.staff_status_id=sstatus.status_id	
		LEFT JOIN ( 
		SELECT payroll_id, IF(MAX(grade_id)=0,1,MAX(grade_id)) AS grade_id FROM `timetable_teacher_subjects` 
		 INNER JOIN `timetables`  ON `timetables`.`teacher_subject_id`=`timetable_teacher_subjects`.`teacher_subject_id` WHERE `timetable_teacher_subjects`.`academic_id`=@academic_id AND `timetable_teacher_subjects`.grade_id NOT IN (32,33,34) GROUP BY  payroll_id
		UNION
		SELECT `timetable_teacher_primary`.payroll_id, IF(MAX(`timetable_grades`.grade_id)=0,1,MAX(`timetable_grades`.grade_id)) AS grade_id FROM `timetable_teacher_primary` INNER JOIN `timetable_grades` ON `timetable_teacher_primary`.`tgrade_id`=`timetable_grades`.`tgrade_id`
		WHERE `timetable_teacher_primary`.`academic_id`=@academic_id AND `timetable_grades`.grade_id NOT IN (32,33,34) GROUP BY  `timetable_teacher_primary`.payroll_id
		 ) AS temp3 ON s.payroll_id=temp3.payroll_id 
		WHERE s.staff_status_id IN (1,2,7,8,10,14) AND wh.cur_pos=1 AND (wh.`contract_type_id` IS NULL OR wh.`contract_type_id` !=4 ) AND wh.pro_code=param_pro_code 
			AND LEFT(wh.location_code,2)=param_pro_code AND l.`location_type_id` IN (9,10,11,14,15,16,17,18)
			-- AND IFNULL(wh.sys_admin_office_id,0)=0
			-- AND @cur_date BETWEEN IFNULL(wh.start_date, CURDATE()) AND IFNULL(wh.end_date, CURDATE())
		GROUP BY wh.location_code
		ORDER BY ANY_VALUE(pro.name_kh),ANY_VALUE(dis.name_kh),l.`location_type_id`,l.`location_kh`;
		
	END IF;
	/*----End province search---*/
END$$

DELIMITER ;