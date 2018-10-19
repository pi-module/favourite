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
    // Admin section
    'admin' => [
        [
            'title'      => _a('Last favourite'),
            'controller' => 'index',
            'permission' => 'index',
        ],
        [
            'title'      => _a('Tools'),
            'controller' => 'tools',
            'permission' => 'tools',
        ],
    ],
];