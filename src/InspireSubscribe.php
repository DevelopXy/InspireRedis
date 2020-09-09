<?php


namespace InspireRedis;

/**
 * redis消息订阅
 * */

class InspireSubscribe
{
    const HOST = '127.0.0.1';
    const PORT = 6379;
    const AUTH = '';
    const DB   = '0';
    const TIMEOUT = 5;

    protected $redis = null;
    protected $host;
    protected $auth;
    protected $db;
    protected $timeout;

    /**
     * 连接redis
     * param: $db:选择redis库
     * */
    public function __construct($db ='')
    {
        $this->redis = new \Redis();
        $this->redis->connect(self::HOST,self::PORT,self::TIMEOUT);
        $this->redis->auth(self::AUTH);
        if(!empty($db))
        {
            $this->redis->select($db);
        }else{
            $this->redis->select(self::DB);
        }
    }

    /**
     * 发布订阅
     * param: $channel:发布通道, $content:发布内容
     * */
    public function Pub($channel,$content)
    {
       return $this->redis->publish($channel, $content);
    }


    /**
     * 接受订阅
     * param: $channel:接受通道, $func:回调方法（callback）
     * */
    public function Sub($channel,$func)
    {
        return $this->redis->subscribe([$channel], $func);
    }

//   回调方法示例
//    function callBackFun($redis, $channel, $msg)
//    {
//        print_r([
//            'redis'   => $redis,
//            'channel' => $channel,
//            'msg'     => $msg
//        ]);
//    }


    /**
     * 关闭redis连接
     * */
    public function __destruct()
    {
        $this->redis->close();
    }
}