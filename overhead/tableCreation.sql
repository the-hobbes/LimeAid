CREATE TABLE `HELPLINE_Limeaid`.`table_assignee` ( 
	pk_email             VARCHAR( 100 ) NOT NULL,
	fld_firstname        VARCHAR( 100 ),
	fld_lastname         VARCHAR( 100 ),
	CONSTRAINT pk_table_assignee PRIMARY KEY ( pk_email )
 );

CREATE TABLE `HELPLINE_Limeaid`.`table_tags` ( 
	pk_tagname           VARCHAR( 100 ) NOT NULL,
	CONSTRAINT pk_table_tags PRIMARY KEY ( pk_tagname )
 );

CREATE TABLE `HELPLINE_Limeaid`.`table_intersection` ( 
	fk_email             VARCHAR( 100 ) NOT NULL,
	fk_tag               VARCHAR( 100 ) NOT NULL,
	CONSTRAINT idx_table_intersection_0 PRIMARY KEY ( fk_email, fk_tag )
 );