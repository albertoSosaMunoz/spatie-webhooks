<?php

namespace App\Console\Commands;

use App\Http\Controllers\PruebasShopify;
use Illuminate\Console\Command;

class asanaTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:asanaTask';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        PruebasShopify::generate_asana_tasks();
        return 0;
    }
}
