
DROP TABLE IF EXISTS country;
-- 国家地区
create table country (
   code varchar(5),
   cname varchar(30),
   ename varchar(100),
   phone_coe varchar(10),
   continent varchar(20),
   continent_jc varchar(10),
   mtime datetime default (datetime( 'now', 'localtime'))
);


