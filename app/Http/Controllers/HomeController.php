<?php

namespace App\Http\Controllers;

use App\Models\ContractType;
use App\Models\Country;
use App\Models\EventType;
use App\Models\Gender;
use App\Models\SchoolEvent;
use App\Models\Student;
use App\Models\StudentStatus;
use App\Models\TargetedProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $this->generateStats();
        return view('home');
    }

    private function generateStats(){
        $datatableGender = \Lava::DataTable();
        $datatableGender->addStringColumn('Gender');
        $datatableGender->addNumberColumn('Count');

        foreach (Gender::all() as $gd)   {
            $datatableGender->addRow([$gd->name, Student::where('gender', '=', $gd->id)->count()]);
        }

        \Lava::PieChart('StatChart_1', $datatableGender, [
            'title' => 'Gender',
        ]);

        $datatabletp = \Lava::DataTable();
        $datatabletp->addStringColumn('Country');
        $datatabletp->addNumberColumn('Count');

        foreach (Country::all() as $gd)   {
            $datatabletp->addRow([$gd->name, SchoolEvent::where('country_id', '=', $gd->id)->count()]);
        }

        \Lava::PieChart('StatChart_2', $datatabletp, [
            'title' => 'Country',
        ]);

        $datatablestatusStat = \Lava::DataTable();
        $datatablestatusStat->addStringColumn('Type');
        $datatablestatusStat->addNumberColumn('Count');

        foreach (EventType::all() as $gd)   {
            $datatablestatusStat->addRow([$gd->name, SchoolEvent::where('type_id', '=', $gd->id)->count()]);
        }

        \Lava::PieChart('StatChart_4', $datatablestatusStat, [
            'title' => 'Event Type',
        ]);

        $datatablecontract = \Lava::DataTable();
        $datatablecontract->addStringColumn('Structure');
        $datatablecontract->addNumberColumn('Count');

        foreach (ContractType::all() as $gd)   {

            $datatablecontract->addRow([$gd->name, SchoolEvent::where('internalStructure', '=', $gd->id)->count()]);
        }

        \Lava::PieChart('StatChart_3', $datatablecontract, [
            'title' => 'Internal Structure',
        ]);

    }




}
