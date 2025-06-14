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
        Schema::table('users', function(Blueprint $table){
			
			
			$table->string ('sex')->nullable();
			$table->string ('firstname')->nullable();
			$table->string ('lastname')->nullable();
			$table->string ('country')->nullable();
			$table->date ('birthdate')->nullable();
			$table->string ('tel')->nullable();
			$table->string ('address')->nullable();
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('users',function(Blueprint $table){
		   
		   $table->dropColumn([
				
				 'sex',
				 'firstname',
				 'lastname',
				 'country',
				 'birthdate',
				 'tel',
				 'address'
		   ]);
		   
	   });
    }
};
