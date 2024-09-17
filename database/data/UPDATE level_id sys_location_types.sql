UPDATE sys_location_types SET level_id=1 WHERE location_type_id=1;
UPDATE sys_location_types SET level_id=2 WHERE location_type_id IN (2,3,4,5,6,7,8,9,10,11);
UPDATE sys_location_types SET level_id=3 WHERE location_type_id IN (12, 19);
UPDATE sys_location_types SET level_id=4 WHERE location_type_id=13;
UPDATE sys_location_types SET level_id=5 WHERE location_type_id IN (14, 15, 16, 17, 18);