<?php

namespace IdeaToCode\LarapaySmartbill\Commands;

use Illuminate\Console\Command;

class LarapaySmartbillCommand extends Command
{
    public $signature = 'larapay-smartbill';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
