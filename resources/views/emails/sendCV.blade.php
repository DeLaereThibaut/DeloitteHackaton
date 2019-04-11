@component('mail::message')
    # Register Completed! Send us your CVs!

    You can send us your CVs with the link below:

    {{route('student', ['hash'=>$student->hash])}}

    Thank you,

    Deloitte.
@endcomponent

