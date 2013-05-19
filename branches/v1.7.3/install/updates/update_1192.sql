ALTER TABLE prefix_statpoints DROP `stat_code`, DROP `stat_date`;
ALTER TABLE prefix_rw DROP `raport`;
DELETE FROM prefix_topkb WHERE `raport` != '';
ALTER TABLE prefix_topkb DROP `raport`;
ALTER TABLE prefix_planets DROP `points`, DROP `ranks`;