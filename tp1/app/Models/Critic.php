<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Critic extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'film_id',
        'score',
        'comment',
    ];

    function films():BelongsTo{
        return $this->belongsTo('App\Models\Film');
    }
    function users():BelongsTo{
        return $this->belongsTo('App\Models\User');
    }
}
