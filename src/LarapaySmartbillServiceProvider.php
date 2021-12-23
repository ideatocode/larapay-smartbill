<?php

namespace IdeaToCode\LarapaySmartbill;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use IdeaToCode\LarapaySmartbill\Commands\LarapaySmartbillCommand;

class LarapaySmartbillServiceProvider extends PackageServiceProvider
{
    public function packageRegistered()
    {
        $this->app->register(EventServiceProvider::class);
    }
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('larapay-smartbill')
            ->hasConfigFile('larapay-smartbill')
            ->hasViews()
            ->hasMigration('create_larapay-smartbill_table')
            ->hasCommand(LarapaySmartbillCommand::class);
    }
}
