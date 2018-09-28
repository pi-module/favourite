<?php
/**
 * Pi Engine (http://piengine.org)
 *
 * @link            http://code.piengine.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://piengine.org
 * @license         http://piengine.org/license.txt New BSD License
 */

/**
 * @author Hossein Azizabadi <azizabadi@faragostaresh.com>
 */
return [
    'category' => [
        [
            'title' => _a('Admin'),
            'name'  => 'admin',
        ],
        [
            'title' => _a('Favourite'),
            'name'  => 'favourite',
        ],
    ],
    'item'     => [
        // Admin
        'admin_perpage'        => [
            'category'    => 'admin',
            'title'       => _a('Perpage'),
            'description' => '',
            'edit'        => 'text',
            'filter'      => 'number_int',
            'value'       => 50,
        ],
        'admin_count'          => [
            'category'    => 'admin',
            'title'       => _a('Favourite count'),
            'description' => _a('Count of X last favourite for show in admin'),
            'edit'        => 'text',
            'filter'      => 'number_int',
            'value'       => 500,
        ],
        // favourite
        'favourite_delay'      => [
            'category'    => 'favourite',
            'title'       => _a('Delay time'),
            'description' => _a('Delay time between two favourite for each user. According to second, Set 0 for cancel check'),
            'edit'        => 'text',
            'filter'      => 'number_int',
            'value'       => 60,
        ],
        'favourite_icon'       => [
            'title'       => _a('Icon'),
            'description' => '',
            'edit'        => [
                'type'    => 'select',
                'options' => [
                    'options' => [
                        'star'     => _a('Star'),
                        'heart'    => _a('Heart'),
                        'bookmark' => _a('Bookmark'),
                        'wishlist' => _a('Wishlist'),
                    ],
                ],
            ],
            'filter'      => 'text',
            'value'       => 'star',
            'category'    => 'favourite',
        ],
        'favourite_view_count' => [
            'category'    => 'favourite',
            'title'       => _a('Show count'),
            'description' => '',
            'edit'        => 'checkbox',
            'filter'      => 'number_int',
            'value'       => 1,
        ],
        'favourite_list'       => [
            'category'    => 'favourite',
            'title'       => _a('Show user list'),
            'description' => '',
            'edit'        => 'checkbox',
            'filter'      => 'number_int',
            'value'       => 1,
        ],
    ],
];
