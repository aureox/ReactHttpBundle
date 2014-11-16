<?php

namespace KChlistala\Bundle\ReactHttpBundle\Creator;

use KChlistala\Bundle\ReactHttpBundle\Http\Response;

class ResponseCreator
{
    protected $kernel;
    
    /**
     * @param type $request
     * @return Response
     */
    public function create($request)
    {
        $symfonyResponse = $this->kernel->handle($request);
        
        return new Response($symfonyResponse, $this->kernel);
    }
    
    public function __construct($kernel)
    {
        $this->kernel = $kernel;
    }
}
