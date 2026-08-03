<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

#[Signature('app:test-migration')]
#[Description('Перенос данных из старой базы')]
class TestMigration extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Старт тестового переноса больниц... ');

        $oldHospitals = DB::connection('mysql_old')
            ->table('hospital')
            ->get();

        if ($oldHospitals->isEmpty()) {
            $this->error('Старая таблица пуста или указано неверное имя таблицы!');
            return 1;
        }

        $migratedCount = 0;

        foreach ($oldHospitals as $old) {
            $exists = DB::table('hospitals')
                ->where('old', $old->id)
                ->exists();

            if ($exists) {
                $this->line("Больница ID {$old->id} уже перенесена, пропускаем.");
                continue;
            }

            DB::table('hospitals')->insert([
                'old' => $old->id,
                'name' => $old->name,
                'full_name' => $old->full_name,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $migratedCount++;
        }

        $this->info("Тест успешно завершен! Перенесено новых больниц: {$migratedCount}");
        return 0;
    }
}
