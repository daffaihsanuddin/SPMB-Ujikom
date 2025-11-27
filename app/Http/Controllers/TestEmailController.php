<?php
// app/Http/Controllers/TestEmailController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestEmail;

class TestEmailController extends Controller
{
    public function testEmail()
    {
        try {
            Mail::raw('Test email dari SPMB Online', function ($message) {
                $message->to('daffaihsana@gmail.com')
                        ->subject('Test Email SPMB');
            });
            
            return "Email test berhasil dikirim!";
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
}