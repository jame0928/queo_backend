<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {   
        $this->call(UserSeeder::class);
        
        /**
         * Company with employees seeder
         */
        \App\Models\Company::factory()->count(10)
        ->has(\App\Models\Employee::factory()->count(5))
        ->create();
    }
}
