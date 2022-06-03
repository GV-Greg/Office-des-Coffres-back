<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnimRewardsList extends Model
{
    /**
     * The name of table.
     *
     * @var string
     */
    protected $table = 'anim_rewards_lists';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'grid_id',
        'name',
        'player_id',
        'is_taken',
    ];

    public $timestamps = false;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_taken' => 'boolean',
    ];

    /**
     * Get the grid that owns the list.
     *
     * @return BelongsTo
     */
    public function grid(): BelongsTo
    {
        return $this->belongsTo(AnimRewardsGrid::class, 'grid_id');
    }

    /**
     * Get the creator of the grid.
     *
     * @return BelongsTo
     */
    public function player(): BelongsTo
    {
        return $this->belongsTo(User::class, 'player_id');
    }
}
