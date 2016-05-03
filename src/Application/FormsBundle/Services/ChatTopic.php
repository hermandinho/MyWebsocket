<?php
/**
 * Created by PhpStorm.
 * User: Herman
 * Date: 11/04/2016
 * Time: 17:22
 */

namespace Application\FormsBundle\Services;


use Doctrine\Common\Collections\ArrayCollection;
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
    private $topic;
    private $userList;

    public function __construct(ClientManipulatorInterface $clientManipulatorInterface, ClientStorageInterface $clientStorageInterface)
    {
        $this->clientManipulator = $clientManipulatorInterface;
        $this->clientStorage = $clientStorageInterface;
        $this->topic = null;
        $this->userList = [];
    }

    /**
     * @param  ConnectionInterface $connection
     * @param  Topic $topic
     * @param WampRequest $request
     */
    public function onSubscribe(ConnectionInterface $connection, Topic $topic, WampRequest $request)
    {
        $this->topic = $topic;
        $user = $this->clientManipulator->getClient($connection);

        //$u = $this->clientStorage->getClient($connection->WAMP->clientStorageId);
        //$topic->broadcast(['msg' => $user. " has joined " . $topic->getId()]);
        $user1 = $this->clientManipulator->findByUsername($topic, 'admin');
        $topic->broadcast(["userList" => $this->getConnectedUsers($topic, $connection), "msg" => "connected", "user" => $user->getUsername(), "type" => "system"]);
    }

    /**
     * @param Topic $topic
     * @return ArrayCollection
     */
    private function getConnectedUsers(Topic $topic, ConnectionInterface $connection)
    {

        $users = [];
        /** @var Topic $topic */
        foreach ($topic as $client) {
            $user = $this->clientManipulator->getClient($client);
            $users[] = $user->getUsername();
        }
        $this->userList = $users;

        return $users;
    }

    /**
     * @param  ConnectionInterface $connection
     * @param  Topic $topic
     * @param WampRequest $request
     */
    public function onUnSubscribe(ConnectionInterface $connection, Topic $topic, WampRequest $request)
    {
        // TODO: Implement onUnSubscribe() method.
        $user = $this->clientManipulator->getClient($connection)->getUsername();

        foreach ($this->userList as $key => $username) {
            if ($username == $user) {
                unset($this->userList[$key]);
            }
        }

        //$topic->broadcast(['msg' => $connection->resourceId . " has left " . $topic->getId()]);
        $topic->broadcast(["userList" => $this->userList, 'msg' => 'disconnected', 'user' => $user, 'type' => "system"]);
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
        $user = $this->clientManipulator->getClient($connection);

        $topic->broadcast([
            'msg' => $event,
            'user' => $user->getUsername(),
            "userList" => $this->getConnectedUsers($topic, $connection),
            'type' => 'user'
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