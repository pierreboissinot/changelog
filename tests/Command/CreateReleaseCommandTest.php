<?php

namespace App\Tests\Command;

use App\Command\CreateReleaseCommand;
use App\Service\ChangelogManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class CreateReleaseCommandTest extends KernelTestCase
{
    public function testExecute()
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);
        
        $application->add(new CreateReleaseCommand(new ChangelogManager()));
        
        $command = $application->find('changelog:create-release');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command' => $command->getName(),
            'unreleased' => './var/CHANGELOG/unreleased',
            'changelog' => './var/CHANGELOG/CHANGELOG.md',
        ]);
        $statusCode = $commandTester->getStatusCode();
        $this->assertEquals(0, $statusCode);
    }
}
