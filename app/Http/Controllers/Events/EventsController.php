<?php
/**
 * Created by PhpStorm.
 * User: sebak
 * Date: 02-04-19
 * Time: 11:46
 */

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use App\Mail\StudentMail;
use App\Models\ContractType;
use App\Models\Gender;
use App\Models\Comment;
use App\Models\SchoolEvent;
use App\Models\Student;
use App\Models\StudentStatus;
use App\Models\TargetedProfile;
use App\User;
use Carbon\Carbon;
use Faker\Provider\Uuid;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\UuidFactory;

class EventsController extends Controller
{

    public function index($queryBy = null, $query = null)
    {
        $allEvents = $this->filter($query, $queryBy);
        return view('events.list', ["events" => $allEvents, 'filter' => $query, 'filterBy' => $queryBy]);
    }

    private function filter($filter, $filterBy)
    {
        if ($filterBy != null) {
            switch($filterBy){
                case "Name":
                    $allEvents = SchoolEvent::where('name', 'LIKE', '%' . $filter . '%')->paginate(5);

                    break;
                    case "Country":
                    $allEvents = SchoolEvent::select('SchoolEvents.*')->join('Country as c', 'SchoolEvents.country_id', '=', 'c.id')->where('c.name', 'LIKE', '%' . $filter . '%')->paginate(5);

                    break;
                    case "School":
                    $allEvents = SchoolEvent::select('SchoolEvents.*')->join('Schools as s', 'SchoolEvents.country_id', '=', 's.school_id')->where('s.name', 'LIKE', '%' . $filter . '%')->paginate(5);

                    break;
                default:
                    $allEvents = SchoolEvent::paginate(5);
            }
        } else {
            $allEvents = SchoolEvent::paginate(5);
        }

        return $allEvents;
    }

    public function detail($id)
    {
        $schoolEvent = SchoolEvent::find($id);
        if ($schoolEvent == null)
            return abort(404);
        $this->generateStats($id);

        return view('events.detail', ["schoolevent" => $schoolEvent]);
    }

    public function add()
    {

        $v = $this->validator($_POST);
        if ($v->fails()) {
            $message = "The form contains some errors:<br/>";

            foreach ($v->errors()->getMessages() as $error) {

                $message .= "<b>" . $error[0] . "</b><br/>";
            }

            return '{"result":false, "message":"' . $message . '"}';
        } else {
            $this->save($_POST);
            return '{"result":true, "message":"The event has been added."}';
        }


    }

    private function saveEditedEvent($data)
    {
        $id = $data['event_id'];
        if ($id == -1) $e = new SchoolEvent();
        else $e = SchoolEvent::find($id);


        $e->name = $data['name'];
        $e->type_id = $data['type'];
        $e->school_id = $data['school'];
        $e->country_id = $data['country'];
        $e->eventPrice = $data['price'];
        $e->location = $data['location'];
        $e->country_id = $data['country'];
        $e->eventPrice = $data['price'];
        $e->internalStructure = $data['internal_structure'];
        $e->fiscalYear = $data['fiscalYear'];

        $e->startDate = new Carbon($data['date_of_beginning'] . " " . $data['date_of_beginning_hour'] . ":" . $data['date_of_beginning_minutes']);
        $e->endDate = new Carbon($data['date_of_end'] . " " . $data['date_of_end_hour'] . ":" . $data['date_of_end_minutes']);
        //return '{"result":false, "message":"mois: ' . $from->month . '."}';

        $e->save();
        $e->targetProfiles()->detach();


        foreach ($data['targeted_profiles'] as $tp) {
            $tpm = TargetedProfile::find($tp);
            if ($tp != null) $e->targetProfiles()->attach($tpm);

        }


        $e->ambassadors()->detach();

        foreach ($data['ambassadors'] as $tp) {
            $tpm = User::find($tp);
            if ($tp != null) $e->ambassadors()->attach($tpm);
        }

    }

    public function editEvent()
    {

        $v = $this->validator($_POST);
        if ($v->fails()) {
            $message = "The form contains some errors:<br/>";

            foreach ($v->errors()->getMessages() as $error) {

                $message .= "<b>" . $error[0] . "</b><br/>";
            }

            return '{"result":false, "message":"' . $message . '"}';
        } else {
            $this->saveEditedEvent($_POST);
            return '{"result":true, "message":"The event has been edited."}';
        }


    }

    public function addStudent($idEvent)
    {

        $v = $this->validatorStudent($_POST);
        if ($v->fails()) {
            $message = "The form contains some errors:<br/>";

            foreach ($v->errors()->getMessages() as $error) {

                $message .= "<b>" . $error[0] . "</b><br/>";
            }

            return '{"result":false, "message":"' . $message . '"}';
        } else {
            $student = $this->saveStudent($_POST, $idEvent);

            $mail = new StudentMail($student);
            \Mail::to($student->email)->send($mail);
            return '{"result":true, "message":"The student has been added."}';
        }
    }

