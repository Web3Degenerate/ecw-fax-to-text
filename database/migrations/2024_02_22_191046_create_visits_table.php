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
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            // $table->foreignId('clinic_id')->constrained()->onDelete('cascade');
//See" https://stackoverflow.com/questions/27010263/create-multiple-foreign-keys-on-the-same-table-in-migrate-laravel
            // $table->unsignedBigInteger('clinic_id'); //or unsignedInteger as in Stack example
            // $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('cascade');
            $table->date('em_date');
            $table->integer('provider_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
