<?php
/**
 * Created by PhpStorm.
 * User: sebak
 * Date: 02-04-19
 * Time: 11:46
 */

namespace App\Http\Controllers\Schools;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\ContractType;
use App\Models\Gender;
use App\Models\School;
use App\Models\Comment;
use App\Models\SchoolEvent;
use App\Models\Student;
use App\Models\StudentStatus;
use App\Models\TargetedProfile;
use App\User;

class SchoolsController extends Controller
{

    public function index($id = -1)
    {
        $list = \App\Models\School::paginate(5);
        return view('schools.list', ["schools" => $list]);
    }

    public function detail($id)
    {
        $school = School::find($id);
        if ($school == null)
            return abort(404);
        $this->generateStats($id);
        $events = $school->events;
        $studentsCount = 0;
        foreach ($events as $event) {
            $studentsCount += $event->students->count();
        }
        return view('schools.detail', ["school" => $school, 'eventsCount' => $events->count(), 'studentsCount' => $studentsCount]);
    }

    public function addComment()
    {
        $v = $this->validatorComment($_POST);
        if ($v->fails()) {
            $message = "The comment contains some errors:<br/>";

            foreach ($v->errors()->getMessages() as $error) {

                $message .= "<b>" . $error[0] . "</b><br/>";
            }

            return '{"result":false, "message":"' . $message . '"}';
        } else {
            $this->saveComment($_POST);
            return '{"result":true, "message":"The comment has been added."}';
        }
    }

    protected function validatorComment(array $data)
    {
        $v = \Illuminate\Support\Facades\Validator::make($data, [
            'comment' => ['required', 'string', 'min:1', 'max:255'],
            'user' => ['required', 'integer'],
            'school' => ['required', 'integer'],
        ]);
        return $v;
    }

    private function saveComment($data, $id = -1)
    {
        if ($id == -1) $e = new Comment();
        else $e = Comment::find($id);
        $schools = School::find($data['school']);
        $e->comments = $data['comment'];
        $e->date = date("Y-m-d h:i:s");
        $e->user_id = $data['user'];

        $e->save();
        $schools->comments()->attach($e->comment_id);
    }

    private function generateStats($id = 13)
    {
        $datatableGender = \Lava::DataTable();
        $datatableGender->addStringColumn('Gender');
        $datatableGender->addNumberColumn('Count');

        foreach (Gender::all() as $gd) {
            //dd( Student::where('gender', '=', $gd->id)->join('eventhostedstudent as ehs', 'Students.student_id', '=', 'ehs.student_id')->groupBy('ehs.student_id')->where('sch.school_id', '=', $id)->count());
            $datatableGender->addRow([$gd->name, Student::where('gender', '=', $gd->id)->join('eventhostedstudent as ehs', 'Students.student_id', '=', 'ehs.student_id')->join('SchoolEvents as se', 'se.event_id', '=', 'ehs.event_id')->where('se.school_id', '=', $id)->count()]);
        }

        \Lava::PieChart('StatChart_1', $datatableGender, [
            'title' => 'Gender',
        ]);

        $datatabletp = \Lava::DataTable();
        $datatabletp->addStringColumn('Gender');
        $datatabletp->addNumberColumn('Count');

        foreach (TargetedProfile::all() as $gd) {
            $students = \DB::table("Students as s")->select(\DB::raw("count(*) as count"))->join('studentshavetargetedprofiles as tp', 's.student_id', '=', 'tp.student_id')->join('eventhostedstudent as ehs', 's.student_id', '=', 'ehs.student_id')->join('SchoolEvents as se', 'se.event_id', '=', 'ehs.event_id')->where('se.school_id', '=', $id)->where('tp.targetedProfiles_id', '=', $gd->id)->get();
            $datatabletp->addRow([$gd->name, $students->first()->count]);
        }

        \Lava::PieChart('StatChart_2', $datatabletp, [
            'title' => 'Targeted Profiles',
        ]);

        $datatablestatusStat = \Lava::DataTable();
        $datatablestatusStat->addStringColumn('Status');
        $datatablestatusStat->addNumberColumn('Count');

        foreach (StudentStatus::all() as $gd) {
            $datatablestatusStat->addRow([$gd->name, Student::where('status', '=', $gd->id)->join('eventhostedstudent as ehs', 'Students.student_id', '=', 'ehs.student_id')->join('SchoolEvents as se', 'se.event_id', '=', 'ehs.event_id')->where('se.school_id', '=', $id)->count()]);
        }

        \Lava::PieChart('StatChart_4', $datatablestatusStat, [
            'title' => 'Student Status',
        ]);

        $datatablecontract = \Lava::DataTable();
        $datatablecontract->addStringColumn('Type');
        $datatablecontract->addNumberColumn('Count');

        foreach (ContractType::all() as $gd) {
            $datatablecontract->addRow([$gd->name, Student::where('contractType', '=', $gd->id)->join('eventhostedstudent as ehs', 'Students.student_id', '=', 'ehs.student_id')->join('SchoolEvents as se', 'se.event_id', '=', 'ehs.event_id')->where('se.school_id', '=', $id)->count()]);
        }

        \Lava::PieChart('StatChart_3', $datatablecontract, [
            'title' => 'Contract Types',
        ]);


    }

