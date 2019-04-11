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
class InternalStructure extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $table = 'InternalStructure';
}