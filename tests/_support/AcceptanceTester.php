<?php

use Page\Main;
use Page\Members;
use Page\Login;
use Helper\Config;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/

class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

    /**
     * @var Main
     */
    public $main_page;
    /**
     * @var Members
     */
    public $members_page;
    /**
     * @var Login
     */
    public $login_page;
    /**
     * @var Config $config
     */
    public $config;

    public function _inject(Main $main_page, Members $members_page, Login $login_page, Config $config)
    {
        $this->main_page = $main_page;
        $this->members_page = $members_page;
        $this->login_page = $login_page;
        $this->config = $config;
    }
}
