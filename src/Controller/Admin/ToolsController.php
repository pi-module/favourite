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

namespace Module\Favourite\Controller\Admin;

use Pi;
use Pi\Mvc\Controller\ActionController;

class ToolsController extends ActionController
{
    public function indexAction()
    {
        $this->view()->setTemplate('tools_index');
    }
}