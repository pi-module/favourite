<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 */

namespace Module\Favourite\Plugin;

use Pi;
use Module\User\Api\AbstractActivityCallback;

class Favourite extends AbstractActivityCallback
{
    public function __construct()
    {
        
    }   
    
    public function get($uid, $limit, $page = 1, $name = '') 
    {
        $favourites = Pi::api('favourite', 'favourite')->listFavourite($uid);
        $count = 0;
        foreach ($favourites as $favourite) {
            $count += $favourite['total_item'];
        }
        
        return array('favourites' => $favourites, 'count' => $count);
    }
    
    public function getCount($uid)
    {
        return Pi::api('favourite', 'favourite')->getCount($uid ? $uid : Pi::user()->getId());        
    }
    
}
