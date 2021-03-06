<?php
/**
 * Created by PhpStorm.
 * User: isow
 * Date: 10/04/16
 * Time: 09:52
 */

namespace AppBundle\Tools\Connections;


class LocalConnection extends AbstractConnection
{
    private $filepath;

    public function __construct()
    {

    }

    public function setFilepath($filepath)
    {
        $this->filepath = $filepath;
    }

    public function test()
    {
        $this->messages = [];

        if (null === $this->filepath) {
            $this->messages = ["Le dossier de travail n'est pas défini"];

            return false;
        }

        array_push($this->messages, sprintf("Vérification du dossier de travail [ %s ].", $this->filepath));

        if (!is_readable($this->filepath)) {
            array_push($this->messages, sprintf("Echec : Le dossier de travail [ %s ] n'est pas accessible en lecture", $this->filepath));
        }

        if (!is_writable($this->filepath)) {
            array_push($this->messages, sprintf("Echec : Le dossier de travail [ %s ] n'est pas accessible en écriture", $this->filepath));
        }

        $response = is_readable($this->filepath) && is_writable($this->filepath);

        if ($response) {
            array_push($this->messages, "Test de connexion : OK.");
        }

        return $response;
    }

    public function content()
    {
        $this->messages = array();

        if (! $this->test()) {
            return false;
        }

        $directoryContent = scandir($this->filepath);

        $files = array();
        foreach ($directoryContent as $key => $value) {
            $path = $this->filepath . DIRECTORY_SEPARATOR . $value;

            if (! is_dir($path) && !in_array($value, array('.', '..'))) {
                $path_parts = pathinfo($path);

                if (in_array(strtolower($path_parts['extension']), array('sql', 'gz', 'zip'))) {
                    $files[] = $value;
                }
            }
        }

        return $files;
    }
} 