CREATE TABLE `{list}` (
  `id`          INT(10) UNSIGNED       NOT NULL AUTO_INCREMENT,
  `uid`         INT(10) UNSIGNED       NOT NULL DEFAULT '0',
  `item`        INT(10) UNSIGNED       NOT NULL DEFAULT '0',
  `table`       VARCHAR(64)            NOT NULL DEFAULT '',
  `module`      VARCHAR(64)            NOT NULL DEFAULT '',
  `ip`          CHAR(15)               NOT NULL DEFAULT '',
  `time_create` INT(10) UNSIGNED       NOT NULL DEFAULT '0',
  `source`      ENUM ("WEB", "MOBILE") NOT NULL DEFAULT 'WEB',
  PRIMARY KEY (`id`),
  KEY `module` (`module`),
  KEY `table` (`table`),
  KEY `item` (`item`),
  KEY `uid` (`uid`),
  KEY `ip` (`ip`),
  KEY `time_create` (`time_create`),
  KEY `list` (`uid`, `item`, `table`, `module`)
);
