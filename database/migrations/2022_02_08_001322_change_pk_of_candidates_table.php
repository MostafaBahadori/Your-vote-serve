<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePkOfCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('votes', function (Blueprint $table) {
            $table->dropConstrainedForeignId('candidate_id');
        });
        Schema::table('votes', function (Blueprint $table) {
            $table->foreignId('election_id')->references('id')->on('elections')->cascadeOnDelete();
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('candidate_id')->references('id')->on('users')->cascadeOnDelete();
            $table->primary(['user_id', 'election_id']);
        });
        
        Schema::table('candidates', function (Blueprint $table) {
            $table->dropColumn('id');
            $table->primary(['user_id', 'election_id']);
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
