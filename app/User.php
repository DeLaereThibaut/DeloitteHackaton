<?php

namespace App;

use App\Models\Comment;
use App\Models\School;
use App\Models\SchoolEvent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;


/**
 * Class User
 *
 * @property int $user_id
 * @property string $ambassadorType
 * @property string $username
 * @property string $email
 *
 * @property Collection $comments
 * @property Collection $events
 *

 */
class User extends Authenticatable
{

    use Notifiable;
    protected $primaryKey = 'user_id';
    public  $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'username', 'ambassadorType', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function comments(){
        $this->hasMany(Comment::class, 'user_id');
    }

    public function events(){
        $this->belongsToMany(SchoolEvent::class, 'eventhasuser');
    }

    public function ambassadors(){
        $this->belongsToMany(School::class, 'schoolhasuser', 'user_id', 'school_id');
    }
}
