<?php

namespace Ambulatory\Ambulatory\Console;

use Illuminate\Support\Str;
use Ambulatory\Ambulatory\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class MigrateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ambulatory:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run database migrations for ambulatory';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $shouldCreateNewUser =
            ! Schema::connection(config('ambulatory.database_connection'))->hasTable('ambulatory_users') ||
            ! User::count();

        $this->call('migrate', [
            '--database' => config('ambulatory.database_connection'),
            '--path' => 'vendor/ambulatory/ambulatory/src/Migrations',
        ]);

        if ($shouldCreateNewUser) {
            User::create([
               'id'       => (string) Str::uuid(),
               'name'     => 'John Doe',
               'email'    => 'admin@mail.com',
               'type'     => User::ADMIN,
               'password' => Hash::make($password = Str::random()),
            ]);

            $this->line('');
            $this->line('Database migrations installed successfully.');
            $this->line('You may log in using <info>admin@mail.com</info> and password: <info>'.$password.'</info>');
        }
    }
}
