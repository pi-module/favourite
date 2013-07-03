<?php
/**
 * Favorite admin Index controller
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

namespace Module\Favorite\Controller\Admin;

use Pi;
use Pi\Mvc\Controller\ActionController;

class IndexController extends ActionController
{
    public function indexAction()
    {
        // Get page
        $page = $this->params('p', 1);
        // Get info
        $offset = (int)($page - 1) * $this->config('admin_perpage');
        $select = $this->getModel('list')->select()->order(array('create DESC', 'id DESC'))->offset($offset)->limit(intval($this->config('admin_perpage')));
        $rowset = $this->getModel('list')->selectWith($select);
        // Make list
        foreach ($rowset as $row) {
            $favorite[$row->id] = $row->toArray();
            $user = Pi::model('user_account')->find($favorite[$row->id]['uid'])->toArray();
            $favorite[$row->id]['identity'] = $user['identity'];
            $favorite[$row->id]['create'] = _date($favorite[$row->id]['create']);
        }
        // check
        if (empty($favorite)) {
            return $this->redirect()->toRoute('', array('action' => 'index'));
        }
        // Set paginator
        $paginator = \Pi\Paginator\Paginator::factory(intval($this->config('admin_count')));
        $paginator->setItemCountPerPage($this->config('admin_perpage'));
        $paginator->setCurrentPageNumber($page);
        $paginator->setUrlOptions(array(
            // Use router to build URL for each page
            'pageParam' => 'p',
            'totalParam' => 't',
            'router' => $this->getEvent()->getRouter(),
            'route' => $this->getEvent()->getRouteMatch()->getMatchedRouteName(),
            'params' => array(
                'module' => $this->getModule(),
                'controller' => 'index',
                'action' => 'index',
            ),
        ));
        // Set view
        $this->view()->setTemplate('index_index');
        $this->view()->assign('favorites', $favorite);
        $this->view()->assign('paginator', $paginator);
        $this->view()->assign('module', $this->getModule());
    }
}
