<?php

namespace Ambulatory\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ambulatory:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all of the Ambulatory resources';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->comment('Publishing Ambulatory Assets...');
        $this->callSilent('vendor:publish', ['--tag' => 'ambulatory-assets']);

        $this->comment('Publishing Ambulatory Configuration...');
        $this->callSilent('vendor:publish', ['--tag' => 'ambulatory-config']);

        $this->info('Ambulatory was installed successfully.');
    }
}
