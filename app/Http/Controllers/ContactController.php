<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        // Renommer la variable 'message' pour éviter le conflit
        $contactMessage = $data['message'];

        Mail::send('emails.contact', [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'subject' => $data['subject'],
            'contactMessage' => $contactMessage, // <-- utiliser cette variable dans la vue
        ], function ($mail) use ($data) {
            $mail->to('sodenecome@gmail.com')
                ->subject('Nouveau message de contact : ' . $data['subject']);
        });

        return back()->with('success', 'Votre message a été envoyé avec succès !');
    }
}
