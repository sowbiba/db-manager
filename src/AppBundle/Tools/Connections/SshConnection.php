<?php
/**
 * Created by PhpStorm.
 * User: isow
 * Date: 10/04/16
 * Time: 09:52
 */

namespace AppBundle\Tools\Connections;


use Doctrine\DBAL\Driver\Mysqli\MysqliConnection;

class SshConnection extends AbstractConnection
{
    private $host;
    private $port = 22;
    private $username;
    private $password;
    private $filepath;

    public function __construct()
    {

    }

    public function setFilepath($filepath)
    {
        $this->filepath = $filepath;
    }

    public function setHost($host)
    {
        $this->host = $host;
    }

    public function setPort($port)
    {
        $this->port = $port;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function test()
    {
        $this->messages = [];

        if (
            null === $this->host ||
            null === $this->port ||
            null === $this->filepath
        ) {
            $this->messages = ["Les paramètres de connexion ne sont pas complets"];

            return false;
        }

        array_push($this->messages, "Vérification de la connectivité.");

        $connection = $this->connect();
        if (! $connection) {
            array_push($this->messages, sprintf("La connexion au serveur [ %s ] a échoué.", $this->host));

            return false;
        }

        array_push($this->messages, "Connectivité : OK.");

        array_push($this->messages, sprintf("Vérification du dossier de travail [ %s ].", $this->filepath));

        $sftp = ssh2_sftp($connection);

        if (! file_exists(sprintf('ssh2.sftp://%s%s', $sftp, $this->filepath))) {
            array_push($this->messages, sprintf("Echec : Le dossier de travail [ %s ] n'existe pas.", $this->filepath));

            return false;
        }

        if (
            ! is_readable(sprintf('ssh2.sftp://%s%s', $sftp, $this->filepath)) ||
            ! is_writable(sprintf('ssh2.sftp://%s%s', $sftp, $this->filepath))
        ) {
            array_push($this->messages, sprintf("Echec : Le dossier de travail [ %s ] n'est pas accessible en lecture/écriture.", $this->filepath));

            return false;
        }

        array_push($this->messages, "Test de connexion : OK.");

        return true;
    }

    public function connect()
    {
        try {
            $connection = ssh2_connect($this->host, $this->port);
            if (!ssh2_auth_password($connection, $this->username, $this->password)) {
                return false;
            }
        } catch(\Exception $e) {
            return false;
        }

        return $connection;
    }

    public function content()
    {
        $this->messages = array();

        if (! $this->test()) {
            return false;
        }

        $connection = $this->connect();
        if (! $connection) {
            array_push($this->messages, sprintf("La connexion au serveur [ %s ] a échoué.", $this->host));

            return false;
        }

        $sftp = ssh2_sftp($connection);

        $handle = opendir(sprintf('ssh2.sftp://%s%s', $sftp, $this->filepath));

        $files = array();
        while (false != ($entry = readdir($handle))) {
            if (
                !in_array($entry, array('.', '..')) &&
                in_array(strtolower(pathinfo($entry, PATHINFO_EXTENSION)), array('sql', 'gz', 'zip'))
            ) {
                $files[] = "$entry";
            }
        }

        return $files;
    }
} 