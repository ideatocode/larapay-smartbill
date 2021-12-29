<?php

namespace IdeaToCode\LarapaySmartbill;

use AlexEftimie\LaravelPayments\Contracts\InvoiceManager;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Ideatocode\BladeStacksPusher\Facades\BSP;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use IdeaToCode\LarapaySmartbill\Commands\LarapaySmartbillCommand;
use IdeaToCode\LarapaySmartbill\Components\Tooltip;
use IdeaToCode\LarapaySmartbill\Http\Livewire\TeamBilling;

class LarapaySmartbillServiceProvider extends PackageServiceProvider
{
    public function packageBooted()
    {
        Livewire::component('team-billing', TeamBilling::class);
        // BSP::push('team-settings::after:update-team-name-form', view('vendor.larapay-smartbill.team-settings'));
    }
    public function packageRegistered()
    {
        $this->app->bind(InvoiceManager::class, LarapaySmartbill::class);
        $this->app->bind('larapay-smartbill', function ($app) {
            return new LarapaySmartbill();
        });


        $this->app->register(EventServiceProvider::class);
        BSP::push('team-settings:after-name', function () {
            return view('larapay-smartbill::team-billing', [
                'team' => auth()->user()->currentTeam,
            ])->render();
        });
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
            ->hasRoute('web')
            ->hasConfigFile('larapay-smartbill')
            ->hasViews()
            ->hasMigration('create_larapay-smartbill_table')
            ->hasCommand(LarapaySmartbillCommand::class)
            ->hasViewComponent('lsb', Tooltip::class);
    }
}
