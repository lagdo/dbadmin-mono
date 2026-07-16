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
use function in_array;
use function Jaxon\jaxon;
use function Jaxon\storage;
use function strlen;
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
     * @var array
     */
    private array $sources = ['app', 'editor', 'jaxon', 'ui-builder'];

    /**
     */
    public function __construct()
    {
        $this->io = new CLImate();

        $this->command = new Command();
        // Define a flag "-s" a.k.a. "--source"
        $this->command->setHelp('Install the static files in the assets dir.')
            ->option('c')
            ->aka('config')
            ->describedAs('The Jaxon config file')
            ->must(fn(string $path) => file_exists($path))
            ->map($this->config(...))
            ->require()
            ->option('s')
            ->aka('source')
            ->describedAs('The source dir')
            ->must(fn(string $source) => in_array($source, $this->sources))
            ->require()
            ->option('a')
            ->aka('assets')
            ->describedAs('The assets dir')
            ->map(fn(string $assets) => storage()->get($assets))
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
        $storage = $this->command['assets'];

        $assetsSubdir = $this->command['source'];
        $assetsSource = dirname(__DIR__) . "/assets/$assetsSubdir";
        $offset = strlen($assetsSource);

        $itDir = new RecursiveDirectoryIterator($assetsSource);
        $itFile = new RecursiveIteratorIterator($itDir);
        foreach($itFile as $file)
        {
            $subdir = "$assetsSubdir/" . substr($file->getPath(), $offset);

            if($file->isDir())
            {
                $this->io->blue('>>> Copy directory: ' . $file->getPath());
                $storage->createDirectory($subdir);
                continue;
            }

            if(!$file->isFile() || !$file->isReadable())
            {
                $this->io->red('>>> Unknown file type: ' . $file->getFilename());
                continue;
            }

            $this->io->green('>>> Copy file: ' . $file->getFilename());
            $stream = fopen($file->getRealPath(), 'r');
            $storage->writeStream("$subdir/" . $file->getFilename(), $stream);
        }
    }
}
