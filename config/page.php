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
    // Admin section
    'admin' => array(
        array(
            'title'         => _a('Last favourite'),
            'controller'    => 'index',
            'permission'    => 'index',
        ),
        array(
            'title'         => _a('Tools'),
            'controller'    => 'tools',
            'permission'    => 'tools',
        ),
    ),
);