<?php

namespace Promo\RedisBundle\Command;

use Promo\RedisBundle\Service\RedisService;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RedisChannelListenerCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('redis:channel-listener')
            ->setDescription('Redis Channel Listener - listene to requested channel')
            ->addArgument(
                'channel',
                InputArgument::REQUIRED,
                'What channel to you whant to listen to?'
            );
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $channel = $input->getArgument('channel');
        $style = new OutputFormatterStyle('blue', null, array('bold'/*, 'blink'*/));
        $output->getFormatter()->setStyle('blue', $style);
        $output->writeln('Listening on channel <blue>'.$channel.'</>...');
        $redis = $this->getContainer()->get(RedisService::ID);
        $redis->subscribe([$channel], function(\Redis $redis, string $channel, string $message) use ($output) {
            $this->callback($redis, $channel, $message);
        });
    }

    /**
     * @param  \Redis $redis
     * @param  string $channel
     * @param  string $message
     * @return \Redis
     */
    protected function callback(\Redis $redis, string $channel, string $message) : \Redis 
    {
        // do something
        echo '[',$channel,'] ',$message,"\n";
        return $redis;
    }
}