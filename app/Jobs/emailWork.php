<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\emailService;

class emailWork implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $usuario;
    public $monto;
    public $mensaje;
    public $email;
    public $subject;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($usuario,$monto,$mensaje,$email,$subject)
    {
        $this->usuario = $usuario;
        $this->monto = $monto;
        $this->mensaje = $mensaje;
        $this->email = $email;
        $this->subject = $subject;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        emailService::enviarEmail($this->usuario,$this->monto, $this->mensaje,$this->email,$this->subject);
    }
}
