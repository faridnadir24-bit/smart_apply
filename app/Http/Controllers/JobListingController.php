<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobListingController extends Controller
{
    // Tampilkan semua lowongan
    public function index(Request $request)
    {
        $query = JobListing::query();

        // Fitur search
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('company', 'like', '%' . $request->search . '%')
                  ->orWhere('location', 'like', '%' . $request->search . '%');
            });
        }

        // Fitur filter tipe
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        // Fitur filter lokasi
        if ($request->has('location') && $request->location != '') {
            $query->where('location', $request->location);
        }

        // Fitur sortir
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'oldest':
                    $query->oldest();
                    break;
                case 'salary_high':
                    $query->orderBy('salary', 'asc');
                    break;
                case 'salary_low':
                    $query->orderBy('salary', 'desc');
                    break;
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }

        $jobs = $query->paginate(6);

        return view('jobs.index', compact('jobs'));
    }

    // Tampilkan detail lowongan
    public function show(JobListing $jobListing)
    {
        $hasApplied = false;

        if (Auth::check()) {
            $hasApplied = Application::where('user_id', Auth::id())
                ->where('job_listing_id', $jobListing->id)
                ->exists();
        }

        return view('jobs.show', compact('jobListing', 'hasApplied'));
    }

    // Proses submit lamaran
    public function apply(Request $request, JobListing $jobListing)
    {
        // Cek sudah pernah melamar
        $alreadyApplied = Application::where('user_id', Auth::id())
            ->where('job_listing_id', $jobListing->id)
            ->exists();

        if ($alreadyApplied) {
            return redirect()->back()->with('error', 'Kamu sudah melamar pekerjaan ini!');
        }

        $request->validate([
            'cover_letter' => 'required|min:20',
            'expected_salary' => 'nullable|string|max:100',
        ]);

        Application::create([
            'user_id' => Auth::id(),
            'job_listing_id' => $jobListing->id,
            'status' => 'pending',
            'cover_letter' => $request->cover_letter,
            'expected_salary' => $request->expected_salary,
        ]);

        return redirect()->route('applications.index')->with('success', 'Lamaran berhasil dikirim!');
    }
}