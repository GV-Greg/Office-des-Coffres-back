<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AnimChickRaceActivity extends Model
{
    /**
     * The name of table.
     *
     * @var string
     */
    protected $table = 'anim_chick_race_activity';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'creator_id',
        'status',
    ];

    /**
     * Get the creator of the chicks race activity.
     *
     * @return BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * Get the codes associate with the chicks race activity.
     *
     * @return HasMany
     */
    public function chicks(): HasMany
    {
        return $this->hasMany(AnimChickRaceChicks::class, 'chick_race_activity_id');
    }
}
