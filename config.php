<?php

define("DEV_MODE", (bool)"1");

define("CONF_REDIS_HOST", "redis");
define("CONF_REDIS_PORT", "6379");
define("CONF_REDIS_CHANNEL", "micx.pagebuilder.publish");


if (DEV_MODE === true) {
    define("CONF_REPO_PATH", "/opt/mock/repos");

} else {
    define("CONF_REPO_PATH", "/data");
}


