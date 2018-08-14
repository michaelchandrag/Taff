<?php

$loader = new \Phalcon\Loader();

$loader->registerDirs(
    [
        $config->application->controllersDir,
        $config->application->modelsDir
    ]
);

$loader->registerFiles(
    [
        BASE_PATH.'/vendor/autoload.php'
    ]
);

$loader->register();


