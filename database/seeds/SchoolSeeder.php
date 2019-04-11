<?php

use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(\App\User::class, 12)->create();

        factory(\App\Models\School::class, rand(10,11))->create();
        \App\Models\School::all()->each(function($school){
            $comments = factory(\App\Models\Comment::class, rand(1,8))->create();
            $school->comments()->saveMany($comments);
            $v = array();
            for($k=0;$k<rand(0,3);$k++){
                $rn = rand(1, \App\User::count());
                if(!in_array($rn, $v)){
                    $r = \App\User::find($rn);
                    $school->ambassador()->attach($r);
                    array_push($v, $rn);
                }
            }
            $contact = factory(\App\Models\Contact::class, rand(1,5))->create();
            $school->contacts()->saveMany($contact);
            $v = array();
            for($k=0;$k<rand(0,3);$k++){
                $rn = rand(1, 26);
                if(!in_array($rn, $v)){
                    $r = \App\Models\TargetedProfile::find($rn);
                    $school->targetProfiles()->attach($r);
                    array_push($v, $rn);
                }
            }
            $events = factory(\App\Models\SchoolEvent::class, rand(2, 5))->create();
                $school->events()->saveMany($events);
                $events->each(function($event){

                    $v = array();
                    for($k=0;$k<rand(0,3);$k++){
                        $rn = rand(1, \App\User::count());
                        if(!in_array($rn, $v)){
                            $r = \App\User::find($rn);
                            $event->ambassadors()->attach($r);
                            array_push($v, $rn);
                        }
                    }

                    $comments = factory(\App\Models\Comment::class, rand(1,8))->create();
                    $event->comments()->saveMany($comments);
                    $students = factory(\App\Models\Student::class, rand(15, 30))->create();
                    $students->each(function($student) use ($event){
                        $event->students()->attach($student);
                        $v = array();
                        for($k=0;$k<rand(0,3);$k++){
                            $rn = rand(1, 26);
                            if(!in_array($rn, $v)){
                                $r = \App\Models\TargetedProfile::find($rn);
                                $student->targetProfiles()->attach($r);
                                array_push($v, $rn);
                            }
                        }
                    });
                    $v = array();
                    for($k=0;$k<rand(2,5);$k++){
                        $rn = rand(1, 26);
                        if(!in_array($rn, $v)){
                            $r = \App\Models\TargetedProfile::find($rn);
                            $event->targetProfiles()->attach($r);
                            array_push($v, $rn);
                        }
                    }




                });
            });

    }
}
