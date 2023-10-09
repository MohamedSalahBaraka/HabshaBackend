<?php

namespace App\Http\Controllers\AdminArea;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function Message()
    {
        $Messages = Message::orderBy('created_at', 'desc')->paginate(40);
        $mark = Message::where('read', 0)->get();
        foreach ($mark as $m) {
            $m->read = 1;
            $m->save();
        }
        return view('AdminArea.Message.Message', compact(['Messages']));
    }
    public function MessageDelete($id)
    {
        $Message = Message::find($id);
        $Message->delete();
        return back()->with('success', 'Saved successfully');
    }
}