<?php

// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// return new class extends Migration
// {
//     /**
//      * Run the migrations.
//      */
//     public function up(): void
//     {
//         Schema::table('notes', function (Blueprint $table) {
//             $table->unsignedBigInteger('account_number'); // Patient Note is for
//             $table->foreign('account_number')->references('mrn')->on('patients');
//         });
//     }

//     /**
//      * Reverse the migrations.
//      */
//     public function down(): void
//     {
//         Schema::table('notes', function (Blueprint $table) {
//             $table->dropColumn('account_number');
//         });
//     }
// };
