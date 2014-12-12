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

namespace Module\Favourite\Api;

use Pi;
use Pi\Application\Api\AbstractApi;

/*
 * Pi::api('favourite', 'favourite')->listFavourite();
 * Pi::api('favourite', 'favourite')->doFavourite($params);
 * Pi::api('favourite', 'favourite')->loadFavourite($module, $table, $item);
 * Pi::api('favourite', 'favourite')->userFavourite($uid, $module);
 */

class Favourite extends AbstractApi
{
    public function listFavourite()
    {
        $list = array();

        // Set news favourite
        if (Pi::service('module')->isActive('news')) {
            $item = array(
                'name'     => 'news',
                'title'    => 'News',
                'info'     => array(),
                'message'  => __('List is empty on news module'),
            );
            $list[''] = $item;
        }

        // Set shop favourite
        if (!Pi::service('module')->isActive('shop')) {
            $item = array(
                'name'     => 'shop',
                'title'    => 'Shop',
                'info'     => array(),
                'message'  => __('List is empty on shop module'),
            );
            $list[] = $item;
        }

        // Set guide favourite
        if (!Pi::service('module')->isActive('guide')) {
            $item = array(
                'name'     => 'guide',
                'title'    => 'Guide',
                'info'     => array(),
                'message'  => __('List is empty on guide module'),
            );
            $list[] = $item;
        }

        return $list;
    }

    public function loadFavourite($module, $table, $item)
    {
        $uid = Pi::user()->getId();
        $where = array('uid' => $uid, 'item' => $item, 'table' => $table, 'module' => $module);
        $select = Pi::model('list', $this->getModule())->select()->where($where);
        $count = Pi::model('list', $this->getModule())->selectWith($select)->count();
        if($count > 0) {
            return 1;
        }
        return 0;
    }
    
    public function userFavourite($uid, $module)
    {
        $item = array();
        $where = array('uid' => $uid, 'module' => $module);
        $select = Pi::model('list', $this->getModule())->select()->where($where);
        $rowset = Pi::model('list', $this->getModule())->selectWith($select);
        foreach ($rowset as $row) {
		        $item[] = $row->item;
        }	
        return $item;
    }

    public function doFavourite($params)
    {
        // Get config
        $config = Pi::service('registry')->config->read('favourite', 'favourite');
        // Get user
        $uid = Pi::user()->getId();
        if ($uid == 0) {
            $return['title'] = __('Error to make favourite');
            $return['message'] = __('Please login for make favourite');
            $return['status'] = 0;
        } else {
            // Check delay
            $delay = true;
            if($config['favourite_delay']) {
                $delay = $this->checkDelay($uid, $config['favourite_delay']);    
            }
            if ($delay) {
                // user favourite to this item ?
                $where = array('uid' => $uid, 'item' => $params['item'], 'table' => $params['table'], 'module' => $params['to']);
                $select = Pi::model('list', $this->getModule())->select()->where($where)->limit(1);
                $row_list = Pi::model('list', $this->getModule())->selectWith($select)->toArray();
                if(!empty($row_list)) {
                    // Remove 
                    $row = Pi::model('list', $this->getModule())->find($row_list[0]['id']);
                    $row->delete();
                    $return['is'] = 0;
                    $return['status'] = 1;
                } else {
                    // Add
                    $row = Pi::model('list', $this->getModule())->createRow();
                    $row->uid = $uid;
                    $row->item = $params['item'];
                    $row->table = $params['table'];
                    $row->module = $params['to'];
                    $row->ip = Pi::user()->getIp();
                    $row->time_create = time();
                    $row->save();
                    $return['is'] = 1;
                    $return['status'] = 1;
                }
                // Update module item table
				$this->saveFavourite($params);
            } else {
                $return['title'] = __('Error to make favourite');
                $return['message'] = sprintf(__('You can make favourite after %s second'), $config['favourite_delay']);
                $return['status'] = 0;	
            }	
        }
        return $return;	
    }

    protected function saveFavourite($params)
    {
        $where = array('item' => $params['item'], 'table' => $params['table'], 'module' => $params['to']);
        $select = Pi::model('list', $this->getModule())->select()->where($where);
        $count = Pi::model('list', $this->getModule())->selectWith($select)->count();
        Pi::model($params['table'], $params['to'])->update(array('favourite' => $count), array('id' => $params['item']));
    }
    
    protected function checkDelay($uid, $time) 
    {
        // Set where
        $where = array('uid' => $uid);
        // Set order
        $order = array('time_create DESC', 'id DESC');
        $column = array('id', 'time_create');
        // Get info
        $select = Pi::model('list', $this->getModule())->select()->where($where)->columns($column)->order($order)->limit(1);
        $rowset = Pi::model('list', $this->getModule())->selectWith($select)->toArray();
        $time = $rowset[0]['time_create'] + $time;
        // check
        if(time() > $time) {
            return true;
        } else {
            return false;
        }		
    }
}	