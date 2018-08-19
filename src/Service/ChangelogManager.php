<?php

namespace App\Service;

use Symfony\Component\Finder\Finder;

class ChangelogManager
{
    public function createRelease(string $changelogPath, string $unreleasedPath)
    {
        $input = new \ChangeLog\IO\File([
            'file' => $changelogPath,
        ]);

        $parser = new \ChangeLog\Parser\KeepAChangeLog();

        $cl = new \ChangeLog\ChangeLog();
        $cl->setParser($parser);
        $cl->setInput($input);

        $changelog = $cl->parse();
        $files = $this->findFiles($unreleasedPath);
        foreach ($files as $file) {
            $input = new \ChangeLog\IO\File([
                'file' => $file,
            ]);

            $parser = new \ChangeLog\Parser\KeepAChangeLog();

            $cl = new \ChangeLog\ChangeLog();
            $cl->setParser($parser);
            $cl->setInput($input);

            $log = $cl->parse();
            $changelog->mergeLog($log);
        }
        $output = new \ChangeLog\IO\File([
            'file' => $changelogPath,
        ]);

        $renderer = new \ChangeLog\Renderer\KeepAChangeLog();

        $cl = new \ChangeLog\ChangeLog();
        $cl->setRenderer($renderer);
        $cl->setOutput($output);

        $cl->write($changelog);
    }

    private function findFiles(string $unreleasedPath)
    {
        $files = [];
        $finder = new Finder();
        $finder
            ->files()
            ->in($unreleasedPath);
        foreach ($finder as $file) {
            $files[] = $file->getPathname();
        }

        return $files;
    }
}
