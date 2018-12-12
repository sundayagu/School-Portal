SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS `contacts`;
CREATE TABLE `contacts` (
  `contact_id` int(11) NOT NULL auto_increment,
  `contact_first` varchar(255) character set latin1 default NULL,
  `contact_last` varchar(255) character set latin1 default NULL,
  `contact_email` varchar(255) character set latin1 default NULL,
  PRIMARY KEY  (`contact_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;