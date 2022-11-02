<?php
namespace App;


use Brace\Core\AppLoader;
use Brace\Core\BraceApp;
use Micx\FormMailer\Stats\FileStatsRunner;
use Rudl\LibGitDb\RudlGitDbClient;

class Proccer {
    public function procRedis($redis, $chan, $msg) {
        out("message in:", $msg);

    }
}

AppLoader::extend(function (BraceApp $app) {


    $app->command->addCommand("wait", function(array $argv, \Redis $redis) {
        $redis->setOption(\Redis:: OPT_READ_TIMEOUT, -1);
        out("waiting");
        $redis->subscribe([CONF_REDIS_CHANNEL], function($redis, $chan, $msg) {
            $sourceDir = CONF_REPO_PATH . "/" . $msg . "/docs";
            $target = "/var/www/" . $msg;
            phore_exec("jekyll build -s :source -d :dest ", [
                "source" => $sourceDir,
                "dest" => $target
            ]);
            out("build successful: $sourceDir > $target");
        });
    });

    $app->command->addCommand("test", function(\Redis $redis) {
        $redis->publish(CONF_REDIS_CHANNEL, "demo1-weba");
        out($redis->pubsub("channels"));
        out($redis->pubsub("numpat"));
    });

    // Send yesterdays report at 00:05:00 (specified by 1)

});
