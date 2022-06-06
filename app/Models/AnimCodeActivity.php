<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AnimCodeActivity extends Model
{
    /**
     * The name of table.
     *
     * @var string
     */
    protected $table = 'anim_code_activity';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'creator_id',
        'status'
    ];

    /**
     * Get the creator of the code activity.
     *
     * @return BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * Get the codes associate with the code activity.
     *
     * @return HasMany
     */
    public function codes(): HasMany
    {
        return $this->hasMany(AnimCodeCodes::class, 'code_activity_id');
    }

    /**
     * @return HasOne
     */
    public function latestCode(): HasOne
    {
        return $this->hasOne(AnimCodeCodes::class, 'code_activity_id')->latestOfMany();
    }

    /**
     * @return HasManyThrough
     */
    public function proposals(): HasManyThrough
    {
        return $this->hasManyThrough(AnimCodeProposals::class, AnimCodeCodes::class, 'code_activity_id', 'code_id');
    }
}
