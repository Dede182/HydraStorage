<?php

namespace HydraStorage\HydraStorage\Commands;

use Illuminate\Console\Command;

class HydraStorageCommand extends Command
{
    public $signature = 'hydrastorage';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
