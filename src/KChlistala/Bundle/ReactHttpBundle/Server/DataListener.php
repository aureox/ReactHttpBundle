<?php

namespace KChlistala\Bundle\ReactHttpBundle\Server;

use React\Socket\Connection;
use KChlistala\Bundle\ReactHttpBundle\Creator\RequestCreator;
use KChlistala\Bundle\ReactHttpBundle\Creator\ResponseCreator;

class DataListener
{
    /** @var Connection */
    private $connection;

    /** @var RequestCreator */
    private $requestCreator;
    
    /** @var ResponseCreator */
    private $responseCreator;
    
    public function __invoke($data)
    {
        $request = $this->requestCreator->create($data);
        $response = $this->responseCreator->create($request);
        $response->gzip();
        
        $this->connection->write($response->getResponseBody());
        
        $response->terminate($request);
        
        $this->connection->end();
    }
    
    public function setConnection(Connection $connection)
    {
        $this->connection = $connection;
    }
    
    public function __construct(RequestCreator $requestCreator, ResponseCreator $responseCreator)
    {
        $this->requestCreator = $requestCreator;
        $this->responseCreator = $responseCreator;
    }
}
