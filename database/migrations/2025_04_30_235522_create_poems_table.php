<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('poems', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('body');
            $table->foreignId('user_id');
            $table->timestamps();
            $table->boolean('is_public')->default(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('poems');
    }
};
