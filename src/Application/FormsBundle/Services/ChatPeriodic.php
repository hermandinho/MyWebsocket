<?php
/**
 * Created by PhpStorm.
 * User: Herman
 * Date: 12/04/2016
 * Time: 11:38
 */

namespace Application\FormsBundle\Services;


use Gos\Bundle\WebSocketBundle\Periodic\PeriodicInterface;
use Ratchet\Wamp\Topic;

class ChatPeriodic implements PeriodicInterface
{
    private $chatTopic;

    public function __construct(ChatTopic $chatTopic)
    {
        $this->chatTopic = $chatTopic;
    }

    /**
     * Function excecuted n timeout.
     */
    public function tick()
    {

        //$topic = $this->chatTopic->clientStorageId;
        $topic = new Topic("/chat");
        $topic->broadcast(['msg' => "Putinnnnnnnnnnn"]);

        //var_dump($this->chatTopic);

        /** @var Topic $topic */
        //$topic->broadcast(['msg' => "form tick"]);
        echo "Run after : " . $this->getTimeout() . " seconds " . PHP_EOL;
    }

    /**
     * @return int (in second)
     */
    public function getTimeout()
    {
        // TODO: Implement getTimeout() method.
        return 1500;
    }
}