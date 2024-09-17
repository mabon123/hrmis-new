DROP PROCEDURE IF EXISTS `sp_cpd_staff_credits`;
DELIMITER //

CREATE PROCEDURE `sp_cpd_staff_credits`(
	IN param_provider_id INT,
    IN param_start_date DATE,
    IN param_end_date DATE
)
BEGIN
	DECLARE cpd_offerings_num INT DEFAULT 0;
	DECLARE i INT DEFAULT 0;
    
	DROP TEMPORARY TABLE IF EXISTS `tmptbl_offerings`;
	CREATE TEMPORARY TABLE `tmptbl_offerings` (
		id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        schedule_course_id INT NOT NULL,
		provider_kh VARCHAR(150) NOT NULL,
        cpd_course_kh VARCHAR(200) NOT NULL,
		participant_num smallint NOT NULL,
        -- reg_num smallint NOT NULL,
        -- reg_f_num smallint NOT NULL,
        completed_num smallint NOT NULL,
        credits double(4, 2) NOT NULL,
        start_date DATE NOT NULL,
        end_date DATE NOT NULL
	) ENGINE=MYISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    
    -- Cteate temp table to store result
	DROP TEMPORARY TABLE IF EXISTS `tmptbl_results`;
	CREATE TEMPORARY TABLE `tmptbl_results` (
		id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        row_type INT NOT NULL, -- 1:header, 2: body, 3: footer
		/*---header fields---*/
		provider_kh VARCHAR(150) NULL,
        cpd_course_kh VARCHAR(200) NULL,
		start_date DATE NULL,
        end_date DATE NULL,
		/*--end header fields---*/
        -- Data fields
		payroll_id VARCHAR(10) NULL,
		fullname_kh VARCHAR(100) NULL,
		fullname_en VARCHAR(50) NULL,
		sex TINYINT NULL,
		dob DATE NULL,
		position_kh VARCHAR(150) NULL,
		location_kh VARCHAR(150) NULL,
		-- End Data fields
		-- Footer fields
		participant_num smallint NULL,
        reg_num smallint NULL,
        reg_f_num smallint NULL,
        completed_num smallint NULL,
        credits double(4, 2) NULL
		-- End footer fields
	) ENGINE=MYISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    
    -- Insert to table offerings
    SET @sql_str= 'INSERT INTO `tmptbl_offerings` (schedule_course_id, provider_kh, cpd_course_kh, participant_num, completed_num,
    credits, start_date, end_date) SELECT s_course.schedule_course_id, provider.provider_kh, course.cpd_course_kh, 
	s_course.participant_num, count(enroll.payroll_id) AS completed_num, course.credits, s_course.start_date, s_course.end_date 
	FROM cpd_schedule_courses AS s_course 
	INNER JOIN cpd_courses as course ON s_course.cpd_course_id=course.cpd_course_id
	INNER JOIN cpd_enrollment_courses AS enroll ON enroll.schedule_course_id=s_course.schedule_course_id
	INNER JOIN cpd_providers AS provider ON s_course.provider_id=provider.provider_id
	where enroll_status_id=6 AND confirm_completed=1 AND is_verified=1';
	IF param_provider_id > 0 THEN
		SET @sql_str := CONCAT(@sql_str, ' AND s_course.provider_id=', param_provider_id);
	END IF;
	IF param_start_date IS NOT NULL THEN
		SET @sql_str := CONCAT(@sql_str, ' AND s_course.start_date>=', "'",param_start_date,"'");
	END IF;
    IF param_end_date IS NOT NULL THEN
		SET @sql_str := CONCAT(@sql_str, ' AND s_course.end_date<=', "'",param_end_date,"'");
	END IF;
    SET @sql_str := CONCAT(@sql_str, ' GROUP BY s_course.schedule_course_id, provider.provider_kh, course.cpd_course_kh, 
	s_course.participant_num, course.credits, s_course.start_date, s_course.end_date 
	ORDER BY provider.provider_kh, s_course.start_date;');
    
    PREPARE stmt FROM @sql_str;
	EXECUTE stmt;
	DEALLOCATE PREPARE stmt;
	
    SET cpd_offerings_num = (SELECT COUNT(id) FROM `tmptbl_offerings`);
	SET i=1;
	WHILE i <= cpd_offerings_num DO 
		-- Insert header
        SELECT schedule_course_id, provider_kh, cpd_course_kh, start_date, end_date, 
        participant_num, completed_num, credits FROM `tmptbl_offerings` 
        WHERE id=i INTO @schedule_id, @provider, @course, @s_date, @e_date, @participant_num, @completed_num, @credits;
        
        INSERT INTO `tmptbl_results` (row_type, provider_kh, cpd_course_kh, start_date, end_date)
        VALUES (1, @provider, @course, @s_date, @e_date);
        
        -- Insert body
         INSERT INTO `tmptbl_results` (row_type, payroll_id, fullname_kh, fullname_en, sex, dob, position_kh, location_kh)
         SELECT 2, s.payroll_id, CONCAT(s.surname_kh, ' ', s.name_kh) as fullname_kh,
		CONCAT(s.surname_en, ' ', s.name_en) as fullname_en, s.sex, s.dob, p.position_kh, l.location_kh
		FROM hrmis_staffs AS s  
			 INNER JOIN ( hrmis_work_histories AS wh  
			 INNER JOIN sys_positions AS p ON p.position_id=wh.position_id 
			 INNER JOIN sys_locations AS l ON l.location_code=wh.location_code
		 ) ON s.payroll_id=wh.payroll_id
		INNER JOIN cpd_enrollment_courses as enroll ON s.payroll_id=enroll.payroll_id
		WHERE s.staff_status_id IN (1,2,7,8,10,14) AND wh.cur_pos=1 AND enroll.schedule_course_id=@schedule_id
		AND enroll.enroll_status_id=6 AND enroll.confirm_completed=1 AND enroll.is_verified=1;
        
		-- Insert footer
        SELECT COUNT(enroll.payroll_id) AS reg_num, SUM(CASE WHEN staff.sex=2 THEN 1 ELSE 0 END) AS reg_f_num 
		FROM cpd_enrollment_courses enroll
		INNER JOIN hrmis_staffs staff ON enroll.payroll_id=staff.payroll_id
		INNER JOIN cpd_schedule_courses s_course ON enroll.schedule_course_id=s_course.schedule_course_id
		WHERE enroll.schedule_course_id=@schedule_id INTO @reg_num, @reg_f_num;
        
        INSERT INTO `tmptbl_results` (row_type, participant_num, reg_num, reg_f_num, completed_num, credits)
        VALUES (3, @participant_num, @reg_num, @reg_f_num, @completed_num, @credits);
        
		SET i = i + 1;
	END WHILE;
    
    SELECT * FROM `tmptbl_results` ORDER BY id;

END //

DELIMITER ;