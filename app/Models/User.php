<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email', 
        'password',
        'foto',
        'email_verified_at',
        'remember_token',
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
     * Get all posts by this user
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get all documents by this user
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Get all businesses by this user
     */
    public function businesses()
    {
        return $this->hasMany(Business::class);
    }

    /**
     * Get all icons by this user
     */
    public function icons()
    {
        return $this->hasMany(Icon::class);
    }
}
