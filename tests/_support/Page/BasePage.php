<?php

namespace Page;

use Helper\Config;
use Helper\Acceptance;

abstract class BasePage {
    /**
     * @var \AcceptanceTester $tester
     */
    protected $tester;

    /**
     * @var Config $config
     */
    protected $config;

    /**
     * @var Acceptance $helper
     */
    protected $helper;

    public static $data_cache = null;

    protected function _inject(\AcceptanceTester $tester,
                               Acceptance $helper,
                               Config $config)
    {
        $this->tester = $tester;
        $this->helper = $helper;
        $this->config = $config;
    }
}
