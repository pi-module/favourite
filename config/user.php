<?php
/**
 * Pi Engine (http://piengine.org)
 *
 * @link            http://code.piengine.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://piengine.org
 * @license         http://piengine.org/license.txt BSD 3-Clause License
 */

/**
 * User profile and resource specs
 *
 * @see Pi\Application\Installer\Resource\User
 * @author Taiwen Jiang <taiwenjiang@tsinghua.org.cn>
 */
return [
    // Activity
    'activity' => [
        'favourite' => [
            'title'    => _a('Favourites'),
            'callback' => 'Module\Favourite\Plugin\Favourite',
            'template' => 'user-favourite',
            'icon'     => '',

        ],
    ],
];
