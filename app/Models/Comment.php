<?php
/**
 * Created by PhpStorm.
 * User: sebak
 * Date: 02-04-19
 * Time: 09:25
 */

namespace App\Models;


use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Comment
 * @package App\Models
 *
 * @property int $comment_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $comments
 * @property User $user
 *
 */
class Comment extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'comment_id';

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function schools(){
        return $this->belongsToMany(School::class, 'schoolhascomments', 'comment_id', 'school_id');
    }
    public function events(){
        return $this->belongsToMany(School::class, 'schooleventhascomments', 'comment_id', 'event_id');
    }
}
