<?php
/**
 * Created by PhpStorm.
 * User: Herman
 * Date: 12/04/2016
 * Time: 11:38
 */

namespace Application\FormsBundle\Services;


use Gos\Bundle\WebSocketBundle\Periodic\PeriodicInterface;

class ChatPeriodic implements PeriodicInterface
{

    /**
     * Function excecuted n timeout.
     */
    public function tick()
    {
        // TODO: Implement tick() method.
        echo "Run after : ".$this->getTimeout()." seconds ".PHP_EOL;
    }

    /**
     * @return int (in second)
     */
    public function getTimeout()
    {
        // TODO: Implement getTimeout() method.
        return 1000;
    }
}