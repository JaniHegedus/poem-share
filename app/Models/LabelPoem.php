<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabelPoem extends Model
{
    protected $table = 'label_poems';
    protected $fillable = [
        'label_id',
        'poem_id',
    ];
}
