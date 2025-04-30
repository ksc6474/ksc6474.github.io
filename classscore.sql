create database classscore;
use classscore;
create table scores (
	number	char(32)	 not null primary key,
	name		char(32)  	character set utf8,
	math		int(3),
	science 	int(3),
	korea		int(3),
	english		int(3),
	mean		int(3),
	sum		int(3)
);
describe scores;
