<?php
/**
 * Created by PhpStorm.
 * User: isow
 * Date: 17/04/16
 * Time: 22:14
 */

namespace AppBundle\Tools\Tasks;


use AppBundle\Tools\Connections\MySQLConnection;

class MysqlTasks
{
    /**
     * @var MySQLConnection
     */
    private $mySQLConnection;

    /**
     * @var string
     */
    private $workingDir = '/tmp';

    public function __construct(MySQLConnection $mySQLConnection, $workingDir = '/tmp')
    {
        $this->mySQLConnection = $mySQLConnection;
        $this->workingDir = $workingDir;
    }

    public function import($dumpFile, $dbname)
    {
        if (! file_exists($dumpFile)) {
            return false;
        }

        try {
            $this->mySQLConnection->setDatabase($dbname);
            $connection = $this->mySQLConnection->getConnection();

            if (null === $connection) {
                return false;
            }

            $sql = file_get_contents($dumpFile);

            $stmt = $connection->prepare($sql);
            $stmt->execute();
            do {
                // Required due to "MySQL has gone away!" issue
                $stmt->fetch();
                $stmt->closeCursor();
            } while ($stmt->nextRowset());

        } catch(\Exception $e) {
            throw $e;
            return false;
        }
    }
} 