<?php

require_once __DIR__.'/../vendor/autoload.php';

(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
    dirname(__DIR__)
))->bootstrap();

date_default_timezone_set(env('APP_TIMEZONE', 'UTC'));

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/
$app = new \Dusterio\LumenPassport\Lumen7Application(
    dirname(__DIR__)
);

$facades = [
    '\Venoudev\Results\Facades\ResultManagerFacade' =>  'ResultManager',
    'Illuminate\Support\Facades\App' => 'App',
    'Illuminate\Support\Facades\Storage' => 'Storage'
];

$app->withFacades(true ,$facades);
$app->withEloquent();

$app->bind('path.public', function() {
    return __DIR__ . 'public/';
});


/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);


/*
|--------------------------------------------------------------------------
| Register Config Files
|--------------------------------------------------------------------------
|
| Now we will register the "app" configuration file. If the file exists in
| your configuration directory it will be loaded; otherwise, we'll load
| the default version. You may register other files below as needed.
|
*/

$app->configure('app');

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

// $app->middleware([
//     App\Http\Middleware\ExampleMiddleware::class
// ]);

$app->routeMiddleware([
    'auth'       => App\Http\Middleware\Authenticate::class,
    'permission' => Spatie\Permission\Middlewares\PermissionMiddleware::class,
    'role'       => Spatie\Permission\Middlewares\RoleMiddleware::class,
    'role_or_permission' => \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class,
    'cliente_credentials' => Laravel\Passport\Http\Middleware\CheckClientCredentials::class,
]);


/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

$app->register(App\Providers\AppServiceProvider::class);
$app->register(App\Providers\AuthServiceProvider::class);
// $app->register(App\Providers\EventServiceProvider::class);

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__.'/../routes/api.php';
});

/*
| Personal Components
*/

/**
* Lumen Generator
*/
$app->register(Flipbox\LumenGenerator\LumenGeneratorServiceProvider::class);

/**
* Services Provider
*/
$app->register(App\Providers\SourcesServiceProvider::class);

/**
* Soft Deletes Cascade
*/

$app->register(Askedio\SoftCascade\Providers\LumenServiceProvider::class);


/**
* Venoudev Results
*/

$app->register(Venoudev\Results\Providers\LumenResultsServiceProvider::class);



/**
* Spatie Permissions
*/
$app->configure('permission');
$app->alias('cache', \Illuminate\Cache\CacheManager::class);  // if you don't have this already
$app->register(Spatie\Permission\PermissionServiceProvider::class);


/**
* Lumen Passport
*/
$app->register(Laravel\Passport\PassportServiceProvider::class);
$app->register(Dusterio\LumenPassport\PassportServiceProvider::class);
$app->configure('auth');

/**
 * FileSystems
 */

$app->singleton(
    Illuminate\Contracts\Filesystem\Factory::class,
    function ($app) {
    return new Illuminate\Filesystem\FilesystemManager($app);
});
$app->register(Illuminate\Filesystem\FilesystemServiceProvider::class);
$app->configure('filesystems');

/**
 * Swoole
 */

 $app->register(SwooleTW\Http\LumenServiceProvider::class);

return $app;
