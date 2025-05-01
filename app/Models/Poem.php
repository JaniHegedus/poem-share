<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Poem extends Model
{
    protected $fillable = [
        'title',
        'body',
        'user_id',
        'is_public'
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }
    public function labels()
    {
        return $this->belongsToMany(Label::class);
    }

}
