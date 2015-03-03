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
    static function getFbLink($permissions = [])
    {
        $app = Dispatcher::getAppFile();
        FacebookSession::setDefaultApplication($app['fb_app_id'], $app['fb_app_secret']);
        $helper = new FacebookRedirectLoginHelper(self::link('users/register'));
        if (empty($permissions)) {
            $permissions = $app['fb_permissions'];
        }
        return $helper->getLoginUrl($permissions);
    }
}