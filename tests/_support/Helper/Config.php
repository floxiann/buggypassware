<?php

namespace Helper;

use Codeception\Configuration;

class Config
{
    private static $accept = [];

    /**
     * Получение конфигурации
     *
     * @throws \Codeception\Exception\ConfigurationException
     *
     * @return array
     */
    public static function getConfig()
    {
        return Configuration::config();
    }

    /**
     * Получение данных для доступа
     *
     * @param $data
     *
     * @throws \Codeception\Exception\ConfigurationException
     *
     * @return mixed
     */
    public function getDataAccess($data)
    {
        if (empty(self::$accept)) {
            $conf = static::getConfig();
            self::$accept = $conf['access'];
        }
        $array_access = self::$accept;
        $result = (array_key_exists($data, $array_access)) ? $array_access[$data] : null;

        return $result;
    }
}
