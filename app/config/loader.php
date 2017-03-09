<?php

$loader = new \Phalcon\Loader();

require APP_PATH . "/vendor/autoload.php";

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    [
        $config->application->controllersDir,
        $config->application->modelsDir,
		$config->application->libraryDir
    ]
);

$loader->register();
