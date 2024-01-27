<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations. // MAKE referring_provider nullable. Later figure out how to make fluid
     */
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Patient Name: ZZtest, Vern
            $table->string('mrn')->unique(); // Account No:
            $table->string('dob')->nullable();    // pull from DOB: 01/01/1963
            $table->string('referring_provider');    // time stamp name from fax 'Bates, Vernice'
            $table->date('billing_index_start_date')->nullable(); // 1/10/2024 || 1/31/2024 to 2/6/2024
            $table->date('billing_index_end_date')->nullable(); // 1/10/2024 || 1/31/2024 to 2/6/2024
            $table->string('billing_index_start_number')->nullable();  // 31 - convert to # day in year 31 to 37th day of year (2/6/24)
            $table->string('billing_index_end_number')->nullable();    // 37
//Added time on user on HP Elitebook 15' - (R 1/25/2024) ~4pm
//If desired, run separate migration on patient table on other machines for 'clinic_time_counter'
            $table->string('clinic_time_counter')->nullable(); //quick & dirty time counter.
            $table->string('unique_days')->nullable();      // 0 - 7
            $table->boolean('status')->default(0); // 0 active, 1 for disenrolled?
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
