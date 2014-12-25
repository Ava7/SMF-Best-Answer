<?php

if(!defined('SMF')) {
    die('Cannot install - please verify you put this in the same place as SMF\'s index.php and SSI.php files.');
}

if(file_exists(dirname(__FILE__) . '/SSI.php') && !defined('SMF')) {
    require_once(dirname(__FILE__) . '/SSI.php');
}

add_integration_function('integrate_pre_include', '$sourcedir/Subs-BestAnswer.php');
add_integration_function('integrate_actions', 'bestanswer_add_hook');

$columns = array(
    array(
        'name' => 'id',
        'type' => 'int',
        'size' => 11,
        'null' => 'not null',
        'auto' => true,
    ),
    array(
        'name' => 'id_msg',
        'type' => 'int',
        'size' => 11,
        'null' => 'not null',
    ),
    array(
        'name' => 'id_topic',
        'type' => 'int',
        'size' => 11,
        'null' => 'not null',
    ),
    array(
        'name' => 'id_member',
        'type' => 'int',
        'size' => 11,
        'null' => 'not null',
    ),
    array(
        'name' => 'time_marked',
        'type' => 'datetime',
        'null' => 'not null'
    )
);

$indexes = array(
    array(
        'type' => 'primary',
        'columns' => array('id')
    )
);

$smcFunc['db_create_table']('{db_prefix}best_answer', $columns, $indexes);
