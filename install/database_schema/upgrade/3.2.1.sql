delete from `phpraid_signups` WHERE profile_id IN (SELECT profile_id from phpraid_TC_profile where username='');

delete from `phpraid_chars` WHERE profile_id IN (SELECT profile_id from phpraid_TC_profile where username='');

delete from `phpraid_profile` where username='';

INSERT INTO `phpraid_config` VALUES ('armory_link','http://www.wowarmory.com');
INSERT INTO `phpraid_config` VALUES ('armory_language','en');
