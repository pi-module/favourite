<?php
/**
 * Pi Engine (http://piengine.org)
 *
 * @link            http://code.piengine.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://piengine.org
 * @license         http://piengine.org/license.txt BSD 3-Clause License
 */

namespace Module\Favourite\Plugin;

use Module\User\Api\AbstractActivityCallback;
use Pi;

class Favourite extends AbstractActivityCallback
{
    public function __construct()
    {

    }

    public function get($uid, $limit, $page = 1, $name = '')
    {
        $favourites = Pi::api('favourite', 'favourite')->listFavourite($uid);
        $count      = 0;
        foreach ($favourites as $favourite) {
            $count += $favourite['total_item'];
        }

        return ['favourites' => $favourites, 'count' => $count];
    }

    public function getCount($uid)
    {
        return Pi::api('favourite', 'favourite')->getCount($uid ? $uid : Pi::user()->getId());
    }

}
