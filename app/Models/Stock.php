<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = ['project_id', 'name', 'quantity', 'unit', 'alert_threshold'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}