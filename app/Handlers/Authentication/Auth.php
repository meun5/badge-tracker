<?php

namespace app\Authentication;

use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Message\ResponseInterface;

class Auth
{
    protected $prefix;
    
    protected $auth;
    
    protected $c;
    
    protected $user;
    
    protected $view;
    
    public function __construct(\Slim\Container $c, $prefix = "auth")
    {
        $this->prefix = trim($prefix);
        
        $this->c = $c["config"];
        
        $this->user = $c["user"];
        
        $this->view = $c["view"];
    }
    
    /**
     * Invoke middleware
     *
     * @param  RequestInterface  $request  PSR7 request object
     * @param  ResponseInterface $response PSR7 response object
     * @param  callable          $next     Next middleware callable
     *
     * @return ResponseInterface PSR7 response object
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        if (isset($_SESSION[$this->c->get("services.authentication.session")]) &&
            is_int($_SESSION[$this->c->get("services.authentication.session")])) {
            $this->auth = $this->user->where(
                "id",
                "=",
                $_SESSION[$this->c->get("services.authentication.session")]
            )->first();
            $request = $this->login($request);
            $this->view["auth"] = $this->auth;
        }
        
        return $next($request, $response);
    }
    
    protected function login(ServerRequestInterface $request)
    {
        $request = $request->withAttribute($this->prefix, $this->auth);

        return $request;
    }
    
    public function getKey()
    {
        return $this->prefix;
    }
    
    public function getRaw()
    {
        return $this->auth->toArray();
    }
}
