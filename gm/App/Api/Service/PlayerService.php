<?php
namespace App\Api\Service;

use App\Api\Model\Player;
use App\Api\Utils\Keys;

use EasySwoole\ORM\DbManager;
use EasySwoole\Redis\Redis;
use EasySwoole\Pool\Manager as PoolManager;

class PlayerService
{
    protected $roleid       = null; //String   ID
    protected $openid       = null; //String   ID
    protected $site         = null; //String   ID
    protected $last_time    = null; //String   最后一次存档时间
    protected $playerKey    = null; //String   最后一次存档时间


    public function __construct(string $roleid,int $site)
    {
        $this->site   = $site;
        $this->roleid = $roleid;
        $this->getPlayerInfo();
    }

    //获取用户数据
    public function getPlayerInfo(): void
    {
        if ($userData = $this->findUserData()) $this->init($userData);
    }

    //查找用户
    public function findUserData(): array
    {

        $userObj = DbManager::getInstance()->invoke(function ($client) {
            return Player::invoke($client)->get(['roleid' => $this->roleid]);
        });

        if (is_null($userObj)) return array();

        return $this->mysql2Cache($userObj->toArray());
    }

    //用户数据初始化
    private function init(array $userData): void
    {
        
        foreach ($userData as $name => $val) 
        {
            if (!property_exists($this, $name) || in_array($name,['playerKey'])) continue;
            $data = $name != 'ext' ? json_decode($val,true) : $val;
            $this->{$name} = is_array($data) ? $data : $val;
        }

    }

    //mysql数据格式转化为缓存数据格式
    private function mysql2Cache(array $userInfo): array
    {
        $playerData = array();
        foreach ($userInfo as $name => $val) 
        {
            if (!property_exists($this, $name)) continue;
            $playerData[$name] = $val;
        }

        $this->playerKey = Keys::getInstance()->getPlayerKey($userInfo['roleid'],$this->site);

        return $playerData;
    }

    //获取用户字段数据入口
    public function getData(string $property,string $field = null )
    {
        if (!property_exists($this, $property)) throw new \Exception($property . " 属性不存在");

        if(is_null($field)) return $this->{$property};

        if(!array_key_exists($field,$this->{$property}) ) throw new \Exception($property . " 属性不存在 ".$field.' 键');
        
        return $this->{$property}[$field];
    }


    public static  function sendEmail(string $openid,int $site,int $type = 1,string $emailId,string $email ):void
    {
        $emailKey = Keys::getInstance()->getEmailKey($openid,$site,$type);
        PoolManager::getInstance()->get('redis')->invoke(function (Redis $redis) use($emailKey,$emailId,$email) {
            return $redis->hset($emailKey,$emailId,$email);
        });
    }


}

