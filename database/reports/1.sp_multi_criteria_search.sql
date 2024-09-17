DELIMITER $$

USE `hrmis_db`$$

DROP PROCEDURE IF EXISTS `sp_multi_criteria_search`$$

CREATE PROCEDURE `sp_multi_criteria_search`()
BEGIN
	
	-- Get current academic year	
	SELECT year_id, CONVERT(SUBSTRING(year_en, 1, 4), UNSIGNED INTEGER), CONVERT(SUBSTRING(year_en, -4, 4), UNSIGNED INTEGER), CURDATE() 
	FROM sys_academic_years WHERE cur_year=1 LIMIT 1 INTO @academic_id, @year_start, @year_end, @cur_date;
	-- Cteate temp table to store result
	DROP TABLE IF EXISTS `tmp_multi_criteria_search`;
	CREATE TABLE `tmp_multi_criteria_search` (
		id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
		payroll_id VARCHAR(10) NULL,
		location_code VARCHAR(11) NULL,
		pro_code VARCHAR(2) NULL,
		dis_code VARCHAR(4) NULL,
		com_code VARCHAR(6) NULL,
		vil_code VARCHAR(8) NULL,
		nid_card VARCHAR(15) NULL,
		bank_account VARCHAR(15) NULL,
		last_name_kh VARCHAR(100) NULL,
		first_name_kh VARCHAR(100) NULL,
		last_name_en VARCHAR(50) NULL,
		first_name_en VARCHAR(50) NULL,
		sex TINYINT NULL,
		dob DATE NULL,
		ethnic_kh VARCHAR(50) NULL, 
		photo VARCHAR(20) NULL,
		birth_province VARCHAR(150) NULL,
		birth_district VARCHAR(100) NULL,
		birth_commune VARCHAR(100) NULL,
		birth_village VARCHAR(100) NULL,
		start_date DATE NULL,
		appointment_date DATE NULL,
		status_kh VARCHAR(100) NULL,
		maritalstatus_kh VARCHAR(60) NULL,
		adr_province VARCHAR(150) NULL,
		adr_district VARCHAR(150) NULL,
		adr_commune VARCHAR(150) NULL,
		adr_village VARCHAR(150) NULL,
		phone VARCHAR(50) NULL,
		email VARCHAR(50) NULL,
		dtmt_school TINYINT NULL,
		sbsk TINYINT NULL,
		sbsk_num VARCHAR(10) NULL,
		disability_teacher TINYINT NULL,
		disability_kh VARCHAR(150) NULL,
		disability_note VARCHAR(255) NULL,
		position_kh VARCHAR(180) NULL,
		additional_position_kh VARCHAR(180) NULL, 
		work_history_start_date DATE NULL,
		work_history_prokah_num VARCHAR(50) NULL, 
		family_fullname_kh VARCHAR(180) NULL,
		familty_occupation VARCHAR(255) NULL,
		familty_workplace VARCHAR(350) NULL,
		familty_allowance TINYINT NULL,
		familty_phonenumber VARCHAR(50) NULL,
		familty_dob DATE NULL,
		highest_profession_kh VARCHAR(150) NULL,
		profession_subject1 VARCHAR(180) NULL,
		profession_subject2 VARCHAR(180) NULL,
		profession_type_kh VARCHAR(150) NULL,
		profession_date DATE NULL, 
		profession_location_kh VARCHAR(150) NULL,
		highest_qualification_kh VARCHAR(150) NULL, 
		qual_location_kh VARCHAR(150) NULL, 
		qual_country_kh VARCHAR(150) NULL, 
		qual_subject_kh VARCHAR(180) NULL, 
		salary_level_kh VARCHAR(6) NULL, 
		salary_degree VARCHAR(2) NULL, 
		salary_shift_date DATE NULL, 
		salary_prokah_num VARCHAR(50) NULL, 
		salary_cardre_type_kh VARCHAR(60) NULL, 
		salary_prokah_order SMALLINT NULL,
		add_teaching TINYINT NULL,
		teach_english TINYINT NULL,
		multi_grade TINYINT NULL,
		triple_grade TINYINT NULL,
		double_shift TINYINT NULL,
		bi_language TINYINT NULL,
		class_incharge TINYINT NULL,
		chief_technical TINYINT NULL,
		teach_cross_school TINYINT NULL,
		teaching_cross_school_kh VARCHAR(150) NULL,
		work_province VARCHAR(150) NULL,
		work_district VARCHAR(150) NULL,
		work_commune VARCHAR(150) NULL,
		work_office VARCHAR(150) NULL,
		work_location VARCHAR(150) NULL
	) ENGINE=MYISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
	-- Query Here...
	INSERT INTO `tmp_multi_criteria_search` (
			payroll_id, location_code, pro_code, dis_code, com_code, vil_code, 
			nid_card, bank_account, last_name_kh, first_name_kh, last_name_en, first_name_en, sex, dob, ethnic_kh, 
			photo, birth_province, birth_district, birth_commune, birth_village, start_date, appointment_date, 
			status_kh, maritalstatus_kh, adr_province, adr_district, adr_commune, adr_village, phone, email, 
			dtmt_school, sbsk, sbsk_num, disability_teacher, disability_kh, disability_note, 
			position_kh, additional_position_kh, work_history_start_date, work_history_prokah_num,
			family_fullname_kh, familty_occupation, familty_workplace, familty_allowance, familty_phonenumber, familty_dob, 
			highest_profession_kh, profession_subject1, profession_subject2, profession_type_kh, profession_date, profession_location_kh, 
			highest_qualification_kh, qual_location_kh, qual_country_kh, qual_subject_kh, 
			salary_level_kh, salary_degree, salary_shift_date, salary_prokah_num, salary_cardre_type_kh, salary_prokah_order, 
			add_teaching, teach_english, multi_grade, triple_grade, double_shift, bi_language, class_incharge, chief_technical, 
			teach_cross_school, teaching_cross_school_kh, 
			work_province, work_district, work_commune, work_office, work_location
		)
	SELECT DISTINCT t_staffs.payroll_id, wh_location.location_code, 
		wh_location.pro_code, wh_location.dis_code, wh_location.com_code, wh_location.vil_code, 
		t_staffs.nid_card, t_staffs.bank_account, t_staffs.surname_kh, t_staffs.name_kh, 
		t_staffs.surname_en, t_staffs.name_en, t_staffs.sex, t_staffs.dob, t_ethnics.ethnic_kh, t_staffs.photo, 
		t_birth_pro.name_kh,  
		t_staffs.birth_district, t_staffs.birth_commune, t_staffs.birth_village, 
		t_staffs.start_date, t_staffs.appointment_date, t_status.status_kh, t_marital.maritalstatus_kh, 
		t_provinces.name_kh, t_districts.name_kh, t_communes.name_kh, t_villages.name_kh, 
		t_staffs.phone, t_staffs.email, t_staffs.dtmt_school, t_staffs.sbsk, t_staffs.sbsk_num, 
		t_staffs.disability_teacher, t_disabilities.disability_kh, t_staffs.disability_note, 
		t_work_positions.position_kh, t_work_positions.position_kh, t_works.start_date, t_works.prokah_num, 
		(SELECT fullname_kh FROM hrmis_families 
            WHERE hrmis_families.payroll_id = t_staffs.payroll_id
            ORDER BY hrmis_families.relation_type_id ASC LIMIT 1
		) AS family_fullname_kh, 
		(SELECT occupation FROM hrmis_families 
            WHERE hrmis_families.payroll_id = t_staffs.payroll_id
            ORDER BY hrmis_families.relation_type_id ASC LIMIT 1
		) AS familty_occupation, 
		(SELECT spouse_workplace FROM hrmis_families 
            WHERE hrmis_families.payroll_id = t_staffs.payroll_id
            ORDER BY hrmis_families.relation_type_id ASC LIMIT 1
		) AS familty_workplace, 
		(SELECT allowance FROM hrmis_families 
            WHERE hrmis_families.payroll_id = t_staffs.payroll_id
            ORDER BY hrmis_families.relation_type_id ASC LIMIT 1
		) AS familty_allowance, 
		(SELECT phone_number FROM hrmis_families 
            WHERE hrmis_families.payroll_id = t_staffs.payroll_id
            ORDER BY hrmis_families.relation_type_id ASC LIMIT 1
		) AS familty_phonenumber, 
		(SELECT dob FROM hrmis_families 
            WHERE hrmis_families.payroll_id = t_staffs.payroll_id
            ORDER BY hrmis_families.relation_type_id ASC LIMIT 1
		) AS familty_dob, 
		(SELECT prof_category_kh FROM hrmis_staff_professions AS t_staff_professions INNER JOIN sys_professional_categories 
            ON t_staff_professions.prof_category_id=sys_professional_categories.prof_category_id
            WHERE t_staff_professions.payroll_id=t_staffs.payroll_id
            ORDER BY sys_professional_categories.prof_hierachy LIMIT 1
		) AS profession_kh, 
		(SELECT subject_kh FROM hrmis_staff_professions INNER JOIN sys_professional_categories 
			ON hrmis_staff_professions.prof_category_id = sys_professional_categories.prof_category_id
			 INNER JOIN sys_subjects ON hrmis_staff_professions.subject_id1=sys_subjects.subject_id
			    WHERE hrmis_staff_professions.payroll_id=t_staffs.payroll_id
			ORDER BY sys_professional_categories.prof_hierachy LIMIT 1
		) AS subject_1, 
        (SELECT subject_kh FROM hrmis_staff_professions INNER JOIN sys_professional_categories 
			ON hrmis_staff_professions.prof_category_id = sys_professional_categories.prof_category_id
			 INNER JOIN sys_subjects ON hrmis_staff_professions.subject_id2=sys_subjects.subject_id
			    WHERE hrmis_staff_professions.payroll_id=t_staffs.payroll_id
			ORDER BY sys_professional_categories.prof_hierachy LIMIT 1
		) AS subject_2, 
		(SELECT prof_type_kh FROM hrmis_staff_professions INNER JOIN sys_professional_categories 
			ON hrmis_staff_professions.prof_category_id = sys_professional_categories.prof_category_id
			 INNER JOIN sys_professional_types ON hrmis_staff_professions.prof_type_id=sys_professional_types.prof_type_id
			    WHERE hrmis_staff_professions.payroll_id=t_staffs.payroll_id
			ORDER BY sys_professional_categories.prof_hierachy LIMIT 1
		) AS profession_type_kh, 
		(SELECT prof_date FROM hrmis_staff_professions INNER JOIN sys_professional_categories 
            ON hrmis_staff_professions.prof_category_id = sys_professional_categories.prof_category_id
            WHERE hrmis_staff_professions.payroll_id = t_staffs.payroll_id
            ORDER BY sys_professional_categories.prof_hierachy LIMIT 1
		) AS profession_date, 
		(SELECT location_kh FROM hrmis_staff_professions INNER JOIN sys_professional_categories 
			ON hrmis_staff_professions.prof_category_id = sys_professional_categories.prof_category_id
			INNER JOIN sys_locations ON hrmis_staff_professions.location_code=sys_locations.location_code
			WHERE hrmis_staff_professions.payroll_id=t_staffs.payroll_id
			ORDER BY sys_professional_categories.prof_hierachy LIMIT 1
		) AS profession_location_kh, 
		-- Qualification
		(SELECT qualification_kh FROM hrmis_staff_qualifications INNER JOIN sys_qualification_codes 
			ON hrmis_staff_qualifications.qualification_code = sys_qualification_codes.qualification_code 
			WHERE hrmis_staff_qualifications.payroll_id=t_staffs.payroll_id
			ORDER BY sys_qualification_codes.qualification_hierachy DESC LIMIT 1
		) AS highest_qualification_kh, 
		(SELECT location_kh FROM hrmis_staff_qualifications INNER JOIN sys_qualification_codes 
			ON hrmis_staff_qualifications.qualification_code = sys_qualification_codes.qualification_code 
			WHERE hrmis_staff_qualifications.payroll_id=t_staffs.payroll_id 
			ORDER BY sys_qualification_codes.qualification_hierachy DESC LIMIT 1
		) AS qual_location_kh, 
		(SELECT country_kh FROM hrmis_staff_qualifications INNER JOIN sys_qualification_codes 
			ON hrmis_staff_qualifications.qualification_code = sys_qualification_codes.qualification_code
				INNER JOIN sys_countries ON hrmis_staff_qualifications.country_id=sys_countries.country_id
			    WHERE hrmis_staff_qualifications.payroll_id=t_staffs.payroll_id
			ORDER BY sys_qualification_codes.qualification_hierachy DESC LIMIT 1
		) AS qual_country_kh, 
		(SELECT subject_kh FROM hrmis_staff_qualifications INNER JOIN sys_qualification_codes 
			ON hrmis_staff_qualifications.qualification_code = sys_qualification_codes.qualification_code
				INNER JOIN sys_subjects ON hrmis_staff_qualifications.subject_id=sys_subjects.subject_id
			    WHERE hrmis_staff_qualifications.payroll_id=t_staffs.payroll_id
			ORDER BY sys_qualification_codes.qualification_hierachy DESC LIMIT 1
		) AS qual_subject_kh, 
		(SELECT salary_level_kh FROM hrmis_staff_salaries INNER JOIN salary_levels 
            ON hrmis_staff_salaries.salary_level_id = salary_levels.salary_level_id
            WHERE hrmis_staff_salaries.payroll_id = t_staffs.payroll_id
            ORDER BY hrmis_staff_salaries.salary_type_shift_date DESC LIMIT 1
		) AS salary_level_kh, 
		(SELECT salary_degree FROM hrmis_staff_salaries 
            WHERE hrmis_staff_salaries.payroll_id = t_staffs.payroll_id
            ORDER BY hrmis_staff_salaries.salary_type_shift_date DESC LIMIT 1
		) AS salary_degree, 
		(SELECT salary_type_shift_date FROM hrmis_staff_salaries 
            WHERE hrmis_staff_salaries.payroll_id = t_staffs.payroll_id
            ORDER BY hrmis_staff_salaries.salary_type_shift_date DESC LIMIT 1
		) AS salary_shift_date, 
		(SELECT salary_type_prokah_num FROM hrmis_staff_salaries 
            WHERE hrmis_staff_salaries.payroll_id = t_staffs.payroll_id
            ORDER BY hrmis_staff_salaries.salary_type_shift_date DESC LIMIT 1
		) AS salary_type_prokah_num, 
		(SELECT cardre_type_kh FROM hrmis_staff_salaries INNER JOIN sys_cardre_types 
            ON hrmis_staff_salaries.cardre_type_id = sys_cardre_types.cardre_type_id
            WHERE hrmis_staff_salaries.payroll_id = t_staffs.payroll_id
            ORDER BY hrmis_staff_salaries.salary_type_shift_date DESC LIMIT 1
		) AS salary_cardre_type_kh, 
		(SELECT salary_type_prokah_order FROM hrmis_staff_salaries 
            WHERE hrmis_staff_salaries.payroll_id = t_staffs.payroll_id
            ORDER BY hrmis_staff_salaries.salary_type_shift_date DESC LIMIT 1
		) AS salary_prokah_order, 
		(SELECT add_teaching FROM hrmis_staff_teachings 
            WHERE hrmis_staff_teachings.payroll_id = t_staffs.payroll_id
            AND hrmis_staff_teachings.year_id=@academic_id LIMIT 1
		) AS add_teaching, 
		(SELECT teach_english FROM hrmis_staff_teachings 
            WHERE hrmis_staff_teachings.payroll_id = t_staffs.payroll_id
            AND hrmis_staff_teachings.year_id=@academic_id LIMIT 1
		) AS teach_english,
		(SELECT multi_grade FROM hrmis_staff_teachings 
            WHERE hrmis_staff_teachings.payroll_id = t_staffs.payroll_id
            AND hrmis_staff_teachings.year_id=@academic_id LIMIT 1
		) AS multi_grade,
		(SELECT triple_grade FROM hrmis_staff_teachings 
            WHERE hrmis_staff_teachings.payroll_id = t_staffs.payroll_id
            AND hrmis_staff_teachings.year_id=@academic_id LIMIT 1
		) AS triple_grade,
		(SELECT double_shift FROM hrmis_staff_teachings 
            WHERE hrmis_staff_teachings.payroll_id = t_staffs.payroll_id
            AND hrmis_staff_teachings.year_id=@academic_id LIMIT 1
		) AS double_shift,
		(SELECT bi_language FROM hrmis_staff_teachings 
            WHERE hrmis_staff_teachings.payroll_id = t_staffs.payroll_id
            AND hrmis_staff_teachings.year_id=@academic_id LIMIT 1
		) AS bi_language,
		(SELECT class_incharge FROM hrmis_staff_teachings 
            WHERE hrmis_staff_teachings.payroll_id = t_staffs.payroll_id
            AND hrmis_staff_teachings.year_id=@academic_id LIMIT 1
		) AS class_incharge,
		(SELECT chief_technical FROM hrmis_staff_teachings 
            WHERE hrmis_staff_teachings.payroll_id = t_staffs.payroll_id
            AND hrmis_staff_teachings.year_id=@academic_id LIMIT 1
		) AS chief_technical,
		(SELECT teach_cross_school FROM hrmis_staff_teachings 
            WHERE hrmis_staff_teachings.payroll_id = t_staffs.payroll_id
            AND hrmis_staff_teachings.year_id=@academic_id LIMIT 1
		) AS teach_cross_school,
		(SELECT location_kh FROM hrmis_staff_teachings INNER JOIN sys_locations 
            ON hrmis_staff_teachings.location_code = sys_locations.location_code
            WHERE hrmis_staff_teachings.payroll_id = t_staffs.payroll_id
            AND hrmis_staff_teachings.year_id=@academic_id LIMIT 1
		) AS teaching_cross_school_kh, 
		wh_pro.name_kh, wh_dis.name_kh, wh_com.name_kh, wh_office.office_kh, wh_location.location_kh
	FROM hrmis_staffs AS t_staffs 
	-- Work Histories
	INNER JOIN (hrmis_work_histories AS t_works  
			INNER JOIN sys_positions AS t_work_positions ON t_work_positions.position_id=t_works.position_id 
			INNER JOIN sys_locations AS wh_location ON wh_location.location_code=t_works.location_code 
			LEFT JOIN sys_offices AS wh_office ON t_works.sys_admin_office_id=wh_office.office_id
			LEFT JOIN sys_provinces AS wh_pro ON wh_location.pro_code=wh_pro.pro_code
			LEFT JOIN sys_districts AS wh_dis ON wh_location.dis_code=wh_dis.dis_code
			LEFT JOIN sys_communes AS wh_com ON wh_location.com_code=wh_com.com_code			
		) ON t_staffs.payroll_id=t_works.payroll_id 
	
	-- Family
	LEFT JOIN (hrmis_families AS t_families
			LEFT JOIN sys_relation_types ON t_families.relation_type_id = sys_relation_types.relation_type_id
		) ON t_staffs.payroll_id=t_families.payroll_id 
	-- Languages
	/*LEFT JOIN (hrmis_staff_languages AS t_staff_lang
			LEFT JOIN sys_languages ON t_staff_lang.language_id = sys_languages.language_id
		) ON t_staffs.payroll_id=t_staff_lang.payroll_id*/
	-- Leaves
	LEFT JOIN (hrmis_staff_leaves AS t_staff_leaves
			INNER JOIN sys_leave_types ON t_staff_leaves.leave_type_id = sys_leave_types.leave_type_id
		) ON t_staffs.payroll_id=t_staff_leaves.payroll_id
	-- Qualification
	/*INNER JOIN (hrmis_staff_qualifications AS t_staff_qual
			LEFT JOIN sys_qualification_codes AS qual_code ON t_staff_qual.qualification_code = qual_code.qualification_code
			LEFT JOIN sys_provinces AS qual_pro ON t_staff_qual.pro_code = qual_pro.pro_code 
			LEFT JOIN sys_subjects AS qual_sub ON t_staff_qual.subject_id = qual_sub.subject_id 
			LEFT JOIN sys_countries AS qual_cou ON t_staff_qual.country_id = qual_cou.country_id
		) ON t_staffs.payroll_id = t_staff_qual.payroll_id */
	INNER JOIN sys_staff_status AS t_status ON t_staffs.staff_status_id = t_status.status_id
	LEFT JOIN sys_ethnics AS t_ethnics ON t_staffs.ethnic_id = t_ethnics.ethnic_id 
	LEFT JOIN sys_maritalstatus AS t_marital ON t_staffs.maritalstatus_id = t_marital.maritalstatus_id
	LEFT JOIN sys_disabilities AS t_disabilities ON t_staffs.disability_id = t_disabilities.disability_id
	LEFT JOIN sys_provinces AS t_provinces ON t_staffs.adr_pro_code = t_provinces.pro_code
	LEFT JOIN sys_provinces AS t_birth_pro ON t_staffs.birth_pro_code = t_birth_pro.pro_code
	LEFT JOIN sys_districts AS t_districts ON t_staffs.adr_dis_code = t_districts.dis_code
	LEFT JOIN sys_communes AS t_communes ON t_staffs.adr_com_code = t_communes.com_code
	LEFT JOIN sys_villages AS t_villages ON t_staffs.adr_vil_code = t_villages.vil_code 
	WHERE t_works.cur_pos=1;
END$$

DELIMITER ;