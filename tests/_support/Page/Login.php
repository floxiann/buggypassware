<?php

namespace Page;

/**
 * Class Login
 * @package Page
 *
 * Страница /login
 */
class Login extends BasePage
{
    const URL = '/login';

    public static $input_email = 'input#email';
    public static $input_password = 'input#password';
    public static $button_submit = 'button[type="submit"]';

    /**
     * Авторизация
     *
     * @param $login
     * @param $password
     */
    public function auth($login, $password)
    {
        $this->tester->seeInCurrentUrl(self::URL);
        $this->tester->waitForElementVisible(self::$input_email);
        $this->tester->fillField(self::$input_email, $login);
        $this->tester->fillField(self::$input_password, $password);
        $this->tester->waitAndClick(self::$button_submit);
    }
}
