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
        Schema::create('ticketsessions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('session_title');
            $table->dateTime('realized_at', precision: 0);
            $table->time('start_at', precision: 0);
            $table->time('end_at', precision: 0);
            $table->foreignId('events_id')
            ->constrained('events','id')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticketsessions');
    }
};
