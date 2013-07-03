CREATE TABLE `{list}` (
 `id` int(10) unsigned NOT NULL auto_increment,
 `uid` int(10) unsigned NOT NULL,
 `item` int(10) unsigned NOT NULL,
 `module` varchar(64) NOT NULL,
 `hostname` varchar(64) NOT NULL,
 `create` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `module` (`module`),
  KEY `item` (`item`),
  KEY `uid` (`uid`),  KEY `hostname` (`hostname`),
  KEY `create` (`create`),
  KEY `list` (`uid`, `module`, `item`)
);