<?php
namespace App;

use Brace\Command\CommandModule;
use Brace\Core\AppLoader;
use Brace\Core\BraceApp;
use Brace\Dbg\BraceDbg;
use Brace\Mod\Request\Zend\BraceRequestLaminasModule;
use Brace\Router\RouterModule;
use Brace\Router\Type\RouteParams;
use Lack\Subscription\Brace\SubscriptionClientModule;
use Lack\Subscription\Type\T_Subscription;
use Micx\FormMailer\Config\Config;
use Micx\PageBuilder\Type\RepoConf;
use Phore\Di\Container\Producer\DiService;
use Phore\Di\Container\Producer\DiValue;
use Phore\VCS\VcsFactory;
use Psr\Http\Message\ServerRequestInterface;


BraceDbg::SetupEnvironment(true, ["192.168.178.20", "localhost", "localhost:5000", "pagebuilder.leuffen.de"]);


AppLoader::extend(function () {
    $app = new BraceApp();
    $app->addModule(new CommandModule());

    $app->define("redis", new DiService(function () {
        $redis = new \Redis();
        $redis->connect(CONF_REDIS_HOST, CONF_REDIS_PORT);
        $redis->ping();
        return $redis;
    }));

    $app->define("app", new DiValue($app));

    return $app;
});
