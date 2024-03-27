<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Film extends Model
{
    use HasFactory;

    protected $fillable = [
            'title',
            'description',
            'release_year',
            'language_id',
            'original_language_id',
            'rental_duration',
            'rental_rate',
            'length',
            'replacement_cost',
            'rating',
            'special_features'
        ];

        public function languages(){
            return $this->BelongsTo('App\Models\Language');
        }

        public function actors():BelongsToMany{
            return $this->belongsToMany(Actor::class);
        }

        public function critics():HasMany{
            return $this->hasMany('App\Models\Critic');
        }
        
}
