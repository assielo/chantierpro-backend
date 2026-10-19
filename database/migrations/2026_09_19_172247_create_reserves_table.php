<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // On vérifie si la table n'existe pas déjà avant de la créer
        if (!Schema::hasTable('journals')) {
            Schema::create('reserves', function (Blueprint $table) {
    $table->id();
    $table->foreignId('project_id')->constrained()->onDelete('cascade');
    $table->string('title');
    $table->text('description')->nullable();
    $table->string('status')->default('Ouverte'); // Ouverte, En cours, Résolue
    $table->jsonb('photos')->nullable(); // Stockage des URLs de photos annotées
    $table->timestamps();
});
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('journals');
    }
};