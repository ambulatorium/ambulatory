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
    protected $signature = 'reliqui:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all of the reliqui resources';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->comment('Publishing Reliqui Assets...');
        $this->callSilent('vendor:publish', ['--tag' => 'reliqui-assets']);

        $this->comment('Publishing Reliqui Configuration...');
        $this->callSilent('vendor:publish', ['--tag' => 'reliqui-config']);

        $this->info('Reliqui was installed successfully.');
    }
}
