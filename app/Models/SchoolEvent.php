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
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
/**
 * Class SchoolEvent
 * @package App\Models
 *
 * @property int $event_id
 * @property Carbon $endDate
 * @property double $eventPrice
 * @property int $fiscalYear
 * @property bool $internal
 * @property string $name
 * @property Carbon $startDate
 *
 * @property Collection $comments
 * @property Collection $ambassadors
 * @property Collection $targetedProfiles
 * @property Collection $students
 * @property School $organiser;
 *

 */
class SchoolEvent extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'event_id';
    protected $table = 'SchoolEvents';

    public function scopeFuture($query){
        return $query->where('startDate', '>=', Carbon::now())->orderBy('startDate', 'asc');
    }

    public function scopeCurrent($query){
        return $query->where('startDate', '<=', Carbon::now())->where('endDate', '>=', Carbon::now())->orderBy('endDate', 'asc');
    }

    public function ambassadors(){
        return $this->belongsToMany(User::class, 'eventhasuser', 'event_id', 'user_id');
    }

    public function students(){
        return $this->belongsToMany(Student::class, 'eventhostedstudent', 'event_id', 'student_id');
    }

    public function comments(){
        return $this->belongsToMany(Comment::class, 'schooleventshascomments', 'event_id', 'comment_id');
    }
    public function type(){
        return $this->belongsTo(EventType::class, 'type_id');
    }

    public function internalStructures()
    {
        return $this->belongsTo(InternalStructure::class, 'internalStructure');
    }
    public function country(){
        return $this->belongsTo(Country::class, 'country_id');
    }
    public function organiser(){
        return $this->belongsTo(School::class, 'school_id');
    }
    public function targetProfiles(){
        return $this->belongsToMany(TargetedProfile::class, 'schooleventshavetargetedprofiles', 'event_id', 'targetedProfiles_id');
    }
}
