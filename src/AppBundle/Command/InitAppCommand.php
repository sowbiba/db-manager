<?php
/**
 * Created by PhpStorm.
 * User: isow
 * Date: 09/04/16
 * Time: 15:56
 */

namespace AppBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Dumper;

class InitAppCommand extends ContainerAwareCommand
{
    private $output;

    protected function configure()
    {
        $this->setName('dbmanager:init-app')
            ->setDescription('Initialize application required data')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $container = $this->getContainer();
            $this->output = $output;

            $this->writeLog("Enter full path to id_rsa.pub :", 'info');

            $handle = fopen ("php://stdin","r");
            $line = fgets($handle);
            $pubkeyPath = str_replace("\n", "", $line);
            $privatekeyPath = pathinfo($pubkeyPath)['dirname'] . DIRECTORY_SEPARATOR . pathinfo($pubkeyPath)['filename'];
            if(! file_exists($pubkeyPath) || ! file_exists($privatekeyPath)){
                $this->writeLog("Path given [$pubkeyPath] is wrong. Please re-execute the command.", 'error');
                return -1;
            }
            fclose($handle);

            $this->writeLog("Enter your username :", 'info');

            $handle = fopen ("php://stdin","r");
            $line = fgets($handle);
            $username = trim(str_replace("\n", "", $line));

            if('' === $username){
                $this->writeLog("Username given [$username] is wrong. Please re-execute the command.", 'error');
                return -1;
            }

            fclose($handle);


            $this->writeLog("Enter your passphrase :", 'info');

            $handle = fopen ("php://stdin","r");
            $line = fgets($handle);
            $passPhrase = str_replace("\n", "", $line);

            fclose($handle);

            $hostParameters = array(
                'private_key' => $privatekeyPath,
                'public_key' => $pubkeyPath,
                'username' => $username,
                'passphrase' => $passPhrase,
            );

            $dumper = new Dumper();
            $yaml = $dumper->dump($hostParameters);
            $path = $container->getParameter('kernel.root_dir') . '/config/host_parameters.yml';
            file_put_contents($path, $yaml);


            $initSqlFile = sprintf("%s/database/init/data.sql", $container->getParameter('kernel.root_dir'));

            if (! file_exists($initSqlFile)) {
                throw new \Exception("Init SQL file does not exist in $initSqlFile");
            }

            $sql = file_get_contents($initSqlFile);

            $container->get('doctrine.orm.default_entity_manager')->getConnection()->executeQuery($sql);

            return 0;
        } catch (\Exception $e) {
            $this->writeLog(
                sprintf(
                    "An exception (%s) occured with the code %s and message : \n[[\t%s\t]]",
                    get_class($e),
                    $e->getCode(),
                    $e->getMessage()
                ),
                'error'
            );

            return -1;
        }
    }

    /**
     * Write the logs in the log file and on the screen.
     *
     * @param string $logMessage message for the log
     * @param string $type       kind of log (error, info, ...)
     *
     * @return bool
     */
    private function writeLog($logMessage, $type = 'info')
    {
        if (null === $this->output) {
            var_dump('la');
            return false;
        }

        if (!empty($logMessage)) {
            switch ($type) {
                case 'error':
                    $color = 'red';
                    break;
                case 'warning':
                    $color = 'yellow';
                    break;
                case 'success':
                    $color = 'green';
                    break;
                default:
                    $color = 'white';
                    break;
            }

            $logMessage = "<fg=$color>$logMessage</fg=$color>";

            $this->output->writeln($logMessage);
        }

        return true;
    }
}