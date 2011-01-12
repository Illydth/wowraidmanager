INSERT INTO `wrm_config` VALUES ('wrm_utf8_support', '1');
INSERT INTO `wrm_config` VALUES ('template_body_width', 'width_normal');

INSERT INTO `wrm_events` ( `zone_desc`, `max`, `exp_id`, `event_type_id`, `wow_name`, `icon_path`) VALUES
('Skywall', 5, 4, 2, 'Skywall', 'images/instances/Cataclysm_Icons/dungeons/5-Skywall.jpg'),
('Skywall - Heroic', 5, 4, 2, 'Skywall (Heroic)', 'images/instances/Cataclysm_Icons/dungeons/5-Skywall-Heroic.jpg'),
('Skywall - 10 Man', 10, 4, 1, 'Skywall (10)', 'images/instances/Cataclysm_Icons/raids/10-Skywall.jpg'),
('Skywall - 25 Man', 10, 4, 1, 'Skywall (25)', 'images/instances/Cataclysm_Icons/raids/25-Skywall.jpg');

UPDATE `wrm_events` SET wow_name = 'Stonecore (Heroic)' WHERE zone_desc = 'Stonecore - Heroic' LIMIT 1;

INSERT INTO `wrm_version` VALUES ('4.1.2','Version 4.1.2 of WoW Raid Manager');
