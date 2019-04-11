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
 * @property int $id
 * @property String $name
 *
 */
class TargetedProfile extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $table = 'TargetedProfiles';

    public function students()
    {
        return $this->belongsToMany(Student::class, 'studentshavetargetedprofiles', 'targetedProfiles_id', 'student_id');
    }

}
