<?php
/**
 * Created by PhpStorm.
 * User: isow
 * Date: 10/04/16
 * Time: 11:48
 */

namespace AppBundle\Tools\Connections;


use AppBundle\Entity\Target;

final class TargetConnection
{
    /**
     * @var AbstractConnection
     */
    private $connection;

    private $messages = [];

    public function testConnection(Target $target)
    {
        array_push($this->messages, "Test de connexion au serveur.");

        $this->connection = $this->getConnection($target);

        if (null === $this->connection) {
            array_push($this->messages, "Echec : Les paramètres de la cible ne sont pas corrects.");

            return false;
        }

        array_push($this->messages, "Connexion au serveur : OK.");
        array_push($this->messages, "Test d'exécution de requête.");

        if (! $this->connection->test()) {
            array_push($this->messages, "Echec : Exécution de requête impossible.");

            return false;
        }

        array_push($this->messages, "Vérification : OK.");

        return true;
    }

    /**
     * @param Target $target
     * @return MySQLConnection
     */
    public function getConnection(Target $target)
    {
        try {
            $connection = new MySQLConnection();
            $connection->configure([
                'host' => $target->getHost(),
                'port' => null !== $target->getPort() ? $target->getPort() : 3306,
                'username' => $target->getUsername(),
                'password' => $target->getPassword(),
                'working_dir' => $target->getWorkingDir(),
            ]);
        } catch (\Exception $e) {
            $connection = null;

            array_push(
                $this->messages,
                sprintf("Echec : Connexion impossible \n[ %s ].", $e->getMessage())
            );
        }

        return $connection;
    }

    public function getMessages()
    {
        return implode("\n\n", $this->messages);
    }
} 