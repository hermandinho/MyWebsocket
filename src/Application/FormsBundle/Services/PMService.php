<?php
/**
 * Created by PhpStorm.
 * User: Herman
 * Date: 25/04/2016
 * Time: 11:22
 */

namespace Application\FormsBundle\Services;


use Gos\Bundle\WebSocketBundle\Router\WampRequest;
use Gos\Bundle\WebSocketBundle\RPC\RpcInterface;
use Ratchet\ConnectionInterface;

class PMService implements RpcInterface
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
        return "pm.rpc";
    }
}