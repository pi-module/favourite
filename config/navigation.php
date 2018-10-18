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
    'admin' => [
        'last'  => [
            'label'      => _a('Last favourite'),
            'permission' => [
                'resource' => 'index',
            ],
            'route'      => 'admin',
            'controller' => 'index',
            'action'     => 'index',
        ],
        'tools' => [
            'label'      => _a('Tools'),
            'permission' => [
                'resource' => 'tools',
            ],
            'route'      => 'admin',
            'controller' => 'tools',
            'action'     => 'index',
        ],
    ],
];