<?php
/**
 * Created by PhpStorm.
 * User: Herman
 * Date: 12/04/2016
 * Time: 12:13
 */

namespace Application\FormsBundle\Listeners;


use Gos\Bundle\WebSocketBundle\Client\ClientManipulatorInterface;
use Gos\Bundle\WebSocketBundle\Event\ClientErrorEvent;
use Gos\Bundle\WebSocketBundle\Event\ClientEvent;
use Gos\Bundle\WebSocketBundle\Event\ClientRejectedEvent;
use Gos\Bundle\WebSocketBundle\Event\ServerEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ChatListener extends Controller
{
    private $clientManipulator;

    public function __construct(ClientManipulatorInterface $clientManipulatorInterface)
    {
        $this->clientManipulator = $clientManipulatorInterface;
    }

    /**
     * Called whenever a client connects
     *
     * @param ClientEvent $event
     */
    public function onClientConnect(ClientEvent $event)
    {
        $conn = $event->getConnection();
        $user = $this->clientManipulator->getClient($conn);

        echo "* " . $user . " has connected at " . PHP_EOL;
    }

    /**
     * Called whenever a client disconnects
     *
     * @param ClientEvent $event
     */
    public function onClientDisconnect(ClientEvent $event)
    {
        $conn = $event->getConnection();

        echo "* " . $conn->resourceId . " disconnected" . PHP_EOL;
    }

    /**
     * Called whenever a client errors
     *
     * @param ClientErrorEvent $event
     */
    public function onClientError(ClientErrorEvent $event)
    {
        $conn = $event->getConnection();
        $e = $event->getException();

        echo "connection error occurred: " . $e->getMessage() . PHP_EOL;
    }

    /**
     * Called whenever server start
     *
     * @param ServentEvent $event
     */
    public function onServerStart(ServerEvent $event)
    {
        $event = $event->getEventLoop();

        echo 'Server was successfully started !' . PHP_EOL;
    }

    /**
     * Called whenever client is rejected by application
     *
     * @param ClientRejectedEvent $event
     */
    public function onClientRejected(ClientRejectedEvent $event)
    {
        $origin = $event->getOrigin;

        echo 'connection rejected from ' . $origin . PHP_EOL;
    }
}