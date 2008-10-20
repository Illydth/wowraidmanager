ALTER TABLE `phpraid_locations` ADD `dk` INT(2) NOT NULL default '0';
ALTER TABLE `phpraid_locations` ADD `event_type` tinyint(1) NOT NULL default '1';
ALTER TABLE `phpraid_raids` ADD `dk_lmt` INT(2) NOT NULL default '0';
ALTER TABLE `phpraid_raids` ADD `event_type` tinyint(1) NOT NULL default '1';

-- Update phpraid_locations and phpraid_raids to set every existing event to "1" for 
--   event_type.