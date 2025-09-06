<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AdressSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('provinces')->truncate();
        DB::table('districts')->truncate();
        DB::table('wards')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $provincesData = json_decode(File::get("database/locations/provinces.json"), true);
        foreach ($provincesData as $code => $province) {
            DB::table('provinces')->insert([
                'code' => $province['code'],
                'name' => $province['name'],
                'slug' => $province['slug'],
                'type' => $province['type'],
                'name_with_type' => $province['name_with_type'],
            ]);
        }

        $districtsData = json_decode(File::get("database/locations/districts.json"), true);
        foreach ($districtsData as $code => $district) {
             DB::table('districts')->insert([
                'code' => $district['code'],
                'name' => $district['name'],
                'type' => $district['type'],
                'name_with_type' => $district['name_with_type'],
                'path_with_type' => $district['path_with_type'],
                'parent_code' => $district['parent_code'],
            ]);
        }

        $wardsData = json_decode(File::get("database/locations/wards.json"), true);
        foreach ($wardsData as $code => $ward) {
             DB::table('wards')->insert([
                'code' => $ward['code'],
                'name' => $ward['name'],
                'type' => $ward['type'],
                'name_with_type' => $ward['name_with_type'],
                'path_with_type' => $ward['path_with_type'],
                'parent_code' => $ward['parent_code'],
            ]);
        }
    }
}
