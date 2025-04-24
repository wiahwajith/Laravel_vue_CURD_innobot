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
        Schema::create('user_data', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('user_id')
            //     ->constrained()
            //     ->onDelete('cascade')
            //     ->index();      //disabled based on requirements manage

            $table->string('name')->index();            // index for faster name search
            $table->string('email')->unique();          // unique constraint also creates index
            $table->string('phone_number')->nullable()->index(); // indexed for queries
            $table->text('address')->nullable();
            $table->integer('age')->nullable();     
            $table->string('profile_picture')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_data');
    }
};
