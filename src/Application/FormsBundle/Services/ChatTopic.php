<?php
/**
 * Created by PhpStorm.
 * User: Herman
 * Date: 11/04/2016
 * Time: 17:22
 */

namespace Application\FormsBundle\Services;


use Gos\Bundle\WebSocketBundle\Client\ClientManipulatorInterface;
use Gos\Bundle\WebSocketBundle\Client\ClientStorageInterface;
use Gos\Bundle\WebSocketBundle\Router\WampRequest;
use Gos\Bundle\WebSocketBundle\Topic\TopicInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Wamp\Topic;

class ChatTopic implements TopicInterface

{
    protected $clientManipulator;
    protected $clientStorage;

    public function __construct(ClientManipulatorInterface $clientManipulatorInterface,ClientStorageInterface $clientStorageInterface)
    {
        $this->clientManipulator = $clientManipulatorInterface;
        $this->clientStorage = $clientStorageInterface;
    }

    /**
     * @param  ConnectionInterface $connection
     * @param  Topic $topic
     * @param WampRequest $request
     */
    public function onSubscribe(ConnectionInterface $connection, Topic $topic, WampRequest $request)
    {
        // TODO: Implement onSubscribe() method.
        $user = $this->clientManipulator->getClient($connection);
        $u = $this->clientStorage->getClient($connection->WAMP->clientStorageId);
        $topic->broadcast(['msg' => $connection->resourceId . " has joined " . $topic->getId()." : ".$u]);
    }

    /**
     * @param  ConnectionInterface $connection
     * @param  Topic $topic
     * @param WampRequest $request
     */
    public function onUnSubscribe(ConnectionInterface $connection, Topic $topic, WampRequest $request)
    {
        // TODO: Implement onUnSubscribe() method.
        $user = $this->clientManipulator->getClient($connection);
        $topic->broadcast(['msg' => $connection->resourceId . " has left " . $topic->getId()]);
    }

    /**
     * @param  ConnectionInterface $connection
     * @param  Topic $topic
     * @param WampRequest $request
     * @param $event
     * @param  array $exclude
     * @param  array $eligible
     */
    public function onPublish(ConnectionInterface $connection, Topic $topic, WampRequest $request, $event, array $exclude, array $eligible)
    {
        // TODO: Implement onPublish() method.
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