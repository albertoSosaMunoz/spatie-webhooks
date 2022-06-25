<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\PruebasAsana;

class runPruebasAsana extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:pruebasAsana';

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
        PruebasAsana::run();
        return 0;
    }
}
