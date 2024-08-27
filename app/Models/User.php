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
    
    // ユーザーが送信したフレンドリクエスト
    public function sentFriendRequests()
    {
        return $this->hasMany(Friendship::class, 'requester_id');
    }

    // ユーザーが受信したフレンドリクエスト
    public function receivedFriendRequests()
    {
        return $this->hasMany(Friendship::class, 'receiver_id');
    }

    // 承認された友達
    public function friends()
    {
        return $this->belongsToMany(User::class, 'friendships', 'requester_id', 'receiver_id')
                    ->wherePivot('status', 'accepted');
    }
    public function matchesAsUser1()
    {
        return $this->hasmany(BookMatch::class, 'user1_id');
    }

    public function matchesAsUser2()
    {
        return $this->hasMany(BookMatch::class, 'user2_id');
    }

    public function matches()
    {
        return $this->matchesAsUser1->merge($this->matchesAsUser2);
    }
}
