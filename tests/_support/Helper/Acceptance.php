<?php
namespace Helper;

use Codeception\Lib\ModuleContainer;
use Codeception\Module\WebDriver;
use Codeception\Module;
use Facebook\WebDriver\WebDriverBy;
use Codeception\Util\Locator;
use Symfony\Component\CssSelector\CssSelectorConverter;

class Acceptance extends Module
{
    const TIMEOUT = 20;
    /**
     * @var WebDriver $web_driver
     */
    public $web_driver;

    public function __construct(ModuleContainer $moduleContainer, $config = null)
    {
        parent::__construct($moduleContainer, $config);
        $this->web_driver = $this->getModule('WebDriver');
    }

    /**
     * @param $selector
     */
    public function waitAndClick($selector)
    {
        $this->web_driver->waitForElementVisible($selector, self::TIMEOUT);
        $this->web_driver->click($selector);
    }

    /**
     * Получение количества элементов
     *
     * @param $selector - css или xpath селектор
     *
     * @return int - количество найденных элементов
     */
    public function countElements($selector)
    {
        return count($this->web_driver->_findElements($selector));
    }

    /**
     * Переводит CSS селектор в Xpath
     *
     * @param $selector
     *
     * @return string
     */
    public function cssToXpath($selector)
    {
        $css = new CssSelectorConverter();
        return $css->toXPath($selector);
    }

    /**
     * Выбор рандомного элемента
     *
     * @param $selector
     *
     * @return null|string
     */
    public function selectElement($selector)
    {
        $element = null;
        if (Locator::isCSS($selector) || Locator::isID($selector)) {
            $selector = $this->cssToXpath($selector);
        }
        if (Locator::isXPath($selector)) {
            $links = $this->web_driver->_findElements($selector);
            $element = '(' . $selector . ')' . '[' . rand(1, count($links)) . ']';
        }

        return $element;
    }
}
