<?php

namespace app\MiddleWare;

use Slim\Middleware;
use Exception;

class BeforeMiddleWare extends Middleware
{
    private $info;

    public function call()
    {
        $this->info = $this->app->config('info');

        $this->app->hook('slim.before', [$this, 'run']);

        $this->next->call();
    }

    public function run()
    {
        if (isset($_SESSION[$this->app->config->get('auth.session')])) {
            $this->app->auth = $this->app->user->where('id', $_SESSION[$this->app->config->get('auth.session')])->first();
        }

        if ($this->app->config->get('app.hash.cost') < 10) {
            throw new Exception("Hash Cost is too low");
        }

        $this->checkRememberMe();

        $this->app->view()->appendData([
            'auth' => $this->app->auth,
            'url'  => [
                'base'      => $this->app->config->get('app.url'),
                'current'   => $this->app->request->getPathInfo(),
            ],
            'app' => [
                'version' => $this->info["version"],
                'name' => $this->info["name"],
                'author' => $this->info["author"],
            ],         
        ]);
    }

    protected function checkRememberMe()
    {
        if ($this->app->getCookie($this->app->config->get('auth.remember')) && !$this->app->auth) {
            $data = $this->app->getCookie($this->app->config->get('auth.remember'));
            $credentials = explode('___', $data);

            if (empty(trim($data)) || count($credentials) !== 2) {
                return $this->app->response->redirect($this->app->urlFor('home'));
            } else {
                $identifier = $credentials[0];
                $token = $this->app->hash->hash($credentials[1]);

                $user = $this->app->user
                    ->where('remember_identifier', $identifier)
                    ->first();

                if ($user) {
                    if ($this->app->hash->hashCheck($token, $user->remember_token)) {
                        $_SESSION[$this->app->config->get('auth.session')] = $user->id;
                        $this->app->auth = $this->app->user->where('id', $user->id)->first();
                    } else {
                        $user->removeRememberCredentials();
                    }
                }
            }
        }
    }
}
