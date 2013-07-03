<?php
/**
 * Favorite module config
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       Copyright (c) Pi Engine http://www.xoopsengine.org
 * @license         http://www.xoopsengine.org/license New BSD License
 * @author          Hossein Azizabadi <azizabadi@faragostaresh.com>
 * @since           3.0
 * @package         Module\Favorite
 * @version         $Id$
 */

/**
 * Application manifest
 */
return array(
    // Module meta
    'meta' => array(
        // Module title, required
        'title' => __('Favorite'),
        // Description, for admin, optional
        'description' => __('Favorite system'),
        // Version number, required
        'version' => '1.0.0-beta.2',
        // Distribution license, required
        'license' => 'New BSD',
        // Logo image, for admin, optional
        'logo' => 'image/logo.png',
        // Readme file, for admin, optional
        'readme' => 'docs/readme.txt',
        // Demo site link, optional
        'demo' => 'http://demo.xoopsengine.org/favorite'
    ),
    // Author information
    'author' => array(
        // Author full name, required
        'name' => 'Hossein Azizabadi',
        // Email address, optional
        'email' => 'azizabadi@faragostaresh.com',
        // Website link, optional
        'website' => 'http://www.xoopsengine.org',
        // Credits and aknowledgement, optional
        'credits' => 'Zend Framework Team; Pi Engine Team'
    ),
    // Module dependency: list of module directory names, optional
    'dependency' => array(
    ),
    // Maintenance actions
    'maintenance' => array(
        // resource
        'resource' => array(
            // Database meta
            'database' => 'database.php',
            // Module configs
            'config' => 'config.php',
            // ACL specs
            'acl'           => 'acl.php',
            // Bootstrap, priority
            'bootstrap' => 1,
            // Navigation definition
            'navigation' => 'navigation.php',
        )
    )
);