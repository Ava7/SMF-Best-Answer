<?php

if(!defined('SMF')) {
   	die('Cannot install - please verify you put this in the same place as SMF\'s index.php and SSI.php files.');
}

if(file_exists(dirname(__FILE__) . '/SSI.php') && !defined('SMF')) {
	require_once(dirname(__FILE__) . '/SSI.php');
}

remove_integration_function('integrate_pre_include', '$sourcedir/Subs-BestAnswer.php');
remove_integration_function('integrate_actions', 'bestanswer_add_hook');