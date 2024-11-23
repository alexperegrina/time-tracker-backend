<?php

use Symfony\Component\Dotenv\Dotenv;
use Doctrine\Deprecations\Deprecation;

require dirname(__DIR__).'/vendor/autoload.php';

if (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');
}

if ($_SERVER['APP_DEBUG']) {
    umask(0000);
}

//// ensure a fresh cache when debug mode is disabled
//(new \Symfony\Component\Filesystem\Filesystem())->remove(__DIR__.'/../var/cache/test');

// Ignore unfixable Doctrine deprecations
Deprecation::ignoreDeprecations(
    'https://github.com/doctrine/orm/pull/11211', // The ORM changed from arrays to named data objects in 3.x, some packages still use array access for B/C
);