DROP FUNCTION IF EXISTS func_getMaxQualification;

DELIMITER |

CREATE  FUNCTION func_getMaxQualification( payroll_id VARCHAR(10) )
RETURNS VARCHAR(150)
READS SQL DATA
DETERMINISTIC
BEGIN
    DECLARE maxQualification VARCHAR(150);

    SELECT temp_qual.qualification_kh
    FROM hrmis_staffs AS s
    LEFT JOIN (
        SELECT q.payroll_id, q.qualification_code, qc.qualification_kh, qc.qualification_hierachy
        FROM hrmis_staff_qualifications AS q
        INNER JOIN sys_qualification_codes AS qc ON q.qualification_code=qc.qualification_code
    ) AS temp_qual
    ON s.payroll_id=temp_qual.payroll_id
    WHERE s.payroll_id=payroll_id
    ORDER BY temp_qual.qualification_hierachy DESC
    LIMIT 1
    INTO maxQualification;

    RETURN maxQualification;
END|

DELIMITER ;