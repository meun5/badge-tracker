<?php

namespace app\Authentication;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class Filter
{
    protected $auth;
    
    protected $app;
    
    public function __construct(\Slim\App $app)
    {
        $this->app = $app;
        $this->auth = $app->getContainer()["auth"];
    }
    
    /**
     * Authorization middleware invokable class
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $user = $request->getAttribute($this->auth->getKey());
        
        if (!$this->isAuthorized($user)) {
            $this->app->getContainer()["monolog"]->addEmergency("Unauthenticated " . $request->getMethod() . " request from " . $request->getServerParams()["REMOTE_ADDR"] . " on route to " . $request->getAttribute("route")->getName() . " was attempted and was successfully blocked.");
            return $response->withStatus(403)->withHeader("Content-type", "text/html")->write("<h1>Unauthenticated Access Not Allowed</h1><br><a href=\"" . $this->app->getContainer()["router"]->pathFor("auth.login.get") ."\">Please log in</a>");
        }
        
        return $next($request, $response);
    }

    /**
     * Check if the given user is authorized.
     *
     * @param  string $user The user to check.
     *
     * @return boolean true if the user is authorized, false otherwise.
     */
    protected function isAuthorized($user)
    {
        return true;
    }
}
