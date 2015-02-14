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
     * Permissions for Facebook API
     *
     * @var array $permissions
     */
    private $permissions = [
        'email'
    ];

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
        FacebookSession::setDefaultApplication($app['app_id'], $app['app_secret']);
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
        return $reRequest ? $this->helper->getReRequestUrl($this->permissions) : $this->helper->getLoginUrl($this->permissions);
    }
}








