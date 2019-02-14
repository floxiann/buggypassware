<?php

use Page\Main;
use Step\User;

class CheckCest
{
    public function _before(User $user)
    {
        $login = $user->config->getDataAccess('login');
        $password = $user->config->getDataAccess('password');
        $user->amOnPage(Main::URL);
        $user->main_page->clickLogin();
        $user->login_page->auth($login, $password);
    }

    /**
     * Генерируем название элемента
     *
     * @return string
     */
    private function generateTitleItem()
    {
        return 'Item' . rand(1, 200);
    }

    /**
     * Проверка счетчика
     *
     * @param User $user
     */
    public function checkCounter(User $user)
    {
        $user->members_page->checkUrlMembers();
        $value = $user->members_page->getValueCounter();
        $user->members_page->increment();
        $new_value = $user->members_page->getValueCounter();
        $user->assertEquals($value + 1, $new_value);
        $user->reloadPage();
        $current_value = $user->members_page->getValueCounter();
        $user->assertEquals($current_value, $new_value);
    }

    /**
     * Предусловия для добавления
     *
     * @param User $user
     */
    private function preconditionForAdd(User $user)
    {
        $user->members_page->checkUrlMembers();

        $count = $user->members_page->getCountItems();
        if ($count == 10) {
            $user->members_page->removeItem();
        }
    }

    /**
     * Предусловия для удаление
     *
     * @param User $user
     */
    private function preconditionForRemove(User $user)
    {
        $user->members_page->checkUrlMembers();

        $count = $user->members_page->getCountItems();
        if ($count == 0) {
            $rand_item_title = $this->generateTitleItem();
            $user->members_page->addItem($rand_item_title);
        }
    }

    /**
     * Проверка добавления элемента в список
     *
     * @param User $user
     *
     * @before preconditionForAdd
     */
    public function checkAddItemSuccess(User $user)
    {
        $rand_item_title = $this->generateTitleItem();

        $count = $user->members_page->getCountItems();

        $user->members_page->addItem($rand_item_title);
        $count_after_added = $user->members_page->getCountItems();
        $user->assertEquals($count + 1, $count_after_added);

        $title_last_item = $user->members_page->getTitleLastItem();
        $user->assertContains($rand_item_title, $title_last_item);
    }

    /**
     * Проверка добавления элемента, содержащего html код
     *
     * @param User $user
     *
     * @before preconditionForAdd
     */
    public function checkAddHtmlItem(User $user)
    {
        $count = $user->members_page->getCountItems();

        $html_text = '</body>';
        $user->members_page->addItem($html_text); // много разного
        $count_after_added = $user->members_page->getCountItems();
        $user->assertEquals($count + 1, $count_after_added);

        $title_last_item = $user->members_page->getTitleLastItem();
        $user->assertContains($html_text, $title_last_item);
    }

    /**
     * Проверка удаления элемента
     *
     * @param User $user
     *
     * @before preconditionForRemove
     */
    public function checkRemoveItem(User $user)
    {
        $count = $user->members_page->getCountItems();

        $user->members_page->removeItem();
        $count_after_removed = $user->members_page->getCountItems();
        $user->assertEquals($count - 1, $count_after_removed);
    }

    /**
     * Проверка некорректности длины вводимого текста
     *
     * @param User $user
     *
     * @before preconditionForAdd
     */
    public function checkLengthItem(User $user)
    {
        $user->members_page->addItem('');
        $user->members_page->seeErrorLength();
        $user->members_page->addItem('2');
        $user->members_page->seeErrorLength();
        $user->members_page->addItem(str_pad('', 41, '8'));
        $user->members_page->seeErrorLength();
        $user->members_page->addItem('  ');
        $user->members_page->seeErrorLength();
    }

    /**
     * Проверка невозможности добавления > 10 элементов в список
     *
     * @param User $user
     */
    public function checkMaxCountItem(User $user)
    {
        $count = $user->members_page->getCountItems();

        if ($count < 10) {
            $col = 10 - $count;
            for ($i = 0; $i < $col; $i++) {
                $rand_item_title = $this->generateTitleItem();
                $user->members_page->addItem($rand_item_title);
            }
        }

        $rand_item_title = $this->generateTitleItem();
        $user->members_page->addItem($rand_item_title);

        $user->members_page->seeAlertMaxCount();
    }
}
