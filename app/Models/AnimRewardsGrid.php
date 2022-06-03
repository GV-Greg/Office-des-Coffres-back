<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AnimRewardsGrid extends Model
{
    /**
     * The name of table.
     *
     * @var string
     */
    protected $table = 'anim_rewards_grids';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'creator_id',
        'width',
        'height',
        'status'
    ];

    /**
     * Get the creator of the grid.
     *
     * @return BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * Get the rewards list associate with the grid.
     *
     * @return HasMany
     */
    public function rewards(): HasMany
    {
        return $this->hasMany(AnimRewardsList::class, 'grid_id');
    }
}
