<?php

namespace App\Console\Commands;

use App\Http\Controllers\ShopifyPruebas;
use Illuminate\Console\Command;

class pruebasShopify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:pruebasshopify';

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
        ShopifyPruebas::run();
        return 0;
    }
}
