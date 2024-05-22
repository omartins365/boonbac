<?php

namespace App\Models;

use App\Base\HasDp;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\File;
use Illuminate\Notifications\Notifiable;
use PHPUnit\Framework\Constraint\JsonMatches;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasDp;

    const DP_DIR = "public/images/profile/";
    const DP_DIR_PUB = "images/profile/";

    static public string $DP_DIR = "public/images/profile/";
    static public string $DP_DIR_PUB = "images/profile/";

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        // 'permission' => '{"manage_users":false,
        //     "manage_pid":false,
        //     "manage_type":false,}',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'brand_name',
        'rank',
        'permission',
        'email',
        'phone',
        'wa_phone',
        'password',
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
        'permission' => 'array'
    ];

    public function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $attributes["last_name"] . " " . $attributes["first_name"],
        );
    }


    /**
     * Get all of the bookings for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */


    /**
     * Get all of the images for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(Media::class, 'user_id', 'id');
    }


}
