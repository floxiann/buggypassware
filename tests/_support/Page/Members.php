<?php

namespace Page;

/**
 * Class Members
 * @package Page
 *
 * Страница /members
 */
class Members extends BasePage
{
    const URL = '/members';

    public static $counter_value = 'span#counter_value';
    public static $button_increment = '//button[text()="Increment"]';

    public static $input_title = 'input#title';
    public static $button_add = '//button[text()="Add"]';
    public static $link_remove_item = 'a[href^="/remove"]';

    public static $last_item = 'ol li:last-of-type';

    public static $block_error = 'div.has-error';
    public static $text_error_length = 'Field must be between 3 and 40 characters long.';

    public static $block_alert = 'div.alert';
    public static $text_alert_max_count = 'Cannot add more than 10 items';

    /**
     * Получение текущего значения счетчика
     *
     * @return mixed
     */
    public function getValueCounter()
    {
        return $this->tester->grabTextFrom(self::$counter_value);
    }

    /**
     * Проверяем, что мы на странице Members
     */
    public function checkUrlMembers()
    {
        $this->tester->seeInCurrentUrl(self::URL);
    }

    /**
     * Увеличение счетчика
     */
    public function increment()
    {
        $this->tester->waitAndClick(self::$button_increment);
    }

    /**
     * Добавление элемента
     *
     * @param $title
     */
    public function addItem($title)
    {
        $this->tester->fillField(self::$input_title, $title);
        $this->tester->waitAndClick(self::$button_add);
    }

    /**
     * Получение количества элементов в списке
     *
     * @return int
     */
    public function getCountItems()
    {
        return $this->tester->countElements(self::$link_remove_item);
    }

    /**
     * Получение title последнего пункта в списке
     *
     * @return mixed
     */
    public function getTitleLastItem()
    {
        return $this->tester->grabTextFrom(self::$last_item);
    }

    /**
     * Удаление рандомного элемента
     */
    public function removeItem()
    {
        $rand_element = $this->tester->selectElement(self::$link_remove_item);
        preg_match('/\d+/', $this->tester->grabAttributeFrom($rand_element, 'href'), $match);
        $id_item = $match[0] ?? null;
        $this->tester->click($rand_element);
        $this->tester->waitForElementNotVisible('a[href*="/remove/' . $id_item . '"]');
    }

    /**
     * Проверка появления ошибки Field must be between 3 and 40 characters long.
     */
    public function seeErrorLength()
    {
        $this->tester->waitForElementVisible(self::$block_error);
        $this->tester->see(self::$text_error_length);
    }

    /**
     * Проверка появления алерта Cannot add more than 10 items
     */
    public function seeAlertMaxCount()
    {
        $this->tester->waitForElementVisible(self::$block_alert);
        $this->tester->see(self::$text_alert_max_count);
    }
}
