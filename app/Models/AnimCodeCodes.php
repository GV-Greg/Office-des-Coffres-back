<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Crypt;

class AnimCodeCodes extends Model
{
    /**
     * The name of table.
     *
     * @var string
     */
    protected $table = 'anim_code_codes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code_activity_id',
        'code',
        'status'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Get the activity of the code.
     *
     * @return BelongsTo
     */
    public function activity(): BelongsTo
    {
        return $this->belongsTo(AnimCodeActivity::class, 'code_activity_id');
    }

    /**
     * Get the proposals associate with the code.
     *
     * @return HasMany
     */
    public function proposals(): HasMany
    {
        return $this->hasMany(AnimCodeProposals::class, 'code_id');
    }
}
