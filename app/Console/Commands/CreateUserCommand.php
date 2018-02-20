<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {login} {pass}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Created user';

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
        $login = $this->argument('login');
        $pass = $this->argument('pass');
        $user = new \App\User();
        $user->password = Hash::make($pass);
        $user->login = $login;
        $user->save();
    }
}
