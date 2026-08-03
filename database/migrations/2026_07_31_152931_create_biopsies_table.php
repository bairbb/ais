<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('biopsies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->nullable()->index()->constrained('patients');
            $table->foreignId('hospital_id')->nullable()->index()->constrained('hospitals');
            $table->foreignId('register_id')->nullable()->constrained('users');
            $table->text('clinic_diagnosis')->nullable();
            $table->string('mkb_code')->nullable();
            $table->integer('pieces_number')->nullable();
            $table->integer('pieces_quantity')->nullable();
            $table->date('incoming_date')->nullable();
            $table->foreignId('doctor_id')->nullable()->index()->constrained('users');
            $table->date('slice_date')->nullable();
            $table->date('answer_date')->nullable();
            $table->foreignId('answer_user_id')->nullable()->constrained('users');
            $table->text('diagnosis')->nullable();
            $table->string('answer_mkb_code')->nullable();
            $table->integer('difficulty')->nullable();
            $table->string('markings')->nullable();
            $table->text('macro_description')->nullable();
            $table->text('micro_description')->nullable();
            $table->string('type_bill')->nullable();
            // Составной индекс для моментальных годовых отчетов
            // (Поиск по дате поступления и врачу будет занимать 0.001 секунды)
            $table->index(['incoming_date', 'doctor_id']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biopsies');
    }
};
