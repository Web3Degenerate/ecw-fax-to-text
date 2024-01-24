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
        Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name'); //Vern ZZtest
        // $table->string('mrn')->unique();
        $table->string('username')->unique(); //USE AS MRN
        $table->date('dob');    // 1963-01-01
        // $table->string('dob');  // 01/01/1963 
        $table->string('referring_provider');    // provider name or 1 = bates, 2 = ajtai, 3 = mechtler
        $table->date('billing_index_start_date')->nullable(); // 1/10/2024 || 1/31/2024 to 2/6/2024
        $table->date('billing_index_end_date')->nullable(); // 1/10/2024 || 1/31/2024 to 2/6/2024
        $table->string('billing_index_start_number')->nullable();  // 31 - convert to # day in year 31 to 37th day of year (2/6/24)
        $table->string('billing_index_end_number')->nullable();    // 37
        $table->string('unique_days')->nullable();      // 0 - 7
        $table->boolean('status')->default(0); // 0 active, 1 for disenrolled?
            $table->string('avatar')->nullable(); //ignore
        $table->boolean('isAdmin')->default(0);   // use 1 for admin account for now
            $table->string('email')->unique();   // <mrn>@yourcareteam.com
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password'); //pcmpatient 
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