    public function addContact()
    {
        $v = $this->validatorContact($_POST);
        if ($v->fails()) {
            $message = "The comment contains some errors:<br/>";

            foreach ($v->errors()->getMessages() as $error) {

                $message .= "<b>" . $error[0] . "</b><br/>";
            }

            return '{"result":false, "message":"' . $message . '"}';
        } else {
            $this->saveContact($_POST);
            return '{"result":true, "message":"The contact has been added."}';
        }
    }

    protected function validatorContact(array $data)
    {
        $v = \Illuminate\Support\Facades\Validator::make($data, [
            'school_id' => ['required', 'integer'],
            'firstname' => ['required', 'string', 'min:1', 'max:255'],
            'lastname' => ['required', 'string', 'min:1', 'max:255'],
            'email' => ['required', 'string', 'min:1', 'max:255'],
            'phonenumber' => ['required', 'string', 'min:1', 'max:255'],
            'primary' => ['required', 'integer'],
            'position' => ['required', 'string', 'max:50'],
        ]);
        return $v;
    }

    private function saveContact($data, $id = -1)
    {
        if ($id == -1) $e = new Contact();
        else $e = Contact::find($id);

        $e->firstname = $data['firstname'];
        $e->lastname = $data['lastname'];
        $e->email = $data['email'];
        $e->phone = $data['phonenumber'];
        $e->primaryContact = $data['primary'];
        $e->school_id = $data['school_id'];
        $e->position = $data['position'];


        $e->save();
    }

    public function addSchool()
    {
        $v = $this->validatorSchool($_POST);
        if ($v->fails()) {
            $message = "The comment contains some errors:<br/>";

            foreach ($v->errors()->getMessages() as $error) {

                $message .= "<b>" . $error[0] . "</b><br/>";
            }

            return '{"result":false, "message":"' . $message . '"}';
        } else {
            $this->saveSchool($_POST);
            return '{"result":true, "message":"The school has been added."}';
        }
    }
    public function editSchool()
    {
        $v = $this->validatorSchool($_POST);
        if ($v->fails()) {
            $message = "The comment contains some errors:<br/>";

            foreach ($v->errors()->getMessages() as $error) {

                $message .= "<b>" . $error[0] . "</b><br/>";
            }

            return '{"result":false, "message":"' . $message . '"}';
        } else {
            $this->saveEditedSchool($_POST);
            return '{"result":true, "message":"The school has been added."}';
        }
    }

    protected function validatorSchool(array $data)
    {
        $v = \Illuminate\Support\Facades\Validator::make($data, [
            'schoolname' => ['required', 'string', 'min:1', 'max:255'],
            'website' => ['nullable', 'string', 'max:255'],
            'address' => ['required', 'string', 'min:1', 'max:255'],
            'internal_structure' => ['required', 'string', 'min:1', 'max:255'],
            'targeted_profiles' => ['required'],
            'targeted' => ['required', 'integer'],
            'sponsored' => ['required', 'integer'],
            'ambassador' => ['required']
        ]);
        return $v;
    }

    private function saveEditedSchool($data)
    {
        $id = $data['school_id'];
        if ($id == -1) $e = new School();
        else $e = School::find($id);

        $e->name = $data['schoolname'];
        $e->address = $data['address'];
        $e->internalStructure = $data['internal_structure'];
        $e->sponsored = $data['sponsored'];
        $e->targeted = $data['targeted'];
        $e->website = $data['website'];

        $e->save();
        $e->targetProfiles()->detach();
        foreach ($data['targeted_profiles'] as $tp) {
            $tpm = TargetedProfile::find($tp);
            if ($tp != null) $e->targetProfiles()->attach($tpm);
        }

        $e->ambassador()->detach();

        foreach ($data['ambassador'] as $tp) {
            $tpm = User::find($tp);
            if ($tp != null) $e->ambassador()->attach($tpm);
        }
    }
    private function saveSchool($data, $id=-1){
        $targetedProfiles = $data['targeted_profiles'];


        if($id == -1) $e = new School();
        else $e = School::find($id);

        $e->name    = $data['schoolname'];
        $e->address    = $data['address'];
        $e->internalStructure    = $data['internal_structure'];
        $e->sponsored    = $data['sponsored'];
        $e->targeted    = $data['targeted'];
        $e->website    = $data['website'];

        $e->save();
        $e->targetProfiles()->detach();
        foreach($data['targeted_profiles'] as $tp){
            $tpm = TargetedProfile::find($tp);
            if($tp != null) $e->targetProfiles()->attach($tpm);
        }

    }
}
