<?php

// Settings to make all errors more obvious during testing
error_reporting(-1);
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
date_default_timezone_set("UTC");

use There4\Slim\Test\WebTestCase;

use Slim\Slim;
use Slim\Views\Twig;

use Noodlehaus\Config;

session_cache_limiter(false);
session_start();

define("INC_ROOT", dirname(__DIR__));

require INC_ROOT . "/vendor/autoload.php";

// Initialize our own copy of the slim application
class LocalWebTestCase extends WebTestCase {
    public function getSlimInstance() {
        $app = new Slim([
            "mode" => "test",
            "view" => new Twig(),
            "templates.path" => INC_ROOT . "/app/views"
        ]);

        $app->configureMode($app->config("mode"), function () use ($app) {
            $app->config = Config::load(INC_ROOT . "/app/config/{$app->mode}.php");
        });

      // Include our core application file
      require "app/app.php";
      return $app;
    }
};

/* End of file bootstrap.php */
