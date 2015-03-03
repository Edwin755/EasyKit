<?php
/**
 * Created by PhpStorm.
 * User: Heyden
 * Date: 14/02/2015
 * Time: 13:51
 */

namespace App\Controllers;

use Core\Controller;
use Core\Dispatcher;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookSession;

/**
 * Class AppController
 *
 * @package App\Controllers
 */
class AppController extends Controller {

    /**
     * Helper for Facebook API
     *
     * @var FacebookRedirectLoginHelper
     */
    private $helper;

    /**
     * Init Facebook API
     *
     * @return FacebookRedirectLoginHelper
     */
    protected function initFb()
    {
        $app = Dispatcher::getAppFile();
        FacebookSession::setDefaultApplication($app['fb_app_id'], $app['fb_app_secret']);
        $this->helper = new FacebookRedirectLoginHelper($this->link('users/register'));

        return $this->helper;
    }

    /**
     * Generate a FB link
     *
     * @param bool $reRequest
     * @return mixed
     */
    protected function generateFbLink($reRequest = false)
    {
        $app = Dispatcher::getAppFile();
        $permissions = $app['fb_permissions'];
        return $reRequest ? $this->helper->getReRequestUrl($permissions) : $this->helper->getLoginUrl($permissions);
    }
}









