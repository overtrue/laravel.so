<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        $this->call('UsersTableSeeder');
        $this->call('TricksTableSeeder');
        $this->call('CategoriesTableSeeder');
        $this->call('TagsTableSeeder');

        Model::reguard();
    }
}
