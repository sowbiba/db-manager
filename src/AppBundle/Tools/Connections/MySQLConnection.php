<?php
/**
 * Created by PhpStorm.
 * User: isow
 * Date: 10/04/16
 * Time: 14:33
 */

namespace AppBundle\Tools\Connections;


use Doctrine\DBAL\Driver\Mysqli\MysqliConnection;

class MySQLConnection extends AbstractConnection
{
    /**
     * @var MysqliConnection
     */
    private $connection;

    private $workingDir;

    /**
     * @param array $parameters
     * @return MysqliConnection|null
     */
    public function configure($parameters)
    {
        if (
            !isset($parameters['host']) ||
            !isset($parameters['port']) ||
            !isset($parameters['username']) ||
            !isset($parameters['password']) ||
            !isset($parameters['working_dir'])
        ) {
            return null;
        }

        $this->connection = new MysqliConnection(
            [
                'host' => $parameters['host'],
                'port' => $parameters['port']
            ],
            $parameters['username'],
            $parameters['password']
        );

        $this->workingDir = $parameters['working_dir'];
    }

    public function test()
    {
        if (null === $this->connection) {
            return false;
        }

        try {
            $result = $this->connection->exec("SHOW DATABASES;");

            if (! $result) {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
} 