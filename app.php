#!/usr/bin/env php
<?php

declare(strict_types=1);

use App\Command\ResolveCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Dotenv\Dotenv;

require __DIR__.'/vendor/autoload.php';

// Load cached env vars if the .env.local.php file exists
// Run "composer dump-env prod" to create it (requires symfony/flex >=1.2)
if (!class_exists(Dotenv::class)) {
    throw new RuntimeException(
        'Please run "composer require symfony/dotenv" to load the ".env" files configuring the application.'
    );
}

// load all the .env files
(new Dotenv())->loadEnv(__DIR__.'/.env');
$application = new Application();

$application->add(new ResolveCommand());

$application->run();
