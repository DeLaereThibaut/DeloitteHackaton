<?php

namespace App\Http\Controllers\Help;

use App\Http\Controllers\Controller;
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

class HelpController extends Controller
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
        return view('help.help');
    }


}
