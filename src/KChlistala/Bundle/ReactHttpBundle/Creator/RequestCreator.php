<?php

namespace KChlistala\Bundle\ReactHttpBundle\Creator;

use KChlistala\Bundle\ReactHttpBundle\Http\RequestParser;
use KChlistala\Bundle\ReactHttpBundle\Http\Request;

class RequestCreator
{
    /** @var RequestParser */
    protected $requestParser;
    
    public function create($notParsedRequest)
    {
        $parsedRequest = $this->requestParser->parseRequest($notParsedRequest);
        
        return Request::createFromParsedData($parsedRequest);
    }
    
    public function __construct(RequestParser $requestParser)
    {
        $this->requestParser = $requestParser;
    }
}
