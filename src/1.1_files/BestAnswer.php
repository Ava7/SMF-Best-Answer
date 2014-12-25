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

function BestAnswerMain()
{

    // Second, give ourselves access to all the global variables we will need for this action
    global $context, $scripturl, $txt, $user_info, $db_prefix;

    $context['do'] = strip_tags($_GET['do']);
    $context['id_msg'] = (int) $_GET['msg'];

    // Marking an answer as best solution - only if the get corresponds correctly
    if (isset($context['do'])) {

        // We better make sure nobody is messing with the GET
        if ($context['id_msg'] > 0) {

            // Need to check if this really is the author of the post
            $query = db_query("SELECT `m`.`id_msg`,`m`.`id_member`,`m`.`id_topic`, `t`.`id_member_started` FROM {$db_prefix}messages AS `m` INNER JOIN {$db_prefix}topics AS `t` ON `m`.`id_topic`=`t`.`id_topic` WHERE `id_msg`='" . $context['id_msg'] . "'", __FILE__, __LINE__);
            $msgInfo = mysql_fetch_assoc($query);
            $adminOrModerator = array(1, 2, 3); //from the DB: 1=>Admin, 2=>Global Mod, 3=>Mod;

            // Check whether the user is the post owner or, an admin or a mod
            if ($context['user']['id'] == $msgInfo['id_member_started'] || ($context['user']['is_mod'] || $context['user']['is_admin'])) {

                // Let's see if the answer is already marked as best solution
                $query = db_query("SELECT `id`,`id_msg`,`id_topic` FROM {$db_prefix}best_answer WHERE `id_msg`='" . $context['id_msg'] . "' OR `id_topic`='" . $msgInfo['id_topic'] ."'", __FILE__, __LINE__);
                $cnt = mysql_num_rows($query); // How many rows returned?
                if (($cnt == 0) && $context['do'] == 'mark') {
                    // Either the author, or an admin or mod, can mark an answer as best solution
                    if (($msgInfo['id_member_started'] == $context['user']['id']) || in_array($user_info['groups'][0], $adminOrModerator)) {
                        db_query("INSERT INTO {$db_prefix}best_answer(`id_msg`,`id_topic`,`id_member`,`time_marked`) VALUES('" . $context['id_msg'] . "','" . $msgInfo['id_topic'] . "','" . $context['user']['id']  . "','" . date('Y-m-d H:i:s') . "')", __FILE__, __LINE__);
                    }
                } elseif (($cnt == 1) && $context['do'] == 'unmark') {
                    $result = mysql_fetch_assoc($query);
                    db_query("DELETE FROM {$db_prefix}best_answer WHERE `id`='" . $result['id'] . "'", __FILE__, __LINE__);
                }

            }
        }
    }
    redirectexit($scripturl . '?topic=' . $msgInfo['id_topic'] . '.msg' . $context['id_msg'] . '#msg' . $context['id_msg']);

}
