ALTER TABLE `phpraid_locations` Modify `ot` INT( 2 ) NOT NULL DEFAULT '0' AFTER `ro`;
ALTER TABLE `phpraid_locations` CHANGE `ot` `sh` INT( 2 ) NOT NULL DEFAULT '0';
ALTER TABLE `phpraid_locations` ADD `pa` INT( 2 ) NOT NULL DEFAULT '0' AFTER `ma`;

ALTER TABLE `phpraid_raids` Modify `ot_lmt` INT( 2 ) NOT NULL DEFAULT '0' AFTER `ro_lmt`;
ALTER TABLE `phpraid_raids` CHANGE `ot_lmt` `sh_lmt` INT( 2 ) NOT NULL DEFAULT '0';
ALTER TABLE `phpraid_raids` ADD `pa_lmt` INT( 2 ) NOT NULL DEFAULT '0' AFTER `ma_lmt`;