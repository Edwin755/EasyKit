<?php
/**
 * FB Helper
 */
use Core\Dispatcher;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookSession;

/**
 * Class FbHelper
 */
class FbHelper extends HTML
{

    /**
     * @param array $permissions
     * @return mixed
     */
    static function getFbLink($permissions = array())
    {
        $app = Dispatcher::getAppFile();
        FacebookSession::setDefaultApplication($app['app_id'], $app['app_secret']);
        $helper = new FacebookRedirectLoginHelper(self::link('users/register'));
        return $helper->getLoginUrl($permissions);
    }
}