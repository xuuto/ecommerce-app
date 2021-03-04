<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Brand;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        // \App\Models\User::factory(10)->create();
//        Admin::factory()->create();
//        // Setting::factory()->create();
//        $this->call([
//            SettingsSeeder::class
//        ]);
//        $this->call(CategoriesTableSeeder::class);
        $this->call(Adminseeder::class);
        $this->call(SettingsSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(AttributeTableSeeder::class);
        $this->call(AttributeValuesTableSeeder::class);
    }
}
