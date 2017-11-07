CREATE TABLE `{list}` (
    `id` int(10) unsigned NOT NULL auto_increment,
    `uid` int(10) unsigned NOT NULL default '0',
    `item` int(10) unsigned NOT NULL default '0',
    `table` varchar(64) NOT NULL default '',
    `module` varchar(64) NOT NULL default '',
    `ip` char(15) NOT NULL default '',
    `time_create` int(10) unsigned NOT NULL default '0',
     `source` ENUM ("WEB", "MOBILE") NOT NULL DEFAULT  'WEB',
    PRIMARY KEY (`id`),
    KEY `module` (`module`),
    KEY `table` (`table`),
    KEY `item` (`item`),
    KEY `uid` (`uid`),
    KEY `ip` (`ip`),
    KEY `time_create` (`time_create`),
    KEY `list` (`uid`, `item`, `table`, `module`)
);
