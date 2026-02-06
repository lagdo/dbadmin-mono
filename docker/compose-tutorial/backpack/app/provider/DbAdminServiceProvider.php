<?php

namespace App\Providers;

use Dotenv\Dotenv;
use Illuminate\Support\ServiceProvider;
use Lagdo\DbAdmin\Db\Config\AuthInterface;
use Lagdo\DbAdmin\Db\Config\UserFileReader;

use function auth;
use function dirname;
use function config_path;
use function is_file;
use function jaxon;

class DbAdminServiceProvider extends ServiceProvider
{
    /**
     * Get the DbAdmin config file path
     *
     * @return string
     */
    private function getDbAdminConfigFile(): string
    {
        // Get the path of first available config file.
        foreach (['json', 'yaml', 'yml', 'php'] as $ext) {
            $path = config_path("dbadmin.$ext");
            if (is_file($path)) {
                return $path;
            }
        }
        return '';
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Set the path to the user access config file.
        jaxon()->callback()->boot(fn() => jaxon()->di()
            ->g(UserFileReader::class)
            ->config($this->getDbAdminConfigFile()));

        // The authentication and config file need to be set in the Jaxon DI.
        $this->app->singleton(AuthInterface::class,
            fn() => new class implements AuthInterface {
                public function user(): string
                {
                    return auth('backpack')->user()->email ?? '';
                }
                public function role(): string
                {
                    return auth('backpack')->user()->role?->name ?? '';
                }
            });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Load the custom env file
        $path = dirname(__DIR__, 2);
        $dotenv = Dotenv::createImmutable($path, '.env.dbadmin');
        $dotenv->safeLoad();
    }
}
