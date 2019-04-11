<?php
/**
 * Created by PhpStorm.
 * User: sebak
 * Date: 02-04-19
 * Time: 09:25
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
/**
 * Class Student
 * @package App\Models
 *
 * @property int $student_id
 * @property string $email
 * @property string $firstname
 * @property string $gender
 * @property string $lastname
 * @property string $phoneNumber
 * @property string $workPermit
 *
 * @property Collection $comments
 * @property Collection $events
 * @property Collection $targetedProfiles
 * @property ContractType $contractTypeStudent
 * @property StudentStatus $statusStudent
 *

 */
class Student extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'student_id';

    //TODO: create folder to each students and create function to get CVs;

    public function events(){
        return $this->belongsToMany(SchoolEvent::class, 'eventhostedstudent', 'student_id', 'event_id');
    }

    public function comments(){
        return $this->belongsToMany(Comment::class, 'studentshascomments', 'student_id', 'comment_id');
    }
    public function contractTypeStudent(){
        return $this->hasOne(ContractType::class, 'id', 'contractType');
    }
    public function statusStudent(){
        return $this->hasOne(StudentStatus::class, 'id', 'status');
    }

    public function targetProfiles(){
        return $this->belongsToMany(TargetedProfile::class, 'studentshavetargetedprofiles', 'student_id', 'targetedProfiles_id');
    }
}