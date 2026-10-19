<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'location', 'start_date', 'end_date', 'status'];

    // Un projet possède plusieurs journaux de chantier
    public function journals()
    {
        return $this->hasMany(Journal::class);
    }
}