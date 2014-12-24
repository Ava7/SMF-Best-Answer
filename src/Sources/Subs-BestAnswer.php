<?php

/*
 * Simple Machines Forum (SMF)
 *
 * @package BestAnswer
 * @author Avalanche91 http://www.ava7.eu
 * @copyright 2013 - Ava7.eu - All Rights Reserved.
 * @version 1.4
 * @license Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License http://creativecommons.org/licenses/by-nc-sa/3.0/
 * 
 */

if (!defined('SMF'))
	die('Hacking attempt...');

/*
	This file is the Model for Best Answer plug-in.

	void bestanswer_add_hook()
		- using a hook following the official documentation

	int isUnique(int id_msg, int id_topic)
		- checks if somebody else has already checked the answers as best solution

	array getMsgInfo(int id_msg)
		- returns the necessary information regarding the posted message

	void markBest(int id_msg, int id_member, int id_topic)
		- sets the passed message as best solution

	void unMarkBest(int id_msg)
		- deletes a record from the database in order to unset a reply as Best Answer
*/

function bestanswer_add_hook(&$actionArray)
{
	$actionArray['bestanswer'] = array('BestAnswer.php', 'BestAnswerMain');
}



function isUnique($id, $idTopic) {

	global $smcFunc;

	$query = $smcFunc['db_query']('',
		'SELECT `id`,`id_msg`,`id_topic`
		FROM {db_prefix}best_answer
		WHERE `id_msg`={int:id_msg} OR `id_topic`={int:id_topic}',
	array('id_msg' => $id, 'id_topic' => $idTopic));
	return array($smcFunc['db_num_rows']($query), $smcFunc['db_fetch_assoc']($query));
}

function getMsgInfo($id) {

	global $smcFunc;

	$query = $smcFunc['db_query']('',
		'SELECT `m`.`id_msg`,`m`.`id_member`,`m`.`id_topic`, `t`.`id_member_started`
		FROM {db_prefix}messages AS `m`
		INNER JOIN {db_prefix}topics AS `t`
		ON `m`.`id_topic`=`t`.`id_topic`
		WHERE `id_msg`={int:id_msg}',
		array('id_msg' => $id));
	return $smcFunc['db_fetch_assoc']($query);
}

function markBest($idMsg, $idMember, $idTopic) {

	global $smcFunc;

	$smcFunc['db_insert']('insert', '{db_prefix}best_answer',
		array('id_msg' => 'int', 'id_topic' => 'int', 'id_member' => 'int', 'time_marked' => 'string'),
		array($idMsg, $idTopic, $idMember, date('Y-m-d H:i:s')), '');
}

function unMarkBest($id) {

	global $smcFunc;

	$smcFunc['db_query']('',
		'DELETE FROM {db_prefix}best_answer WHERE `id`={int:id}',
		array('id' => $id));
}