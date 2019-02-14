<?php

namespace Page;

class Main extends BasePage
{
    const URL = '/';

    public static $login_link = 'a[href="/login"]';

    /**
     * Нажатие на кнопку 'Login'
     */
    public function clickLogin()
    {
        $this->helper->waitAndClick(self::$login_link);
    }
} 