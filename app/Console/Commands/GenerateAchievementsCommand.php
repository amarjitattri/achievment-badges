<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateAchievementsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:achievement {name} {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new achievement class stub';

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
     * @return int
     */
    public function handle()
    {
        $stub = file_get_contents(app_path('Console/Commands/achievement.stub'));

        $find = array("{{CLASS}}", "{{TYPE}}");
        $replace   = array($this->argument('name'), $this->argument('type'));
        $stub = str_replace($find, $replace, $stub);
        $path = app_path('Achievements/Types/' . $this->argument('name').'.php');

        file_put_contents($path, $stub);

        $this->info($path. ' was created');
    }
}