    private function save($data, $id = -1)
    {
        if ($id == -1) $e = new SchoolEvent();
        else $e = SchoolEvent::find($id);

        $e->name = $data['name'];
        $e->type_id = $data['type'];
        $e->school_id = $data['school'];
        $e->country_id = $data['country'];
        $e->eventPrice = $data['price'];
        $e->location = $data['location'];
        $e->country_id = $data['country'];
        $e->eventPrice = $data['price'];
        $e->internalStructure = $data['internal_structure'];
        $e->fiscalYear = $data['fiscalYear'];
        $e->internal = $data['isInternal'];

        $e->startDate = new Carbon($data['date_of_beginning'] . " " . $data['date_of_beginning_hour'] . ":" . $data['date_of_beginning_minutes']);
        $e->endDate = new Carbon($data['date_of_end'] . " " . $data['date_of_end_hour'] . ":" . $data['date_of_end_minutes']);
        //return '{"result":false, "message":"mois: ' . $from->month . '."}';

        $e->save();
        $e->targetProfiles()->detach();
        foreach ($data['targeted_profiles'] as $tp) {
            $tpm = TargetedProfile::find($tp);
            if ($tp != null) $e->targetProfiles()->attach($tpm);

        }

        foreach ($data['ambassadors'] as $tp) {
            $tpm = User::find($tp);
            if ($tp != null) $e->ambassadors()->attach($tpm);

        }


    }

    private function validator(array $data)
    {
        $v = \Illuminate\Support\Facades\Validator::make($data, [
            'name' => ['required', 'string', 'min:3', 'max:50'],
            'school' => ['required', 'integer'],
            'type' => ['required', 'integer'],
            'date_of_beginning' => ['required', 'date'],
            'date_of_end' => ['required', 'date'],
            'date_of_beginning_hour' => ['required', 'integer', 'min:0', 'max:23'],
            'date_of_beginning_minutes' => ['required', 'integer', 'min:0', 'max:59'],
            'date_of_end_hour' => ['required', 'integer', 'min:0', 'max:23'],
            'date_of_end_minutes' => ['required', 'integer', 'min:0', 'max:59'],
            'location' => ['required', 'string', 'min:3', 'max:50'],
            'fiscalYear' => ['required', 'int'],
            'country' => ['required', 'integer'],
            'price' => ['required', 'numeric'],
            'internal_structure' => ['required', 'integer'],
            'isInternal' => ['required'],
            'targeted_profiles' => ['required'],
            'ambassadors' => ['required'],

        ]);
        return $v;
    }

    private function validatorStudent(array $data)
    {
        $v = \Illuminate\Support\Facades\Validator::make($data, [
            'lastname' => ['required', 'string', 'min:3', 'max:50'],
            'firstname' => ['required', 'string', 'min:3', 'max:50'],
            'gender' => ['required'],
            'email' => ['required', 'string', 'email', 'max:50'],
            'phone_number' => ['required', 'string', 'max:50'],
            'targeted_profile' => ['required', 'int'],
            'status' => ['required'],
            'contract_type' => ['required'],
            'feedback' => ['nullable', 'max:255'],


        ]);
        return $v;
    }

    private function saveStudent($data, $idEvent, $id = -1)
    {
        if ($id == -1) $e = new Student();
        else $e = Student::find($id);

        $e->lastname = $data['lastname'];
        $e->firstname = $data['firstname'];
        $e->gender = $data['gender'];
        $e->email = $data['email'];
        $e->phoneNumber = $data['phone_number'];
        $e->status = $data['status'];
        $e->contractType = $data['contract_type'];
        $e->feedback = $data['feedback'];
        $e->workPermit = ($data['need_work_permit'] ? 1 : 0);
        $e->hash = Uuid::uuid();
        $e->ambassador_id = auth()->user()->user_id;
        $e->targetProfiles()->attach(TargetedProfile::find($data['targeted_profile']));
        //foreach($data['targeted_profiles'] as $tp){
        //    $tpm = TargetedProfile::find($tp);
        //    if($tp != null) $e->targetProfiles()->attach($tpm);
//
        //}
        $se = SchoolEvent::find($idEvent);

        $e->save();
        $e->events()->attach($se);
        return $e;
    }

