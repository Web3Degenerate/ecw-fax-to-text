<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Types available: https://laravel.com/docs/5.6/migrations#creating-columns
     * base 64 pdf link is about 40,400 characters. 
     * Both TEXT and VARCHAR (string) have max character limit of 65,535. VARCHAR can be indexed: https://stackoverflow.com/questions/25300821/difference-between-varchar-and-text-in-mysql
     * mediumText = 16 million characters. longText = 4.2 Billion characters (4GB).
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); //video 25 (12:20) - laravel knows User table from user_id
            $table->string('title'); // Fax File Name: 20240119102015-309406-67411 || Fax Details ID: 1241330300
            $table->mediumText('body'); //Action Taken. 10 minutes.
            $table->integer('clinic_time')->default(0); // 10
            $table->time('time_in')->nullable(); //16:50:00
            $table->time('time_out')->nullable(); //17:00:08 probably converted to just 17:00:00
            $table->string('date_time_as_string')->nullable(); //01/10/2024 05:00:08 PM
            $table->dateTime('date_time')->nullable(); //01-10-2024 17:00:08
            $table->date('date_only')->nullable(); //01-10-2024
            $table->string('note_provider')->nullable(); // Ham, Kim or Hm, Kim etc.
            $table->boolean('billing_status')->default(0); // 0 for billing eligible, 1 or already billed? 
            $table->string('billing_number')->nullable(); // identifier for billing group? 000008
            $table->string('fax_image_link')->nullable(); // stores base64 link to fax pdf image.
            $table->string('fax_details_id')->nullable(); // Fax Details ID: 1241330300
            $table->string('patient_name')->nullable(); // ZZtest, Vern
            $table->string('patient_dob')->nullable();  // 01/01/1963
            $table->string('patient_mrn')->nullable();  // 614171
            //$table->foreignId('follows_id')->constrained()->onDelete('cascade'); // provider ??
            //$table->foreignId('billings_id')->constrained()->onDelete('cascade'); // billings table ??
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
