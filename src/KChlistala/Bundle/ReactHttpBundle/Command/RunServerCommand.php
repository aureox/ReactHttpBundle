<?php

namespace KChlistala\Bundle\ReactHttpBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class RunServerCommand extends ContainerAwareCommand
{

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('react-http:server:run')
            ->setDescription('Runs react http server')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $connectionListener = $this->getConnectionListener();
        $this->configureSocket($connectionListener);
        
        $output->writeln("React HTTP Server started");
        
        $this->loop();
    }
    
    protected function getConnectionListener()
    {
        return $this->getContainer()->get('kchlistala_react_http.connection_listener');
    }
    
    protected function configureSocket($connectionListener)
    {
        $socket = $this->getContainer()->get('kchlistala_react_http.react_socket_server');
        $socket->on('connection', $connectionListener);
        $socket->listen('9000', 'localhost');
    }
    
    protected function loop()
    {
        $loop = $this->getContainer()->get('kchlistala_react_http.react_event_loop');
        $loop->run();
    }
}
