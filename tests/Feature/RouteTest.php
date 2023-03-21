<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class RouteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRoutes()
    {
        $appURL = env('APP_URL');

        $routes = Route::getRoutes();
        $routeFilter = [];
        foreach ($routes as $route) {
            if (strstr($route->uri(), "datatable")) {
                array_push($routeFilter, $route->uri());
            }
        }

        echo  PHP_EOL;
        $routeFailure = [];
        foreach ($routeFilter as $url) {
            $response = $this->get($url);
            if ((int)$response->status() !== 200) {
                echo  $appURL . $url . ' (FAILED) did not return a 200.';
                $this->assertTrue(false);
                array_push($routeFailure,$url);
            } else {
                echo $appURL . $url . ' (success ?)';
                $this->assertTrue(true);
            }
            echo  PHP_EOL;
        }
        print_r($routeFailure);
    }
}
