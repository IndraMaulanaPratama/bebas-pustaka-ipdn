<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Fungsi kanggo sawalasna maca relasi user ka table role teras ka tabel pivot menu
    protected $with = ['role.pivotMenu'];


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_role',
        'name',
        'email',
        'email_verified_at',
        'nomor_ponlsel',
        'password',
        'photo',
        'sign',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    /**
     * --- *** RELATION AREA *** ---
     */

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'user_role', 'ROLE_ID');
    }


    public function similaritas(): HasMany
    {
        return $this->hasMany(Similaritas::class, 'SIMILARITAS_OFFICER', 'id');
    }


    public function PinjamanPustaka(): HasMany
    {
        return $this->hasMany(PinjamanPustaka::class, 'PUSTAKA_OFFICER', 'id');
    }


    public function PinjamanFakultas(): HasMany
    {
        return $this->hasMany(PinjamanFakultas::class, 'FAKULTAS_OFFICER', 'id');
    }


    public function DonasiPustaka(): HasMany
    {
        return $this->hasMany(DonasiPustaka::class, 'PUSTAKA_OFFICER', 'id');
    }


    public function DonasiFakultas(): HasMany
    {
        return $this->hasMany(DonasiFakultas::class, 'FAKULTAS_OFFICER', 'id');
    }


    public function DonasiElektronik(): HasMany
    {
        return $this->hasMany(DonasiElektronik::class, 'ELEKTRONIK_OFFICER', 'id');
    }

    public function survey(): HasOne
    {
        return $this->hasOne(Survey::class, 'SURVEY_OFFICER', 'id');
    }


    public function konten_literasi(): HasOne
    {
        return $this->hasOne(KontenLiterasi::class, 'KONTEN_OFFICER', 'id');
    }

    // --- *** END OF RELATION AREA *** ---



    /**
     * --- *** SCOPE AREA *** ---
     */

    public function scopeLoginUser(Builder $query, string $email): void
    {
        $query->where('email', '=', $email);
    }

    // --- *** END OF SCOPE AREA *** ---
}
