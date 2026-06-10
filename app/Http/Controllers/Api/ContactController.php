<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Mail\NewContactMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Exception;

class ContactController extends Controller
{

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'message' => 'required|string|max:5000',
        ]);

        try {
            $validated['name'] = strip_tags($validated['name']);
            $validated['message'] = strip_tags($validated['message']);

            $contact = Contact::create($validated);

            try {
                Mail::to($contact->email)
                    ->send(new NewContactMail($contact));
            } catch (Exception $e) {
                Log::warning('Contact Mail Delivery Failed: '.$e->getMessage());
            }

            return response()->json([
                'status' => true,
                'message' => 'Your message was received successfully.',
                'data' => [
                    'id' => $contact->id,
                    'name' => $contact->name,
                    'email' => $contact->email,
                ],
            ], 200);

        } catch (Exception $e) {
            Log::error('Contact Store Error: '.$e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Error processing request',
            ], 500);
        }
    }

    /**
     * لیست تمام تماس‌ها (فقط برای ادمین - Sanctum)
     */
    public function index()
    {
        // استفاده از paginate حیاتی است
        $contacts = Contact::latest()->paginate(15);

        return response()->json([
            'status' => true,
            'data'   => $contacts
        ]);
    }

    /**
     * مشاهده جزئیات (فقط برای ادمین)
     */
    public function show($id)
    {
        $contact = Contact::find($id);

        if (!$contact) {
            return response()->json(['status' => false, 'message' => 'Not found'], 404);
        }

        return response()->json([
            'status' => true,
            'data'   => $contact
        ]);
    }


}
