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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
        // new way: 
            // $table->foreignId('patient_mrn')->constrained()->onDelete('cascade');

        //OG way of foreign key
            // $table->unsignedBigInteger('mrn'); // Patient Note is for
            // $table->foreign('mrn')->references('mrn')->on('patients');

    //The Follows migration:
            // $table->foreignId('user_id')->constrained(); //FOLLOWER - stores user doing the following 
        //OG way of foreign key
            // $table->unsignedBigInteger('followeduser'); //User BEING followed.
            // $table->foreign('followeduser')->references('id')->on('users');
// ChatGPT recommendation: "When setting up a foreign key in Laravel migrations, the foreignId shorthand is designed to work seamlessly with the constrained() method and is often more concise. However, when you're referencing a column that is not the primary key of the referenced table, you might need to specify the column explicitly."
                        // "In your case, where you want to reference the account_number field in the patients table, you should explicitly specify the column name using the constrained method:"
        // ERROR MESSAGE:    
            // $table->foreignId('mrn')->constrained('patients', 'mrn')->onDelete('cascade');
        // SQLSTATE[HY000]: General error: 3780 Referencing column 'patient_mrn' and referenced column 'mrn' in foreign key constraint 'notes_patient_mrn_foreign' are incompatible. (Connection: mysql, SQL: alter table `notes` add constraint `notes_patient_mrn_foreign` foreign key (`patient_mrn`) references `patients` (`mrn`) on delete cascade) 
        
// LAST ATTEMPT ON Wed 1/24/2024 was as shown below. This created the notes table with a patient_id field but no foregin key was set up in the MySQL database
            // $table->foreignId('mrn')->constrained('patients', 'mrn')->onDelete('cascade');

// HP Elitebook 15' migration on R 1/25/2024, we decided to just run the standard foregin key to patients table on 'id'
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
    // As backup also directly store the pt MRN in the Notes table:        
            $table->string('pt_mrn')->nullable();  // 614171

            $table->string('fax_file_name')->nullable(); // Fax File Name: 20240119102015-309406-67411 || Fax Details ID: 1241330300
            $table->string('fax_details_id')->nullable(); // Fax Details ID: 1241330300
            
            $table->string('note_body')->nullable(); //Action Taken. 10 minutes.
            $table->integer('clinic_time')->default(1); // 10
            $table->time('time_in')->nullable(); //16:50:00
            $table->time('time_out')->nullable(); //17:00:08 probably converted to just 17:00:00

            $table->string('date_time_as_string')->nullable(); //01/10/2024 05:00:08 PM

            $table->dateTime('date_time')->nullable(); //01-10-2024 17:00:08

            $table->date('date_only')->nullable(); //01-10-2024

            $table->string('fax_image_link')->nullable(); // stores base64 link to fax pdf image.
//logs => move to separate logs table later.           
            $table->string('get_fax_inbox_log')->nullable();
            $table->string('retrieve_fax_attempt_log')->nullable();
            $table->string('retrieve_fax_result_log')->nullable();
        //Shouldn't need:        
            $table->string('fax_status')->nullable();
            $table->string('note_provider')->nullable(); // Ham, Kim or Hm, Kim etc.
            $table->string('patient_name')->nullable(); // ZZtest, Vern
            $table->string('patient_dob')->nullable();  // 01/01/1963
            //Error: Column already exists: 1060 Duplicate column name 'patient_mrn'
            
            $table->boolean('billing_status')->default(0); // 0 for billing eligible, 1 or already billed? 
            $table->string('billing_number')->nullable(); // identifier for billing group? 000008          

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
