<?php

namespace FrameWork\Http;

use FrameWork\Main as FrameWork;

class Http
{
    public static $ch = null; // curl handle
    public static $url;
    private $headers = array(); // request header
    private $proxy = null; // http proxy
    private $timeout = null;    // connnect timeout
    private $httpParams = null;




    public static function url($url)
    {
        self::$ch = curl_init();
        return self::$url = FrameWork::$_App['api']['Host'] . $url;
    }

    /**
     * 设置http header
     * @param $header
     * @return $this
     */
    public function setHeader($header)
    {
        if (is_array($header)) {
            curl_setopt(self::$ch, CURLOPT_HTTPHEADER, $header);
        }
        return self;
    }

    /**
     * 设置http 超时
     * @param int $time
     * @return $this
     */
    public function setTimeout($time)
    {
        // 不能小于等于0
        if ($time <= 0) {
            $time = 5;
        }
        //只需要设置一个秒的数量就可以
        curl_setopt(curl_init(), CURLOPT_TIMEOUT, $time);
        return $this;
    }


    /**
     * 设置http 代理
     * @param string $proxy
     * @return $this
     */
    public function setProxy($proxy)
    {
        if ($proxy) {
            curl_setopt(self::$ch, CURLOPT_PROXY, $proxy);
        }
        return $this;
    }

    /**
     * 设置http 代理端口
     * @param int $port
     * @return $this
     */
    public function setProxyPort($port)
    {
        if (is_int($port)) {
            curl_setopt(self::$ch, CURLOPT_PROXYPORT, $port);
        }
        return $this;
    }

    /**
     * 设置来源页面
     * @param string $referer
     * @return $this
     */
    public function setReferer($referer = "")
    {
        if (!empty($referer))
            curl_setopt(self::$ch, CURLOPT_REFERER, $referer);
        return $this;
    }

    /**
     * 设置用户代理
     * @param string $agent
     * @return $this
     */
    public function setUserAgent($agent = "")
    {
        if ($agent) {
            // 模拟用户使用的浏览器
            curl_setopt(self::$ch, CURLOPT_USERAGENT, $agent);
        }
        return $this;
    }

    /**
     * http响应中是否显示header，1表示显示
     * @param $show
     * @return $this
     */
    public function showResponseHeader($show)
    {
        curl_setopt(self::$ch, CURLOPT_HEADER, $show);
        return $this;
    }


    /**
     * 设置http请求的参数,get或post
     * @param array $params
     * @return $this
     */
    public function setParams($params)
    {
        $this->httpParams = $params;
        return $this;
    }

    /**
     * 设置证书路径
     * @param $file
     */
    public function setCainfo($file)
    {
        curl_setopt(self::$ch, CURLOPT_CAINFO, $file);
    }


    /**
     * 模拟GET请求
     * @param string $url
     * @param string $dataType
     * @return bool|mixed
     */
    public function get($dataType = 'text')
    {
        if (stripos(self::$url, 'https://') !== FALSE) {
            curl_setopt(self::$ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt(self::$ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt(self::$ch, CURLOPT_SSLVERSION, 1);
        }
        // 设置get参数
        if (!empty($this->httpParams) && is_array($this->httpParams)) {
            if (strpos(self::$url, '?') !== false) {
                self::$url .= http_build_query($this->httpParams);
            } else {
                self::$url .= '?' . http_build_query($this->httpParams);
            }
        }
        // end 设置get参数
        curl_setopt(self::$ch, CURLOPT_URL, self::$url);
        curl_setopt(self::$ch, CURLOPT_RETURNTRANSFER, 1);
        $content = curl_exec(self::$ch);
        $status = curl_getinfo(self::$ch);
        curl_close(self::$ch);


        if (isset($status['http_code'])) {
            if ($dataType == 'json') {
                $content = json_decode($content, true);
            }
            return $content;
        }
    }


    /**
     * 模拟POST请求
     *
     * @param string $url
     * @param array $fields
     * @param string $dataType
     * @return mixed
     *
     * HttpCurl::post('http://api.example.com/?a=123', array('abc'=>'123', 'efg'=>'567'), 'json');
     * HttpCurl::post('http://api.example.com/', '这是post原始内容', 'json');
     * 文件post上传
     * HttpCurl::post('http://api.example.com/', array('abc'=>'123', 'file1'=>'@/data/1.jpg'), 'json');
     */
    public function post($data = null, $dataType = 'text')
    {
        if (stripos(self::$url, 'https://') !== FALSE) {
            curl_setopt(self::$ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt(self::$ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt(self::$ch, CURLOPT_SSLVERSION, 1);
        }
        curl_setopt(self::$ch, CURLOPT_URL, self::$url);
        // 设置post body
        if (!empty($this->httpParams)) {
            if (is_array($this->httpParams)) {
                curl_setopt(self::$ch, CURLOPT_POSTFIELDS, http_build_query($this->httpParams));
            } else if (is_string($this->httpParams)) {
                curl_setopt(self::$ch, CURLOPT_POSTFIELDS, $this->httpParams);
            }
        }
        // end 设置post body
        curl_setopt(self::$ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt(self::$ch, CURLOPT_POST, 1);
        curl_setopt(self::$ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $content = curl_exec(self::$ch);
        $status = curl_getinfo(self::$ch);
        curl_close(self::$ch);

        if (isset($status['http_code']) && @$status['http_code'] != 0) {
            if ($dataType == 'json') {
                $content = json_decode($content, true);
            }
            return $content;
        } else {
            return ['code' => 500, 'msg' => '连接出错，无法连接', 'data' => []];
        }
    }
}
