<?php

require __DIR__.'/vendor/autoload.php';

use App\Command\CreateReleaseCommand;
use App\Service\ChangelogManager;
use Symfony\Component\Console\Application;

$application = new Application('Changelog helper');

$application->add(new CreateReleaseCommand(new ChangelogManager()));
$application->run();
