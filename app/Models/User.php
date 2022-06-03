<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'is_validated'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_validated' => 'boolean',
    ];

    public function isAdmin()
    {
        return Auth::user()->hasRole('Admin');
    }

    /**
     * Get the creator's grids
     *
     * @return HasMany
     */
    public function grids(): HasMany
    {
        return $this->hasMany(AnimRewardsGrid::class, 'grid_id');
    }

    /**
     * Get the creator's grids
     *
     * @return HasMany
     */
    public function rewards(): HasMany
    {
        return $this->hasMany(AnimRewardsList::class, 'player_id');
    }


}
