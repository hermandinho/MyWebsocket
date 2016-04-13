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
use Ratchet\Wamp\Topic;

class ChatService implements RpcInterface
{

    /**
     * @param ConnectionInterface $connection
     * @param WampRequest $request
     * @param $params
     * @return array
     */
    public function onPublish(ConnectionInterface $connection, Topic $topic, WampRequest $request, $event, array $exclude, array $eligible)
    {
       // return array("result" => array_sum($params));
        echo "YESSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS";
        $topic->broadcast([
            'msg' => $event,
        ]);
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