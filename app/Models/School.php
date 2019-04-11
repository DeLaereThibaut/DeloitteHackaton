<?php
/**
 * Created by PhpStorm.
 * User: sebak
 * Date: 02-04-19
 * Time: 09:25
 */

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class School
 * @package App\Models
 *
 * @property int $school_id
 * @property string $adress
 * @property int $internalStructure
 * @property string $name
 * @property int $sponsored
 * @property bool $targeted
 *
 * @property Collection $comments
 * @property Collection $targetedProfiles
 * @property Collection $contacts
 * @property Collection $events
 */
class School extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'school_id';


    public function comments(){
        return $this->belongsToMany(Comment::class, 'schoolhascomments', 'school_id', 'comment_id');
    }

    public function ambassador(){
        return $this->belongsToMany(User::class, 'schoolhasuser','school_id', 'user_id');
    }

    public function contacts(){
        return $this->hasMany(Contact::class, 'school_id');
    }

    public function targetProfiles(){
        return $this->belongsToMany(TargetedProfile::class, 'schoolshavetargetedprofiles', 'school_id', 'targetedProfiles_id');
    }
    public function events(){
        return $this->hasMany(SchoolEvent::class, 'school_id');
    }
    public function internalStructures(){
        return $this->belongsTo(InternalStructure::class, 'internalStructure');
    }
}
