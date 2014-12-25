<?php

global $db_prefix;

if(!defined('SMF')) {
    die('Cannot install - please verify you put this in the same place as SMF\'s index.php and SSI.php files.');
}

if(file_exists(dirname(__FILE__) . '/SSI.php') && !defined('SMF')) {
    require_once(dirname(__FILE__) . '/SSI.php');
}
db_query("CREATE TABLE IF NOT EXISTS {$db_prefix}best_answer (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_msg` int(11) DEFAULT NULL,
  `id_topic` int(11) DEFAULT NULL,
  `id_member` int(11) DEFAULT NULL,
  `time_marked` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1", __FILE__, __LINE__);
