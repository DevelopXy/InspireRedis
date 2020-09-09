<?php

namespace InspireRedis;

/**
 * redis字符串 哈希表
 * */
class InspireRedis
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
     * 返回redis原生操作
     * */
    public function redis()
    {
        return $this->redis;
    }

    /**
     * 判断是否连接
     * */
    public function  ping()
    {
        $ping = $this->redis->ping();
        return $ping;
    }

    /**
     * 字符串类型操作 start
     * */

    /**
     * 设置字符串
     * param: $key:key值 $value:value值
     * */
    public function setData($key,$value,$time='')
    {
        if(!empty($time)){
            $set = $this->redis->set($key,$value,$time);
        }else{
            $set = $this->redis->set($key,$value);
        }
        return $set;
    }

    /**
     * 获取字符串
     * param: $key:key值
     * */
    public function getData($key)
    {
        $res = $this->redis->get($key);
        return $res;
    }

    /**
     * 获取字符串是否存在
     * param: $key:key值
     * */
    public function isData($key)
    {
        $res = $this->redis->exists($key);
        return $res;
    }

    /**
     * 获取字符串是否存在
     * param: $key:key值
     * */
    public function delData($key)
    {
        $res = $this->redis->del($key);
        return $res;
    }

    /**
     * 字符串类型操作 end
     * */

    /**
     * 哈希类型操作 start
     * */

    /**
     * 设置哈希数据
     * param: $hash:哈希 $key:key值 $value:value值
     * */
    public function setHash($hash,$key,$value)
    {
       return $this->redis->hSet($hash,$key,$value);
    }

    /**
     * 哈希数据获取指定字段的值
     * */
    public function getHash($hash,$key)
    {
       return $this->redis->hGet($hash,$key);
    }

    /**
     * 哈希数据判断指定字段的值是否存在
     * */
    public function existHash($hash,$key)
    {
        return $this->redis->hExists($hash,$key);
    }

    /**
     * 哈希数据删除指定字段
     * */
    public function delHash($hash,$key)
    {
        return $this->redis->hDel($hash,$key);
    }

    /**
     * 哈希数据设置多个值
     * param: $hash:hash值  $data：array数组 ['name'=>'name','age' => '18']
     * */
    public function setsHash($hash,$data)
    {
        return $this->redis->hMSet($hash,$data);
    }

    /**
     * 哈希数据获取多个值
     * param: $hash:hash值  $data：array数组 ['name','age']
     * */
    public function getsHash($hash,$data)
    {
        return $this->redis->hMget($hash,$data);
    }

    /**
     * 哈希数据获取所有值
     * param: $hash:hash值
     * */
    public function allHash($hash)
    {
        return $this->redis->hGetAll($hash);
    }

    /**
     * 哈希数据获取所有key值
     * param: $hash:hash值
     * */
    public function getKey($hash)
    {
        return $this->redis->hKeys($hash);
    }

    /**
     * 哈希数据获取所有key值
     * param: $hash:hash值
     * */
    public function getVal($hash)
    {
        return $this->redis->hVals($hash);
    }

    /**
     * 哈希数据判断值存不存在,存在不操作。
     * param: $hash:hash值
     * */
    public function hasHash($hash,$key,$value)
    {
        return $this->redis->hSetNx($hash,$key,$value);
    }

    /**
     * 哈希数据获取key值的数量
     * param: $hash:hash值
     * */
    public function getLen($hash)
    {
        return $this->redis->hLen($hash);
    }

    /**
     * 哈希数据自增
     * param: $hash:hash值 $key:key值 $inc:自增数量(int,float)
     * */
    public function incData($hash,$key,$inc)
    {
        if(gettype($inc) == 'integer')
        {
            return $this->redis->hIncrBy($hash,$key,$inc);
        }else{
            return $this->redis->hIncrByFloat($hash,$key,$inc);
        }
    }

    /**
     * 哈希类型操作 end
     * */

    /**
     * 关闭redis连接
     * */
    public function __destruct()
    {
        $this->redis->close();
    }

}