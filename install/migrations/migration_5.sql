ALTER TABLE %PREFIX%fleets ADD `fleet_wanted_resource` tinyint(3) unsigned NOT NULL DEFAULT '0';
ALTER TABLE %PREFIX%fleets ADD `fleet_wanted_resource_amount` double(50,0) unsigned NOT NULL DEFAULT '0';
ALTER TABLE %PREFIX%fleets ADD `fleet_no_m_return` tinyint(1) unsigned NOT NULL DEFAULT '0';
ALTER TABLE %PREFIX%log_fleets ADD `fleet_wanted_resource` tinyint(3) unsigned NOT NULL DEFAULT '0';
ALTER TABLE %PREFIX%log_fleets ADD `fleet_wanted_resource_amount` double(50,0) unsigned NOT NULL DEFAULT '0';
ALTER TABLE %PREFIX%log_fleets ADD `fleet_no_m_return` tinyint(1) unsigned NOT NULL DEFAULT '0';
