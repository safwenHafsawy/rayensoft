<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class MessagesController extends Controller
{
    public function index() {
        return view('messages.index');
    }

    public function details(Message $message) {
        $message->update(['status' => 'read']);
        return view('messages.details', compact('message'));
    }
}
