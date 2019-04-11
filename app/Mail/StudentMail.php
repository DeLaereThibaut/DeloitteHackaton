<?php

namespace App\Mail;

use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class StudentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $student;

    /**
     * CommandMail constructor.
     * @param PurchaseOrder $purchaseOrder
     * @param Command $command
     * @param Bill $bill
     */
    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    /**
     * Build the message
     *
     * @return $this
     */
    public function build()
    {

         return $this->subject("Register to Deloitte completed. Send us your CV")->markdown('emails.sendCV');

    }
}
