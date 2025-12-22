<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Message;
use App\Models\Employee;

class MessageController extends Controller
{
    public function __construct()
    {
        // ✅ Protection de la suppression par permission (si tu utilises Spatie)
        if (method_exists($this, 'middleware')) {
            $this->middleware('permission:manage messaging')->only(['destroy']);
        }
    }

    /**
     * 🔹 Retourne l'employé actuellement connecté
     */
    protected function currentEmployee(): ?Employee
    {
        $user = Auth::user();
        if ($user) {
            return Employee::where('email', $user->email)->first();
        }
        return null;
    }

    /**
     * 🔹 Liste des messages (envoyés et reçus)
     */
    public function index()
    {
        $employee = $this->currentEmployee();

        if (! $employee) {
            $messages = Message::with('sender', 'recipient')
                ->orderByDesc('created_at')
                ->paginate(25);
        } else {
            $messages = Message::with('sender', 'recipient')
                ->where(function ($q) use ($employee) {
                    $q->where('recipient_id', $employee->id)
                      ->orWhere('sender_id', $employee->id);
                })
                ->orderByDesc('created_at')
                ->paginate(25);
        }

        return view('messages.index', compact('messages'));
    }

    /**
     * 🔹 Formulaire de création
     */
    public function create()
    {
        $recipients = Employee::orderBy('last_name')->get();
        return view('messages.create', compact('recipients'));
    }

    /**
     * 🔹 Envoi d’un message
     */
    public function store(Request $request)
    {
        $employee = $this->currentEmployee();
        if (! $employee) {
            return redirect()->back()->with('error', 'Votre compte n’est pas lié à un employé.');
        }

        $validated = $request->validate([
            'recipient_id' => 'required|exists:employees,id',
            'subject' => 'required|string|max:191',
            'body' => 'required|string',
            'attachment' => 'nullable|file|max:10240', // 10 Mo
        ]);

        $filePath = null;
        if ($request->hasFile('attachment')) {
            $filePath = $request->file('attachment')->store('messages', 'public');
        }

        Message::create([
            'sender_id' => $employee->id,
            'recipient_id' => $validated['recipient_id'],
            'subject' => $validated['subject'],
            'body' => $validated['body'],
            'attachment' => $filePath,
            'is_read' => false,
        ]);

        // 🔔 Envoi de la notification au destinataire
        $message = Message::find($message->id);
        $message->recipient->notify(new \App\Notifications\NewMessageNotification($message));

        return redirect()->route('messages.index')->with('success', 'Message envoyé avec succès.');
    }

    /**
     * 🔹 Lecture d’un message
     */
    public function show(Message $message)
    {
        $employee = $this->currentEmployee();

        // 🔹 Marquer comme lu le message
        if ($employee && $message->recipient_id == $employee->id && ! $message->is_read) {
            $message->update(['is_read' => true]);
        }

        // 🔹 Marquer comme lue la notification associée
        if ($employee) {
            $employee->unreadNotifications
                ->where('data.message_id', $message->id)
                ->markAsRead();
        }

        $message->load('sender','recipient');
        $recipients = Employee::where('id', '!=', $employee->id)->get();

        return view('messages.show', compact('message', 'recipients'));
    }

    /**
     * 🔹 Répondre à un message
     */
    public function reply(Request $request, Message $message)
    {
        $employee = $this->currentEmployee();
        if (! $employee) {
            return redirect()->back()->with('error', 'Aucun employé lié.');
        }

        $validated = $request->validate([
            'body' => 'required|string',
            'attachment' => 'nullable|file|max:10240',
        ]);

        $filePath = null;
        if ($request->hasFile('attachment')) {
            $filePath = $request->file('attachment')->store('attachments', 'public');
        }

        Message::create([
            'sender_id' => $employee->id,
            'recipient_id' => $message->sender_id,
            'subject' => 'Re: ' . $message->subject,
            'body' => $validated['body'],
            'attachment' => $filePath,
            'is_read' => false,
        ]);

        return redirect()->route('messages.show', $message)->with('success', 'Réponse envoyée avec succès.');

        
    }

    /**
     * 🔹 Suppression d’un message
     */
    public function destroy(Message $message)
    {
        if ($message->attachment && Storage::disk('public')->exists($message->attachment)) {
            Storage::disk('public')->delete($message->attachment);
        }

        $message->delete();

        return redirect()->route('messages.index')->with('success', 'Message supprimé avec succès.');
    }
}




