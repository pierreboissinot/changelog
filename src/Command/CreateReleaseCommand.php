<?php

namespace App\Command;

use App\Service\ChangelogManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateReleaseCommand extends Command
{
    /**
     * @var ChangelogManager
     */
    private $changelogManager;

    public function __construct(ChangelogManager $changelogManager)
    {
        parent::__construct();
        $this->changelogManager = $changelogManager;
    }

    protected function configure()
    {
        $this
            ->setName('changelog:create-release')
            ->setDescription('Creates a new release in CHANGELOG from content of your partial changelogs')
            ->setDefinition([
                new InputArgument('unreleased', InputArgument::OPTIONAL, 'The path to unreleased changelogs', './CHANGELOG/unreleased'),
                new InputArgument('changelog', InputArgument::OPTIONAL, 'The path to changelog', './CHANGELOG.md'),
            ])
            ->setHelp(<<<EOF
The <info>%command.name%</info> command looks for unreleased changelogs in CHANGELOG/unreleased
directory and add these changelog entries in a new release into CHANGELOG file
EOF
);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->changelogManager->createRelease($input->getArgument('changelog'), $input->getArgument('unreleased'));
    }
}
