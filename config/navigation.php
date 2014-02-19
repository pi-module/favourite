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
    'admin' => array(
        'last' => array(
            'label' => __('Last favourite'),
            'permission' => array(
                'resource' => 'index',
            ),
            'route' => 'admin',
            'controller' => 'index',
            'action' => 'index',
        ),
        'tools' => array(
            'label' => __('Tools'),
            'permission' => array(
                'resource' => 'tools',
            ),
            'route' => 'admin',
            'controller' => 'tools',
            'action' => 'index',
        ),
    ),
);