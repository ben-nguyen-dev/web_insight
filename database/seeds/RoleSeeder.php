<?php

use App\Enum\RoleEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class RoleSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       DB::table('roles')->insert([
            [
               'id'   => 1,
               'name' => RoleEnum::ROLE_ADMIN,
               'created_at' => Carbon::now()
            ],
            [
               'id'  => 2,
               'name' => RoleEnum::ROLE_COMPANY_ADMIN,
               'created_at' => Carbon::now()
            ],
            [
               'id'  => 3,
               'name' => RoleEnum::ROLE_EDITOR,
               'created_at' => Carbon::now()
            ],
            [
                'id'  => 4,
                'name' => RoleEnum::ROLE_CONTRIBUTOR,
                'created_at' => Carbon::now()
            ],
            [
                'id'  => 5,
                'name' => RoleEnum::ROLE_USER,
                'created_at' => Carbon::now()
            ],
            [
               'id'  => 6,
               'name' => RoleEnum::ROLE_CONSULTANT,
               'created_at' => Carbon::now()
           ],
       ]);
    }
}
