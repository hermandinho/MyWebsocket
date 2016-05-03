<?php
/**
 * Created by PhpStorm.
 * User: Herman
 * Date: 11/04/2016
 * Time: 17:06
 */

namespace Application\FormsBundle\Services;


use Gos\Bundle\WebSocketBundle\Router\WampRequest;
use Gos\Bundle\WebSocketBundle\RPC\RpcInterface;
use Ratchet\ConnectionInterface;

class ChatService implements RpcInterface
{

    public function addFunc(ConnectionInterface $connection, WampRequest $request, $params)
    {
        return array("result" => array_sum($params));
    }

    /**
     * @return string
     */
    public function getName()
    {
        // TODO: Implement getName() method.
        return "chat.rpc";
    }
}