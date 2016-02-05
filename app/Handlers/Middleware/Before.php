<?php

namespace app\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Views\Twig;
use Slim\Router;
use Monolog\Logger;

class Before
{
    protected $view;
    
    protected $router;
    
    public function __construct(Twig $view, Router $router, Logger $monolog)
    {
        $this->view = $view;
        
        $this->router = $router;

        $this->monolog = $monolog;
    }
    
    /**
     * Before Middleware View Attachment
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $this->view["url"] = [
            "current" => $this->router->pathFor($request->getAttribute("route")->getName()),
            "remote" => $request->getServerParams()["REMOTE_ADDR"],
        ];

        $this->monolog->addInfo("Incoming " . $request->getMethod() . " request from " . $request->getServerParams()["REMOTE_ADDR"] . " on route to " . $request->getAttribute("route")->getName() . " path:" . $this->router->pathFor($request->getAttribute("route")->getName()));

        return $next($request, $response);
    }
}
