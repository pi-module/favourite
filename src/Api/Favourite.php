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
 * Pi::api('favourite', 'favourite')->listItemFavourite($module, $table, $item);
 * Pi::api('favourite', 'favourite')->doFavourite($params);
 * Pi::api('favourite', 'favourite')->loadFavourite($module, $table, $item);
 * Pi::api('favourite', 'favourite')->userFavourite($uid, $module, $limit);
 */

class Favourite extends AbstractApi
{
    public function listFavourite()
    {
        $list = array();

        // Set news favourite
        if (Pi::service('module')->isActive('news')) {
            $item = array(
                'name' => 'news',
                'title' => 'News',
                'list' => Pi::api('story', 'news')->FavoriteList(),
                'message' => sprintf(__('You have not yet picked up items in %s module'), 'News'),
                'moreUrl' => '#',
                'printUrl' => '#',
            );
            $list[] = $item;
        }

        // Set shop favourite
        if (Pi::service('module')->isActive('shop')) {
            $item = array(
                'name' => 'shop',
                'title' => 'Shop',
                'list' => Pi::api('product', 'shop')->FavoriteList(),
                'message' => sprintf(__('You have not yet picked up items in %s module'), 'Shop'),
                'moreUrl' => '#',
                'printUrl' => '#',
            );
            $list[] = $item;
        }

        // Set guide favourite
        if (Pi::service('module')->isActive('guide')) {
            $item = array(
                'name' => 'guide',
                'title' => 'Guide',
                'list' => Pi::api('item', 'guide')->FavoriteList(),
                'message' => sprintf(__('You have not yet picked up items in %s module'), 'Guide'),
                'moreUrl' => '#',
                'printUrl' => '#',
            );
            $list[] = $item;
        }

        return $list;
    }

    public function listItemFavourite($module, $table, $item)
    {
        // Check user checkin or not
        $list = array();
        $where = array('item' => $item, 'table' => $table, 'module' => $module);
        $order = array('id DESC', 'time_create DESC');
        $select = Pi::model('list', $this->getModule())->select()->where($where)->order($order);
        $rowset = Pi::model('list', $this->getModule())->selectWith($select);
        foreach ($rowset as $row) {
            // Get user info
            $user = Pi::user()->get($row->uid, array('id', 'identity', 'name', 'email'));
            $user['avatar'] = Pi::service('user')->avatar($row->uid, 'small', array(
                'alt' => $user['name'],
                'class' => 'img-circle',
            ));
            $user['profileUrl'] = Pi::url(Pi::service('user')->getUrl('profile', array(
                'id' => $user['id'],
            )));
            $list[$row->id] = $user;
        }
        return $list;
    }

    public function loadFavourite($module, $table, $item)
    {
        $uid = Pi::user()->getId();
        $where = array('uid' => $uid, 'item' => $item, 'table' => $table, 'module' => $module);
        $select = Pi::model('list', $this->getModule())->select()->where($where);
        $count = Pi::model('list', $this->getModule())->selectWith($select)->count();
        if ($count > 0) {
            return 1;
        }
        return 0;
    }

    public function userFavourite($uid, $module, $limit = 0)
    {
        $list = array();
        $where = array('uid' => $uid, 'module' => $module);
        $select = Pi::model('list', $this->getModule())->select()->where($where);
        if ($limit > 0) {
            $select->limit($limit);
            $select->order(array('time_create ASC', 'id ASC'));
        }
        $rowset = Pi::model('list', $this->getModule())->selectWith($select);
        foreach ($rowset as $row) {
            $list[] = $row->item;
        }
        return $list;
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
            if ($config['favourite_delay']) {
                $delay = $this->checkDelay($uid, $config['favourite_delay']);
            }
            if ($delay) {
                // user favourite to this item ?
                $where = array('uid' => $uid, 'item' => $params['item'], 'table' => $params['table'], 'module' => $params['to']);
                $select = Pi::model('list', $this->getModule())->select()->where($where)->limit(1);
                $row_list = Pi::model('list', $this->getModule())->selectWith($select)->toArray();
                if (!empty($row_list)) {
                    // Remove 
                    $row = Pi::model('list', $this->getModule())->find($row_list[0]['id']);
                    $row->delete();
                    // flush cache
                    Pi::service('cache')->flush('module', $params['to']);
                    // Set return
                    $return['is'] = 0;
                    $return['status'] = 1;
                } else {
                    if ($params['table'] == 'item' && $params['to'] == 'guide') {
                        $item = Pi::model('item', 'guide')->find($params['item']);
                        if (!$item || $item->status != 1) {
                            $return['title'] = __('Error to set your favorite');
                            $return['message'] = __('Item not active');
                            $return['status'] = 0;
                            return $return;
                        }
                    }
                    // Add
                    $row = Pi::model('list', $this->getModule())->createRow();
                    $row->uid = $uid;
                    $row->item = $params['item'];
                    $row->table = $params['table'];
                    $row->module = $params['to'];
                    $row->ip = Pi::user()->getIp();
                    $row->time_create = time();
                    $row->save();
                    // flush cache
                    Pi::service('cache')->flush('module', $params['to']);
                    // Set return
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
        if (time() > $time) {
            return true;
        } else {
            return false;
        }
    }
}	