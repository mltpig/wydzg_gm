<?php
namespace App\Api\Validate;
use EasySwoole\Component\CoroutineSingleTon;

class ClassPath
{
    use CoroutineSingleTon;

    private $classList = array(
        "getRewardGoods"   => "\\App\\Api\\Validate\\Gm\\RewardGoods",
        "email"            => "\\App\\Api\\Validate\\Gm\\Email",
        "gift"             => "\\App\\Api\\Validate\\Gm\\Gift",
        "giftCode"         => "\\App\\Api\\Validate\\Gm\\GiftCode",
        "notice"           => "\\App\\Api\\Validate\\Gm\\Notice",
        "recallNotice"     => "\\App\\Api\\Validate\\Gm\\RecallNotice",
    );

    public function getPath(string $event):string
    {
        return array_key_exists($event,$this->classList)? $this->classList[$event] :'';
    }
}
