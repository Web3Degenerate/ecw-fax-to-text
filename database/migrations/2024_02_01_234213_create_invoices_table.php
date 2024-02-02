<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Note on setting autoincrements to START at a certain number: https://laraveldaily.com/post/set-auto-increment-start-laravel-migrations
     * "$table->id()->startingValue(1200);"
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            //foreign id on Patient id?
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            
            //foreign id on Note id? Or does an Invoice hasMany Notes??
            $table->foreignId('note_id')->constrained()->onDelete('cascade');

            $table->integer('clinic_time'); // Example '2' for number of minutes spent on individual note

            $table->dateTime('date_time'); // Example "01/31/2024 08:19 PM" as dateTime Object
            $table->string('date_time_as_string'); // Example "01/31/2024 11:53:17 PM" as string
            $table->time('time_in'); // Example "08:17 PM"
            $table->time('time_out'); // Example "08:19 PM"

            $table->date('date_only'); // Example "01/31/2024"
            $table->date('seven_days_from_date_only'); // Example "02/06/2023"


            $table->string('mrn'); // patient unique medical records number ("mrn")
            $table->string('name'); // patient name
            $table->string('billing_doctor_provider'); // Doctor who created the note.

            $table->string('status')->nullable(); // I was thinking about using three statuses: pending, complete or incomplete
            $table->string('billing_group_number')->nullable(); // I was thinking about grouping potentially multiple notes that should be included in a seven day period

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
