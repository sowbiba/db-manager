<?php
/**
 * Created by PhpStorm.
 * User: isow
 * Date: 10/04/16
 * Time: 11:48
 */

namespace AppBundle\Tools\Connections;


use AppBundle\Entity\Source;

final class SourceConnectionTester
{
    const LOCAL_SOURCE = 1;
    const SSH_SOURCE = 2;

    private $connection;

    public function testConnection(Source $source)
    {
        $this->getConnection($source);

        if (null === $this->connection) {
            return false;
        }

        return $this->connection->test();
    }

    private function getConnection(Source $source)
    {
        switch ($source->getType()->getId()) {
            case static::LOCAL_SOURCE:
                $this->connection = $this->getLocalConnection($source);
                break;
            case static::SSH_SOURCE:
                $this->connection = $this->getSshConnection($source);
                break;
            default:
                $this->connection = null;
                break;
        }
    }

    private function getLocalConnection(Source $source)
    {
        if (static::LOCAL_SOURCE !== $source->getType()->getId()) {
            return null;
        }

        $connection = new LocalConnection();
        $connection->setFilepath($source->getFilepath());

        return $connection;
    }

    private function getSshConnection(Source $source)
    {
        if (static::SSH_SOURCE !== $source->getType()->getId()) {
            return null;
        }

        $connection = new SshConnection();
        $connection->setHost($source->getHost());
        $connection->setPort($source->getPort());
        $connection->setUsername($source->getUsername());
        $connection->setPassword($source->getPassword());
        $connection->setFilepath($source->getFilepath());

        return $connection;
    }

    public function getMessages()
    {
        return $this->connection->getMessages();
    }
} 