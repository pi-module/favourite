<?php
/**
 * Favorite module Bar API
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

namespace Module\Favorite\Api;

use Pi;
use Pi\Application\AbstractApi;
use Pi\Db\RowGateway\RowGateway;

/*
 * Pi::service('api')->favorite(array('Favorite', 'loadFavorite'), $module, $item);
 * Pi::service('api')->favorite(array('Favorite', 'userFavorite'), $uid, $module);
 * Pi::service('api')->favorite(array('Favorite', 'doFavorite'), $params);
 */

class Favorite extends AbstractApi
{
    public function loadFavorite($module, $item)
    {
        $uid = Pi::registry('user')->id;
        $where = array('uid' => $uid, 'item' => $item, 'module' => $module);
        $select = Pi::model('list', $this->getModule())->select()->where($where);
        $count = Pi::model('list', $this->getModule())->selectWith($select)->count();
        if($count > 0) {
            return 1;
        }
        return 0;
    }
    
    public function userFavorite($uid, $module)
    {
        $item = array();
        $where = array('uid' => $uid, 'module' => $module);
        $select = Pi::model('list', $this->getModule())->select()->where($where);
        $rowset = Pi::model('list', $this->getModule())->selectWith($select);
        foreach ($rowset as $row) {
		        //$favorite[$row->id] = $row->toArray();	
		        $item[] = $row->item;
        }	
        return $item;
    }
    
    public function doFavorite($params)
    {
        if(!isset($params['item']) || !isset($params['to'])) {
	            //return false; 
        }
        // Get config
        $config = Pi::service('registry')->config->read('favorite', 'favorite');
        // Get user
        $uid = Pi::registry('user')->id;
        if ($uid == 0) {
            $return['message'] = __('Please login for make favorite');
            $return['status'] = 0;
        } else {
            // Check delay
            $delay = true;
            if($config['favorite_delay']) {
		             $delay = $this->checkDelay($uid, $config['favorite_delay']);	
            }
            if ($delay) {
                // user favorite to this item ?
                $where = array('uid' => $uid, 'item' => $params['item'], 'module' => $params['to']);
                $select = Pi::model('list', $this->getModule())->select()->where($where)->limit(1);
                $row_list = Pi::model('list', $this->getModule())->selectWith($select)->toArray();
                if(!empty($row_list)) {
                    // Remove 
                    $row = Pi::model('list', $this->getModule())->find($row_list[0]['id']);
                    $row->delete();
                    $return['is'] = 0;
                    $return['status'] = 1;
                    $return['img'] = Pi::service('asset')->getModuleAsset('image/staroff.png', $this->getModule(), false);
                } else {
                	    // Add
                	    $row = Pi::model('list', $this->getModule())->createRow();
                	    $row->uid = $uid;
                	    $row->item = $params['item'];
                	    $row->module = $params['to'];
                	    $row->hostname = getenv('REMOTE_ADDR');
                	    $row->create = time();
                	    $row->save();
                	    $return['is'] = 1;
                	    $return['status'] = 1;
                	    $return['img'] = Pi::service('asset')->getModuleAsset('image/staron.png', $this->getModule(), false);
                }
                // Update module item table
		             if (isset($params['table'])) {
					            $this->saveFavorite($params);
		             }
            } else {
                $return['message'] = sprintf(__('You can make favorite after %s second'), $config['favorite_delay']);
                $return['status'] = 0;	
            }	
        }
        return $return;	
    }
     
    /*
	  * For save favorite info in your module tables too,
	  * you must add favorite column in your module table
	  */
    protected function saveFavorite($params)
    {
        $where = array('item' => $params['item'], 'module' => $params['to']);
        $select = Pi::model('list', $this->getModule())->select()->where($where);
        $count = Pi::model('list', $this->getModule())->selectWith($select)->count();
        Pi::model($params['table'], $params['to'])->update(array('favorite' => $count), array('id' => $params['item']));
    }
    
    protected function checkDelay($uid, $time) 
    {
        // Set where
        $where = array('uid' => $uid);
        // Set order
        $order = array('create DESC', 'id DESC');
        $column = array('id', 'create');
        // Get info
        $select = Pi::model('list', $this->getModule())->select()->where($where)->columns($column)->order($order)->limit(1);
        $rowset = Pi::model('list', $this->getModule())->selectWith($select)->toArray();
        $time = $rowset[0]['create'] + $time;
        // check
        if(time() > $time) {
            return true;
        } else {
            return false;
        }		
    }
}	