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
 * Class Contact
 * @package App\Models
 *
 * @property int $contact_id
 * @property string $email
 * @property string $firstname
 * @property string $lastname
 * @property string phone
 * @property string position
 * @property bool primaryContact
 * @property School $school
 * @property Collection $comments
 */
class Contact extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'contact_id';

    public function comments(){
        return $this->belongsToMany(Comment::class, 'contactshascomments');
    }

    public function school(){
        return $this->belongsTo(School::class, 'school_id');
    }
}