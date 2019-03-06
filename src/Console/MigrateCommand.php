<?php

namespace Reliqui\Ambulatory\Console;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Reliqui\Ambulatory\ReliquiUsers;
use Illuminate\Support\Facades\Schema;

class MigrateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reliqui:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run database migrations for Reliqui';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $shouldCreateNewUser =
            ! Schema::connection(config('reliqui.database_connection'))->hasTable('reliqui_users') ||
            ! ReliquiUsers::count();

        $this->call('migrate', [
            '--database' => config('reliqui.database_connection'),
            '--path' => 'vendor/reliqui/ambulatory/src/Migrations',
        ]);

        if ($shouldCreateNewUser) {
            ReliquiUsers::create([
               'id'       => (string) Str::uuid(),
               'name'     => 'James Bell',
               'email'    => 'admin@mail.com',
               'type'     => 3,
               'password' => Hash::make($password = Str::random()),
            ]);

            $this->line('');
            $this->line('Reliqui is ready for use');
            $this->line('You may log in using <info>admin@mail.com</info> and password: <info>'.$password.'</info>');
        }
    }
}
