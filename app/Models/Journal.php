<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Journal extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'date', 'weather', 'team_count', 'progress_notes'];

    // Un journal appartient à un projet
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}