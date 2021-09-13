<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::where('role', 0)->first();

        if ($admin) {
            $admin->delete();
        }

        $user = new User();
        $user->uuid = (string) Str::uuid();
        $user->name = 'Administrator';
        $user->username = 'admin';
        $user->password = bcrypt('adminPassword');
        $user->role = 0;
        $user->save();
    }
}
