<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnimChickRaceChicks extends Model
{
    /**
     * The name of table.
     *
     * @var string
     */
    protected $table = 'anim_chick_race_chicks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'chick_race_activity_id',
        'name_player',
        'name_chick',
        'color',
        'position_x',
        'position_y'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'position_x' => 'integer',
        'position_y' => 'integer',
    ];

    /**
     * Get the activity of the code.
     *
     * @return BelongsTo
     */
    public function activity(): BelongsTo
    {
        return $this->belongsTo(AnimChickRaceActivity::class, 'chick_race_activity_id');
    }
}
