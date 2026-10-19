<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserve extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'title',
        'description',
        'location_on_site',
        'status',
        'metadata',
        'photo_url',
    ];

    protected $casts = [
        'metadata' => 'array', // Convertit automatiquement le JSONB en tableau associatif PHP
    ];

    // Relation : Une réserve appartient à un projet
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}