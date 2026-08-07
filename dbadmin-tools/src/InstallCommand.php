<?php

namespace Lagdo\DbAdmin\Tools;

use Commando\Command;
use Jaxon\App\Config\ConfigManager;
use League\CLImate\CLImate;
use League\Flysystem\Filesystem;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

use function dirname;
use function fopen;
use function Jaxon\jaxon;
use function Jaxon\storage;
use function strlen;
use function str_starts_with;
use function substr;

class InstallCommand
{
    /**
     * @var CLImate
     */
    private CLImate $io;

    /**
     * @var Command
     */
    private Command $command;

    /**
     */
    public function __construct()
    {
        $this->io = new CLImate();

        $this->command = new Command();
        // Define a flag "-s" a.k.a. "--source"
        $this->command->setHelp('Install the static files in the public dir.')
            ->option('c')
            ->aka('config')
            ->describedAs('The Jaxon config file')
            ->must(fn(string $path) => file_exists($path))
            ->map($this->config(...))
            ->require()
            ->option('p')
            ->aka('public')
            ->describedAs('The public storage config option')
            ->map(fn(string $public) => storage()->get($public))
            ->require();
    }

    /**
     * @param string $path
     *
     * @return ConfigManager
     */
    private function config(string $path): ConfigManager
    {
        jaxon()->app()->setup($path);
        return jaxon()->config();
    }

    /**
     * @return void
     */
    public function run(): void
    {
        /** @var Filesystem */
        $public = $this->command['public'];

        $assetsSource = dirname(__DIR__) . '/assets';
        $offset = strlen($assetsSource);

        $itDir = new RecursiveDirectoryIterator($assetsSource);
        $itFile = new RecursiveIteratorIterator($itDir);
        foreach($itFile as $file)
        {
            $filename = $file->getFilename();

            // Ignore hidden files.
            if($file->isFile() && str_starts_with($filename, '.')) {
                continue;
            }

            $subdir = substr($file->getPath(), $offset);

            if($file->isDir()) {
                // The ".." dir can also appear here.
                if ($filename === '.' && $subdir !== '') {
                    $this->io->blue(">>> In directory: .$subdir.");
                    $public->createDirectory($subdir);
                }
                continue;
            }

            if(!$file->isFile() || !$file->isReadable()) {
                $this->io->red(">>> Incorrect file: $filename.");
                continue;
            }

            $this->io->green(">>> Copy file: .$subdir/$filename.");
            $stream = fopen($file->getRealPath(), 'r');
            $destFile = $subdir === '' ? $filename : "$subdir/$filename";
            $public->writeStream($destFile, $stream);
        }
    }
}
