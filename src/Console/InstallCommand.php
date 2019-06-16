<?php

namespace Reliqui\Ambulatory\Console;

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
    protected $description = 'Install all of the reliqui ambulatory resources';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->comment('Publishing Reliqui Ambulatory Assets...');
        $this->callSilent('vendor:publish', ['--tag' => 'ambulatory-assets']);

        $this->comment('Publishing Reliqui Ambulatory Configuration...');
        $this->callSilent('vendor:publish', ['--tag' => 'ambulatory-config']);

        $this->info('Reliqui ambulatory was installed successfully.');
    }
}
