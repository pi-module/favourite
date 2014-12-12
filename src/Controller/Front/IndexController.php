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

namespace Module\Favourite\Controller\Front;

use Pi;
use Pi\Mvc\Controller\ActionController;

class IndexController extends ActionController
{
    public function indexAction()
    {
        if ($this->request->isPost()) {
        	// Set template
        	$this->view()->setTemplate(false)->setLayout('layout-content');
        	// Get request from post
            $params = $this->params()->fromPost();
            // do favourite and return result
            return Pi::api('favourite', 'favourite')->doFavourite($params);
        } else {
        	// Set uid 
        	$uid = Pi::user()->getId();
        	// Set favourite
        	$favourites = array();
        	if ($uid > 0) {
        		$favourites = Pi::api('favourite', 'favourite')->listFavourite();
        	}
            // Set view
            $this->view()->headdescription(__('List of user favourites'), 'set');
            $this->view()->headkeywords(__('list,user,favourite,website'), 'set');
            $this->view()->setTemplate('favourite_list');
            $this->view()->assign('title', __('Favourite'));
            $this->view()->assign('favourites', $favourites);
            $this->view()->assign('uid', $uid);
        }
    }
}