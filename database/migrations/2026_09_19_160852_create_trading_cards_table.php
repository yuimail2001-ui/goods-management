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
        Schema::create('trading_cards', function (Blueprint $table) {
            $table->id();
            $table->string('card_code')->unique();
            $table->string('member_name');
            $table->foreignId('tour_id')->constrained('tours')->cascadeOnDelete();
            $table->string('possession_status')->default('not_owned');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trading_cards');
    }
};