    private function generateStats($id = 13)
    {
        $datatableGender = \Lava::DataTable();
        $datatableGender->addStringColumn('Gender');
        $datatableGender->addNumberColumn('Count');

        foreach (Gender::all() as $gd) {
            //dd( Student::where('gender', '=', $gd->id)->join('eventhostedstudent as ehs', 'Students.student_id', '=', 'ehs.student_id')->groupBy('ehs.student_id')->where('ehs.event_id', '=', $id)->count());
            $datatableGender->addRow([$gd->name, Student::where('gender', '=', $gd->id)->join('eventhostedstudent as ehs', 'Students.student_id', '=', 'ehs.student_id')->where('ehs.event_id', '=', $id)->count()]);
        }

        \Lava::PieChart('StatChart_1', $datatableGender, [
            'title' => 'Gender',
        ]);

        $datatabletp = \Lava::DataTable();
        $datatabletp->addStringColumn('Gender');
        $datatabletp->addNumberColumn('Count');

        foreach (TargetedProfile::all() as $gd) {
            $students = \DB::table("Students as s")->select(\DB::raw("count(*) as count"))->join('studentshavetargetedprofiles as tp', 's.student_id', '=', 'tp.student_id')->join('eventhostedstudent as ehs', 's.student_id', '=', 'ehs.student_id')->where('ehs.event_id', '=', $id)->where('tp.targetedProfiles_id', '=', $gd->id)->get();
            $datatabletp->addRow([$gd->name, $students->first()->count]);
        }

        \Lava::PieChart('StatChart_2', $datatabletp, [
            'title' => 'Targeted Profiles',
        ]);

        $datatablestatusStat = \Lava::DataTable();
        $datatablestatusStat->addStringColumn('Status');
        $datatablestatusStat->addNumberColumn('Count');

        foreach (StudentStatus::all() as $gd) {
            $datatablestatusStat->addRow([$gd->name, Student::where('status', '=', $gd->id)->join('eventhostedstudent as ehs', 'Students.student_id', '=', 'ehs.student_id')->where('ehs.event_id', '=', $id)->count()]);
        }

        \Lava::PieChart('StatChart_4', $datatablestatusStat, [
            'title' => 'Student Status',
        ]);

        $datatablecontract = \Lava::DataTable();
        $datatablecontract->addStringColumn('Type');
        $datatablecontract->addNumberColumn('Count');

        foreach (ContractType::all() as $gd) {
            $datatablecontract->addRow([$gd->name, Student::where('contractType', '=', $gd->id)->join('eventhostedstudent as ehs', 'Students.student_id', '=', 'ehs.student_id')->where('ehs.event_id', '=', $id)->count()]);
        }

        \Lava::PieChart('StatChart_3', $datatablecontract, [
            'title' => 'Contract Types',
        ]);
        $datatableWorkPermit = \Lava::DataTable();
        $datatableWorkPermit->addStringColumn('Work Permit');
        $datatableWorkPermit->addNumberColumn('Count');

        $datatableWorkPermit->addRow(["Yes", Student::where('workPermit', '=', 1)->join('eventhostedstudent as ehs', 'Students.student_id', '=', 'ehs.student_id')->where('ehs.event_id', '=', $id)->count()]);
        $datatableWorkPermit->addRow(["No", Student::where('workPermit', '=', 0)->join('eventhostedstudent as ehs', 'Students.student_id', '=', 'ehs.student_id')->where('ehs.event_id', '=', $id)->count()]);


        \Lava::PieChart('StatChart_5', $datatableWorkPermit, [
            'title' => 'Work Permit',
        ]);


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

    protected function validatorComment($data)
    {
        $v = \Illuminate\Support\Facades\Validator::make($data, [
            'comment' => ['required', 'string', 'min:1', 'max:255'],
            'user' => ['required', 'integer'],
            'event' => ['required', 'integer'],
        ]);
        return $v;
    }

    private function saveComment($data, $id = -1)
    {
        if ($id == -1) $e = new Comment();
        else $e = Comment::find($id);
        $events = SchoolEvent::find($data['event']);
        $e->comments = $data['comment'];
        $e->date = date("Y-m-d h:i:s");
        $e->user_id = $data['user'];

        $e->save();
        $events->comments()->attach($e->comment_id);
    }
    public function addStudentComment()
    {
        $v = $this->validatorComment($_POST);
        if ($v->fails()) {
            $message = "The comment contains some errors:<br/>";

            foreach ($v->errors()->getMessages() as $error) {

                $message .= "<b>" . $error[0] . "</b><br/>";
            }

            return '{"result":false, "message":"' . $message . '"}';
        } else {
            $this->saveStudentComment($_POST);
            return '{"result":true, "message":"The comment has been added."}';
        }
    }
    private function saveStudentComment($data, $id = -1)
    {
        if ($id == -1) $e = new Comment();
        else $e = Comment::find($id);
        $student = Student::find($data['event']);
        $e->comments = $data['comment'];
        $e->date = date("Y-m-d h:i:s");
        $e->user_id = $data['user'];

        $e->save();
        $student->comments()->attach($e->comment_id);
    }
    public function addCV($id)
    {
        $student = Student::find($id);

        foreach ($_FILES as $p) {

            Storage::disk('public')->put('CV/' . $student->student_id . '/CV_' . Carbon::now()->format('Y-m-d_h_i_s') . '.' . pathinfo($p['name'], PATHINFO_EXTENSION), file_get_contents($p['tmp_name']));
        }

        return view('partial.cv_list', ['student' => $student]);
    }

    public function getCV($id, $name)
    {
        return Storage::disk('public')->download('CV/' . $id . '/' . $name);
    }

    public function showStudent($hash){
        $students = Student::where('hash', '=', $hash)->get();
        if($students->count()==0)return abort(404);
        return view('events.showStudent', ['student'=>$students->first()]);
    }
}
