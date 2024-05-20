<?php
namespace App\Api\Controller;
use FastRoute\RouteCollector;
use EasySwoole\Http\Request;
use EasySwoole\Http\Response;
use EasySwoole\Http\AbstractInterface\AbstractRouter;

class Router extends AbstractRouter
{
    function initialize(RouteCollector $routeCollector)
    {
        $this->setMethodNotAllowCallBack(function (Request $request,Response $response){
            $response->write('403');
            return false;
        });
        $this->setRouterNotFoundCallBack(function (Request $request,Response $response){
            $response->write('404');
            return false;
        });

        //获取邮件物品列表
        $routeCollector->post('/'.CHANNEL_TAGE.'/getRewardGoods','/Goods/index');
        $routeCollector->post('/'.CHANNEL_TAGE.'/email','/Email/index');
        $routeCollector->post('/'.CHANNEL_TAGE.'/gift','/Gift/index');
        $routeCollector->post('/'.CHANNEL_TAGE.'/giftCode','/GiftCode/index');
        $routeCollector->post('/'.CHANNEL_TAGE.'/notice','/Notice/index');
        $routeCollector->post('/'.CHANNEL_TAGE.'/recallNotice','/Notice/recall');


    }


}