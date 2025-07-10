<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail; // Jika Anda ingin mengirim email juga
use App\Mail\ContactFormMail; // Buat Mailable ini jika ingin kirim email

class ContactController extends Controller
{
    /**
     * Handle the form submission from the contact section.
     */
    public function submit(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subjek' => 'required|string|max:255',
            'pesan' => 'required|string',
        ]);

        // Simpan data ke database
        Contact::create([
            'name' => $validatedData['nama'],
            'email' => $validatedData['email'],
            'subject' => $validatedData['subjek'],
            'message' => $validatedData['pesan'],
        ]);

        // Opsional: Kirim email notifikasi ke admin (Anda perlu mengkonfigurasi Mail di .env dan membuat Mailable)
        // try {
        //     Mail::to('admin@desamedalsari.com')->send(new ContactFormMail($validatedData));
        // } catch (\Exception $e) {
        //     // Handle error pengiriman email, misalnya log errornya
        //     \Log::error('Gagal mengirim email kontak: ' . $e->getMessage());
        // }

        return back()->with('success', 'Pesan Anda berhasil dikirim!');
    }

    /**
     * Display a listing of the contact messages for admin dashboard.
     */
    public function index()
    {
        $contacts = Contact::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.contacts.index', compact('contacts'));
    }

    /**
     * Mark a contact message as read.
     */
    public function markAsRead(Contact $contact)
    {
        $contact->update(['is_read' => true]);
        return back()->with('success', 'Pesan berhasil ditandai sudah dibaca.');
    }

    /**
     * Delete a contact message.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return back()->with('success', 'Pesan berhasil dihapus.');
    }
}