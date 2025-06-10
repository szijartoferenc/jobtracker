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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('company');
            $table->string('position')->nullable();
            $table->date('applied_at')->nullable(); // Dátum, mikor jelentkezett
            $table->string('status')->default('Jelentkezve'); // Státusz: pl. Interjú, Elutasítva, stb.

            $table->text('notes')->nullable(); // Jegyzet
            $table->boolean('redflag')->default(false); // Redflag cégekhez

            $table->string('cv_path')->nullable(); // Önéletrajz fájlútvonal
            $table->string('cover_letter_path')->nullable(); // Motivációs levél

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
