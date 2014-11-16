<?php

namespace KChlistala\Bundle\ReactHttpBundle\Http;

use GuzzleHttp\Message\MessageParser;

class RequestParser
{
    /** @var MessageParser */
    private $messageParser;
    
    private $headerMapping = [
        'Accept' => 'HTTP_ACCEPT',
        'User-Agent' => 'HTTP_USER_AGENT',
        'Host' => 'HTTP_HOST',
        'Accept-Encoding' => 'HTTP_ACCEPT_ENCODING',
        'Accept-Language' => 'HTTP_ACCEPT_LANGUAGE'
    ];

    public function parseRequest($request)
    {
        $parsedRequestParts = $this->messageParser->parseRequest($request);
        
        $parsedRequest = [
            'headers' => $this->parseHeaders($parsedRequestParts['headers']),
            'uri_components' => $parsedRequestParts['request_url'],
            'method' => $parsedRequestParts['method'],
            'protocol' => $parsedRequestParts['protocol'],
            'protocol_version' => $parsedRequestParts['protocol_version'],
            'body' => $parsedRequestParts['body']
        ];
        
        return $parsedRequest;
    }
    
    protected function parseHeaders($headers)
    {
        $parsed = [];
        foreach ($this->headerMapping as $parsedHeaderName => $originalHeaderName) {
            if (isset($headers[$parsedHeaderName])) {
                $parsed[$originalHeaderName] = $headers[$parsedHeaderName];
            }
        }
        
        return $parsed;
    }

    public function __construct(MessageParser $messageParser)
    {
        $this->messageParser = $messageParser;
    }
}
