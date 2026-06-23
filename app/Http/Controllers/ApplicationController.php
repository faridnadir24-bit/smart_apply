<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    // Tampilkan riwayat lamaran milik user
    public function index()
    {
        $applications = Application::with('jobListing')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('applications.index', compact('applications'));
    }

    // Tampilkan detail lamaran
    public function show(Application $application)
    {
        // Pastikan hanya pemilik lamaran yang bisa lihat
        if ($application->user_id !== Auth::id()) {
            abort(403);
        }

        return view('applications.show', compact('application'));
    }

    // Batalkan lamaran
    public function destroy(Application $application)
    {
        // Pastikan hanya pemilik lamaran yang bisa batalkan
        if ($application->user_id !== Auth::id()) {
            abort(403);
        }

        // Hanya bisa batal kalau masih pending
        if ($application->status !== 'pending') {
            return redirect()->route('applications.index')
                ->with('error', 'Lamaran tidak bisa dibatalkan karena sudah diproses!');
        }

        $application->delete();

        return redirect()->route('applications.index')
            ->with('success', 'Lamaran berhasil dibatalkan!');
    }
}