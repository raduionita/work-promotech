<?php
namespace Promo\MemcacheBundle\Command;

use Promo\MemcacheBundle\Service\MemcacheService;
use \Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MemcacheStresserCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('memcache:stresser')
            ->setDescription('Memcache stresser - send commands to memcache server and measure the load on the machine')
            ->addArgument(
                'iterations',
                InputArgument::REQUIRED,
                'How many iterations'
            );
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $iterations = $input->getArgument('iterations');
        
        /** @var \Memcached $memcache */
        $memcache = $this->getContainer()->get(MemcacheService::ID);

        $servers = $memcache->getServerList();
        foreach ($servers as $server) {
            $output->writeln('Memcache '. $server['host'] .':'. $server['port']);
        }

        /* ** Write ************************************************************************************************* */
        
        $output->writeln('Iterations: '. $iterations);
        $time = microtime(true);
        $cpu  = (sys_getloadavg()[0] * 100);
        $output->writeln('Time:'. '0');
        //$output->writeln('RAM :'. (memory_get_usage() / (1024*1024)) .'M');
        $output->writeln('RAM :'. $this->getRAM() .'M Free');
        $output->writeln('CPU :'. ($cpu = max($cpu, (sys_getloadavg()[0] * 100))) .'% 5min');

        $output->write('Writting...');
        $j = 0;
        for ($i = 0; $i < $iterations; ++$i) {
            if($memcache->set('key'.$i, json_encode(range(1, 1000)))) {
                $j++;
            }
        }
        sleep(2);
        $output->writeln($j .' keys');

        /* ** Read ************************************************************************************************** */

        $output->writeln('Time:'. round(microtime(true) - $time, 4) .'s');
        $output->writeln('RAM :'. $this->getRAM() .'M Free');
        $output->writeln('CPU :'. ($cpu = max($cpu, (sys_getloadavg()[0] * 100))) .'% 5min');

        $output->write('Reading...');
        $j = 0;
        for ($i = 0; $i < $iterations; ++$i) {
            $key = $memcache->get('key'.$i);
            if ($key) {
                $j++;
            }
        }
        sleep(2);
        $output->writeln($j .' keys');
        
        /* ** Delete ************************************************************************************************ */
        
        $output->writeln('Time:'. round(microtime(true) - $time, 4) .'s');
        $output->writeln('RAM :'. $this->getRAM() .'M Free');
        $output->writeln('CPU :'. ($cpu = max($cpu, (sys_getloadavg()[0] * 100))) .'% 5min');

        $output->write('Deleting...');
        $j = 0;
        for ($i = 0; $i < $iterations; ++$i) {
            if ($memcache->delete('key'.$i)) {
                $j++;
            }
        }
        sleep(2);
        $output->writeln($j .' keys');

        /* ********************************************************************************************************** */

        $output->writeln('Time:'. round(microtime(true) - $time, 4) .'s');
        $output->writeln('RAM :'. $this->getRAM() .'M Free');
        $output->writeln('CPU :'. ($cpu = max($cpu, (sys_getloadavg()[0] * 100))) .'% 5min');
    }

    private function getRAM()
    {
        $fh = fopen('/proc/meminfo', 'r');
        $mem = 0;
        while ($line = fgets($fh)) {
            $parts = [];
            if (preg_match('/^MemFree:\s+(\d+)\skB$/', $line, $parts)) {
                $mem = $parts[1];
                break;
            }
        }
        fclose($fh);
        return round($mem / 1024, 4);
    }
}