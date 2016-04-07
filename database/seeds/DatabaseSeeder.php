<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Reading;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    protected $tables = [

        'readings',
        'prayers',
        'raw_jumuiyas',
        'jumuiyas',
        'reflections',
        'happening_events',
        'parishes',
        'stations'



    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->cleanDatabase();

        $this->call(UserTableSeeder::class);
        $this->call(ReadingsTableSeeder::class);
        $this->call(PrayerTypesTableSeeder::class);
        $this->call(PrayersTableSeeder::class);
        $this->call(HappeningEventsTableSeeder::class);
        $this->call(RawJumuiyasTableSeeder::class);
        $this->call(ReflectionsTableSeeder::class);
        $this->call(JumuiyasTableSeeder::class);
        $this->call(ParishesTableSeeder::class);
        $this->call(StationsTableSeeder::class);
        $this->call(UserParishesTableSeeder::class);
        $this->call(UserStationsTableSeeder::class);



    }

    private function cleanDatabase()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        foreach ($this->tables as $tableName)
        {
            DB::table($tableName)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
