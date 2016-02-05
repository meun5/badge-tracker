<?php

namespace App\Tests;

use Slim\Container;
use Slim\App;
use Slim\Http\Environment;
use Slim\Http\Uri;
use Slim\Http\Headers;
use Slim\Http\RequestBody;
use Slim\Http\Request;
use Slim\Http\Response;
use BadMethodCallException;

class TestSetUp
{
    public static $configDefaults = [
        "settings" => [
            "displayErrorDetails" => true,
            "determineRouteBeforeAppMiddleware" => true,
        ]
    ];

    /** @var \Slim\App */
    public $app;

    /** @var  \Slim\Http\Request */
    public $request;

    /** @var  \Slim\Http\Response */
    public $response;

    /** @var  \Slim\Http\Cookies */
    private $cookies = [];

    /**
     * Create new Slim instance with the provided container
     *
     * @param      Container  $container  The container to attach
     */
    public function __construct($linkroutes = true, $requireDefaultContainer = true, Container $container = null, $config = [])
    {
        chdir(__DIR__);
        if (is_null($container)) {
            $container = new Container(array_merge(self::$configDefaults, $config));
        }

        if ($requireDefaultContainer) {
            require_once("../app/container.php");
        }

        $this->app = new App($container);

        if ($requireDefaultContainer) {
            $app = $this->app;
            require_once("../app/postContainer.php");
        }

        if ($linkroutes) {
            $this->addRoute(true);
        }
    }

    public function linkDB()
    {
        require_once("../app/database.php");
    }

    public function addRoute($path)
    {
        $app = $this->app;
        if ($path === true) {
            $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator("../resources/routes"));
            foreach ($iterator as $file) {
                $fname = $file->getFilename();
                if (preg_match("%\.php$%", $fname)) {
                    require_once($file->getPathname());
                }
            }
            return true;
        }
        require_once($path);
        return true;
    }

    public function __call($method, $arguments)
    {
        throw new BadMethodCallException(strtoupper($method) . ' is not supported');
    }

    public function get($path, $data = [])
    {
        $this->dispatch($path, "GET", $data);
        return $this->response;
    }

    public function post($path, $data = [])
    {
        $this->dispatch($path, "POST", $data);
        return $this->response;
    }

    /**
     * Dispatches a request to the specific route and then returns the response
     *
     * @param      string  $path    The Path to hit
     * @param      string  $method  The HTTP Method to use
     * @param      array   $data    Additional Data to pass as a part of the query
     */
    protected function dispatch($path, $method = "GET", $data = [])
    {
        // Prepare a mock environment
        $env = Environment::mock([
            'REQUEST_URI' => $path,
            'REQUEST_METHOD' => $method,
        ]);

        // Prepare request and response objects
        $uri = Uri::createFromEnvironment($env);
        $headers = Headers::createFromEnvironment($env);
        $cookies = [];
        $serverParams = $env->all();
        $body = new RequestBody();

        // Create the request object, and set params
        $req = new Request($method, $uri, $headers, $cookies, $serverParams, $body);
        if (!empty($data)) {
            $req = $req->withParsedBody($data);
        }

        $res = new Response();

        $this->headers = $headers;
        $this->request = $req;
        $this->response = call_user_func_array($this->app, [$req, $res]);
    }
}
