<?php
class Cloud
{
    public static $host;

    public function __construct()
    {
        self::$host = self::$_App['api']['Host'];
    }

    public static function getNews()
    {
        return json_decode(self::$_http->get(self::$host . 'getNews'), true);
    }

}
