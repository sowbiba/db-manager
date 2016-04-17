<?php
/**
 * Created by PhpStorm.
 * User: isow
 * Date: 17/04/16
 * Time: 21:27
 */

namespace AppBundle\Tools\Tasks;


use AppBundle\Tools\Connections\SshConnection;

class SshTasks
{
    /**
     * @var SshConnection
     */
    private $sshConnection;

    /**
     * @var string
     */
    private $workingDir = '/tmp';

    public function __construct(SshConnection $sshConnection, $workingDir = '/tmp')
    {
        $this->sshConnection = $sshConnection;
        $this->workingDir = $workingDir;
    }

    public function transferFile($filepath, $filename)
    {
        $connection = $this->sshConnection->connect();

        if (!in_array($filename, $this->sshConnection->content())) {
            return false;
        }

        $remoteFilepath = $filepath . ((substr($filepath, -1) == DIRECTORY_SEPARATOR ? '' : DIRECTORY_SEPARATOR));
        $remoteFile = $remoteFilepath.$filename;

        $localFilePath = $this->workingDir . ((substr($this->workingDir, -1) == DIRECTORY_SEPARATOR ? '' : DIRECTORY_SEPARATOR));
        $localFile = $localFilePath.$filename;

        $path_parts = pathinfo($remoteFile);

        $isZip = false;
        if (strtolower($path_parts['extension']) == array('gz')) {
            $isZip = true;
        }

        if (! $isZip) {
            // Zip the remote file
            $zipCommand = sprintf('gzip %s', $remoteFile);
            if (false === ssh2_exec($connection, $zipCommand)) {
                return false;
            }

            $remoteFile .= '.gz';
            $localFile .= '.gz';
        }

        $received = ssh2_scp_recv($connection, $remoteFile, $localFile);

        if ($received) {
            // Unzip the file
            $this->gunzip($localFile);
        }

        return $received;
    }

    private function gunzip($gzFile, $delete = true)
    {
        // Raising this value may increase performance
        $buffer_size = 4096; // read 4kb at a time
        $out_file_name = str_replace('.gz', '', $gzFile);

        // Open our files (in binary mode)
        $file = gzopen($gzFile, 'rb');
        $out_file = fopen($out_file_name, 'wb');

        // Keep repeating until the end of the input file
        while(!gzeof($file)) {
            // Read buffer-size bytes
            // Both fwrite and gzread and binary-safe
            fwrite($out_file, gzread($file, $buffer_size));
        }

        // Files are done, close files
        fclose($out_file);
        gzclose($file);

        if ($delete) {
            unlink($gzFile);
        }
    }
} 