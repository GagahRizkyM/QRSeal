<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

class InitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Init database and seed data';


    // option

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('key:generate');
        // drop all table
        $this->call('migrate:reset');
        $this->call('migrate:fresh');
        $this->call('db:seed');
        // todo: clear image product

        // end todo
        $this->call('cache:clear');
        $this->call('config:clear');
        $this->call('view:clear');
        $this->call('optimize:clear');
        $this->call('route:clear');
        $this->call('route:cache');
        $this->call('event:clear');
        $this->call('storage:link');


    }
}
