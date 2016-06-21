/*
 * 本次更新内容：（详细说明本次更新的记录以及更新的原因，注意：下面的call update_version(version_id, ret) 这一行一定要把version_id替换成新的版本id）
 * 
 */
 
delimiter $$
DROP PROCEDURE IF EXISTS update_sql;
create procedure update_sql()
us:begin
	DECLARE ret int(4);
	call update_version(0, ret);

	if(ret <> 1) THEN
	LEAVE us;
	end if;


	CREATE TABLE `tbl_shuang_se_qiu` (
  `qihao` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT '0000' COMMENT '期号',
  `hongqiu` varchar(32) DEFAULT NULL,
  `lanqiu` varchar(3) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	

end us$$
delimiter ;
call update_sql();
DROP PROCEDURE update_sql;