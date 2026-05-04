<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;

class AdminSupportController extends Controller
{
    public function index()
    {
        $tickets = SupportTicket::with('user')
            ->latest()
            ->get();

        return view('admin.support.index', compact('tickets'));
    }
}