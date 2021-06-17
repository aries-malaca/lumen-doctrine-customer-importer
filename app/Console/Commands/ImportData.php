<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Classes\Importer;

class ImportData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports multiple user from the third-party provider.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Will ask user to input how many customers to be imported.
        do{
            $count = $this->ask('How many customers do you want to import? (Min. value: 100)');
        }
        while((int)$count < Importer::getMinimum());
        
        $importer = new Importer($count);
        $result = $importer->startImport();
        
        $this->info($result->message);
    }
}
