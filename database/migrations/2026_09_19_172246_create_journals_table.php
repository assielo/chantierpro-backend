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
            Schema::create('journals', function (Blueprint $table) {
                $table->id();
                $table->foreignId('project_id')->constrained()->onDelete('cascade');
                $table->date('date');
                $table->string('weather')->nullable();
                $table->integer('team_count')->default(0);
                $table->text('progress_notes')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('journals');
    }
};