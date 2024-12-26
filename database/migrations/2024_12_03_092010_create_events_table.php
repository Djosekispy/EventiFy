<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
     *
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title');
            $table->enum('event_type',['online','presencial'])->default('presencial');
            $table->string('location');
            $table->text('description');
            $table->text('payment_info');
            $table->string('banner_image');
            $table->integer('vacancies');
            $table->foreignId('category_id')
            ->constrained('categories','id')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreignId('user_id')
            ->constrained('users','id')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
