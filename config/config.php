<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt New BSD License
 */

/**
 * @author Hossein Azizabadi <azizabadi@faragostaresh.com>
 */
return array(
    'category' => array(
        array(
            'title' => _a('Admin'),
            'name' => 'admin'
        ),
        array(
            'title' => _a('Favourite'),
            'name' => 'favourite'
        ),
    ),
    'item' => array(
        // Admin
        'admin_perpage' => array(
            'category' => 'admin',
            'title' => _a('Perpage'),
            'description' => '',
            'edit' => 'text',
            'filter' => 'number_int',
            'value' => 50
        ),
        'admin_count' => array(
            'category' => 'admin',
            'title' => _a('Favourite count'),
            'description' => _a('Count of X last favourite for show in admin'),
            'edit' => 'text',
            'filter' => 'number_int',
            'value' => 500
        ),
        // favourite
        'favourite_delay' => array(
            'category' => 'favourite',
            'title' => _a('Delay time'),
            'description' => _a('Delay time between two favourite for each user. According to second, Set 0 for cancel check'),
            'edit' => 'text',
            'filter' => 'number_int',
            'value' => 60
        ),
        'favourite_icon' => array(
            'title' => _a('Icon'),
            'description' => '',
            'edit' => array(
                'type' => 'select',
                'options' => array(
                    'options' => array(
                        'star' => _a('Star'),
                        'heart' => _a('Heart'),
                        'bookmark' => _a('Bookmark'),
                    ),
                ),
            ),
            'filter' => 'text',
            'value' => 'star',
            'category' => 'favourite',
        ),
        'favourite_view_count' => array(
            'category' => 'favourite',
            'title' => _a('Show count'),
            'description' => '',
            'edit' => 'checkbox',
            'filter' => 'number_int',
            'value' => 1
        ),
    ),
);