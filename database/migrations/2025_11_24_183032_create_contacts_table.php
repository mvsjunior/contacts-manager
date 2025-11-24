<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id')
                  ->constrained('people')
                  ->onDelete('cascade');
            $table->string('country_code', 10);
            $table->string('number', 9);
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['country_code', 'number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
