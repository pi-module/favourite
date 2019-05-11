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

namespace Module\Favourite\Controller\Admin;

use Pi;
use Pi\Mvc\Controller\ActionController;
use Pi\Paginator\Paginator;

class IndexController extends ActionController
{
    public function indexAction()
    {
        // Get page
        $page   = $this->params('page', 1);
        $module = $this->params('module');
        // Set info
        $offset = (int)($page - 1) * $this->config('admin_perpage');
        $order  = ['time_create DESC', 'id DESC'];
        $limit  = intval($this->config('admin_perpage'));
        $where  = [];
        $list   = [];
        // Get list of list
        $select = $this->getModel('list')->select()->where($where)->order($order)->offset($offset)->limit($limit);
        $rowset = $this->getModel('list')->selectWith($select);
        // Make list
        foreach ($rowset as $row) {
            $list[$row->id]                = $row->toArray();
            $list[$row->id]['time_create'] = _date($list[$row->id]['time_create']);
            $list[$row->id]['user']        = Pi::user()->get($list[$row->id]['uid'], ['id', 'identity', 'name', 'email']);
        }
        // Set paginator
        $count     = ['count' => new \Zend\Db\Sql\Predicate\Expression('count(*)')];
        $select    = $this->getModel('list')->select()->where($where)->columns($count);
        $count     = $this->getModel('list')->selectWith($select)->current()->count;
        $paginator = Paginator::factory(intval($count));
        $paginator->setItemCountPerPage($this->config('admin_perpage'));
        $paginator->setCurrentPageNumber($page);
        $paginator->setUrlOptions([
            'router' => $this->getEvent()->getRouter(),
            'route'  => $this->getEvent()->getRouteMatch()->getMatchedRouteName(),
            'params' => array_filter([
                'module'     => $this->getModule(),
                'controller' => 'index',
                'action'     => 'index',
            ]),
        ]);
        // Set view
        $this->view()->setTemplate('index-index');
        $this->view()->assign('list', $list);
        $this->view()->assign('paginator', $paginator);
    }
}
