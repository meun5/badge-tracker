<?php

namespace app\MiddleWare;

use Slim\Middleware;

class BeforeMiddleWare extends Middleware
{
    public function call()
    {
        $this->app->hook('slim.before', [$this, 'run']);

        $this->next->call();
    }

    public function run()
    {
        if (isset($_SESSION[$this->app->config->get('auth.session')])) {
            $this->app->auth = $this->app->user->where('id', $_SESSION[$this->app->config->get('auth.session')])->first();
        }

        $this->checkRememberMe();

        $currentUrl = $this->app->request->getPathInfo();

        $this->app->view()->appendData([
            'auth' => $this->app->auth,
            'baseUrl' => $this->app->config->get('app.url'),
            'currentUrl' => $currentUrl,
            'app' => [
                'version' => $this->app->config->get('app.version'),
                'name' => $this->app->config->get('app.name'),
                'author' => $this->app->config->get('app.author'),
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
