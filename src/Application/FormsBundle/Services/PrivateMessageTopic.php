<?php
/**
 * Created by PhpStorm.
 * User: Herman
 * Date: 25/04/2016
 * Time: 11:11
 */

namespace Application\FormsBundle\Services;


use Gos\Bundle\WebSocketBundle\Client\ClientManipulatorInterface;
use Gos\Bundle\WebSocketBundle\Client\ClientStorageInterface;
use Gos\Bundle\WebSocketBundle\Router\WampRequest;
use Gos\Bundle\WebSocketBundle\Topic\TopicInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Wamp\Topic;

class PrivateMessageTopic implements TopicInterface
{
    protected $clientManipulator;
    protected $clientStorage;
    private $topic;

    public function __construct(ClientManipulatorInterface $clientManipulatorInterface, ClientStorageInterface $clientStorageInterface)
    {
        $this->clientManipulator = $clientManipulatorInterface;
        $this->clientStorage = $clientStorageInterface;
        $this->topic = null;
    }

    /**
     * @param  ConnectionInterface $connection
     * @param  Topic $topic
     * @param WampRequest $request
     */
    public function onSubscribe(ConnectionInterface $connection, Topic $topic, WampRequest $request)
    {
        $user = $this->clientManipulator->getClient($connection);
        $topic->broadcast(['msg' => $user . " has joined " . $topic->getId()]);
    }

    /**
     * @param  ConnectionInterface $connection
     * @param  Topic $topic
     * @param WampRequest $request
     */
    public function onUnSubscribe(ConnectionInterface $connection, Topic $topic, WampRequest $request)
    {
        $user = $this->clientManipulator->getClient($connection);
        $topic->broadcast(['msg' => $user . " has left."]);
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
        $topic->broadcast([
            'msg' => $event,
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return "pm.rpc";
    }
}