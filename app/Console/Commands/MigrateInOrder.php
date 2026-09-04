<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateInOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate_in_order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute the migrations in the order specified in the file app/Console/Comands/MigrateInOrder.php \n Drop all the table in db before execute the command.';

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
        /** Specify the names of the migrations files in the order you want to
         * loaded
         * $migrations =[
         *               'xxxx_xx_xx_000000_create_nameTable_table.php',
         *    ];
         */
        $migrations = [
            '2025_02_28_111830_create_user.php',
            '2025_02_28_112809_create_sessions_table.php',
            '2025_03_08_115341_create_category.php',
            '2025_03_08_115342_create_quizz.php',
            '2025_03_08_173200_create_cache_table.php'
        ];

        foreach($migrations as $migration)
        {
            $basePath = 'database/migrations/';
            $migrationName = trim($migration);
            $path = $basePath.$migrationName;
            $this->call('migrate:refresh', [
                '--path' => $path ,
            ]);
        }

        $this->info('La commande fonctionne correctement !');
    }
}
