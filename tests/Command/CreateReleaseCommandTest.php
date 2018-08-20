<?php

namespace App\Tests\Command;

use App\Command\CreateReleaseCommand;
use App\Service\ChangelogManager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

class CreateReleaseCommandTest extends TestCase
{
    public function testExecute()
    {
        $command = new CreateReleaseCommand(new ChangelogManager());
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'unreleased' => './var/tests/CHANGELOG/unreleased',
            'changelog' => './var/tests/CHANGELOG.md',
        ]);
        $statusCode = $commandTester->getStatusCode();
        $this->assertSame(0, $statusCode);
    }
}
