<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;

class AdminComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::with([
            'fromUser',
            'toUser',
            'reply.topic'
        ])->latest()->get();

        return view('admin.complaints.index', compact('complaints'));
    }

    public function destroy($id)
    {
        Complaint::findOrFail($id)->delete();

        return back()->with('success', 'Жалоба удалена');
    }
}
