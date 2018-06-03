<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
/*$loader->registerNamespaces(array(
		'SetAsign\Tools' => __DIR__ . '/../../vendor/setasign/fpdf/',
    ));*/
/*$loader->registerNamespaces(array(
		'MPDF' => __DIR__ . '/../../vendor/setasign/fpdf/',
    ));*/
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


