<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnimCodeProposals extends Model
{
    /**
     * The name of table.
     *
     * @var string
     */
    protected $table = 'anim_code_proposals';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code_id',
        'combination',
        'points',
        'player'
    ];

    public $timestamps = false;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Get the code of the proposal.
     *
     * @return BelongsTo
     */
    public function code(): BelongsTo
    {
        return $this->belongsTo(AnimCodeCodes::class, 'code_id');
    }
}
