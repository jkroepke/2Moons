ALTER TABLE prefix_alliance ADD ally_max_members INT(5) unsigned NOT NULL DEFAULT 20;
ALTER TABLE prefix_alliance ADD ally_events VARCHAR(55) NOT NULL DEFAULT '';
ALTER TABLE prefix_alliance_ranks ADD EVENTS TINYINT(1) UNSIGNED NOT NULL DEFAULT 0;
ALTER TABLE prefix_config ADD alliance_create_min_points BIGINT UNSIGNED NOT NULL DEFAULT 0;
ALTER TABLE prefix_alliance ADD ally_request_min_points BIGINT UNSIGNED NOT NULL DEFAULT 0 AFTER ally_request_notallow;