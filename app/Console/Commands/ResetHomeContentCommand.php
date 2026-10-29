<?php

namespace App\Console\Commands;

use App\Support\HomeContent;
use Illuminate\Console\Command;

class ResetHomeContentCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'app:reset-home-content';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset the stored landing page content back to the schema defaults';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        HomeContent::store(HomeContent::defaults());

        $this->info('Landing page content has been reset to the defaults.');

        return self::SUCCESS;
    }
}
