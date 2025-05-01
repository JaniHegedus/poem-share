<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    protected $table = 'labels';
    protected $fillable = ['name', 'label_id'];
    public function poems()
    {
        return $this->belongsToMany(Poem::class);
    }
}
