<?php

namespace KChlistala\Bundle\ReactHttpBundle\Server;

use React\Socket\Connection;

class ConnectionListener
{
    /** @var DataListener */
    private $dataListener;
    
    public function __invoke(Connection $connection)
    {
        $this->dataListener->setConnection($connection);
        
        $connection->on('data', $this->dataListener);
    }
    
    public function __construct(DataListener $dataListener)
    {
        $this->dataListener = $dataListener;
    }
}
