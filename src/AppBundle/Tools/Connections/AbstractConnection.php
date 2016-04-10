<?php
/**
 * Created by PhpStorm.
 * User: isow
 * Date: 10/04/16
 * Time: 09:50
 */

namespace AppBundle\Tools\Connections;


class AbstractConnection
{
    protected $messages = [];

    public function getMessages()
    {
        return implode("\n\n", $this->messages);
    }

} 