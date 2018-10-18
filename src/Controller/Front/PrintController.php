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

namespace Module\Favourite\Controller\Front;

use Pi;
use Pi\Mvc\Controller\ActionController;

class PrintController extends ActionController
{

    public function indexAction()
    {
        $type = $this->params('type');

        $uid = Pi::user()->getId();
        // Set favourite
        $favourites = [];
        if ($uid > 0) {
            $favourites = Pi::api('favourite', 'favourite')->listFavouriteModule($type);
        }
        // Set view
        $this->view()->headdescription(__('List of user favourites'), 'set');
        $this->view()->headkeywords(__('list,user,favourite,website'), 'set');
        $this->view()->setTemplate('favourite-print')->setLayout('layout-content');
        $this->view()->assign('title', __('All your favorite'));
        $this->view()->assign('favourites', $favourites);
        $this->view()->assign('uid', $uid);

    }
}