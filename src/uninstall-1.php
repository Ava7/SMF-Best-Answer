<?php

if(!defined('SMF')) {
   	die('Cannot install - please verify you put this in the same place as SMF\'s index.php and SSI.php files.');
}

if(file_exists(dirname(__FILE__) . '/SSI.php') && !defined('SMF')) {
	require_once(dirname(__FILE__) . '/SSI.php');
}

global $db_prefix;

db_query("DROP TABLE {$db_prefix}best_answer");