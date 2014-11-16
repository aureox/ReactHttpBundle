<?php

namespace KChlistala\Bundle\ReactHttpBundle\Http;

use Symfony\Component\HttpFoundation\Response as BaseResponse;

class Response
{
    /** @var BaseResponse */
    private $symfonyResponse;
    
    private $kernel;
    
    public function __construct(BaseResponse $response, $kernel)
    {
        $this->symfonyResponse = $response;
        $this->kernel = $kernel;
    }
    
    public function getResponseBody()
    {
        return (string)$this->symfonyResponse;
    }
    
    public function gzip()
    {
        $this->symfonyResponse->headers->set('Content-Encoding', 'gzip');
        
        $contents = $this->symfonyResponse->getContent();
        $contentsSize = strlen($contents);
        $gzipContents = "\x1f\x8b\x08\x00\x00\x00\x00\x00".substr(gzcompress($contents, 6), 0, - 4).pack('V', crc32($contents)).pack('V', $contentsSize);
        
        $this->symfonyResponse->setContent($gzipContents);
    }
    
    public function terminate($request)
    {
        $this->kernel->terminate($request, $this->symfonyResponse);
    }
}
