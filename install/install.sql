CREATE TABLE  IF NOT EXISTS `simpleschedule_contents` (
  `idx` int(90) NOT NULL AUTO_INCREMENT,
  `seq` int(90) NOT NULL,
  `title` varchar(90) NOT NULL DEFAULT '',
  `memo` varchar(500) NOT NULL DEFAULT '',
  `map_location` varchar(300) NOT NULL DEFAULT '',
  `latitude` varchar(90) NOT NULL,
  `longitude` varchar(90) NOT NULL,
  `start_day` date NOT NULL,
  `start_time` int(11) NOT NULL,
  `end_day` date NOT NULL,
  `end_time` int(11) NOT NULL,
  `is_recursive` varchar(5) NOT NULL,
  `date_created` int(90) DEFAULT NULL,
  PRIMARY KEY (`idx`)
);
