<?php

namespace App\Http\Controllers;

use App\Models\CoverLetter;
use App\Models\JobListing;
use App\Services\GroqService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoverLetterController extends Controller
{
    public function __construct(protected GroqService $groq)
    {
       // middleware sudah dihandle di routes/web.php 
    }

    /**
     * Halaman form generate surat manual (tanpa job_id).
     */
    public function create()
    {
        $jobListings = JobListing::latest()->get();
        $profile = Auth::user()->applicantProfile;

        return view('cover-letters.create', compact('jobListings', 'profile'));
    }

    /**
     * Halaman generate surat dari halaman detail lowongan.
     */
    public function createFromJob(JobListing $jobListing)
    {
        $profile = Auth::user()->applicantProfile;

        return view('cover-letters.create', compact('jobListing', 'profile'));
    }

    /**
     * Proses generate surat lamaran via Groq API.
     */
    public function generate(Request $request)
    {
        $request->validate([
            'job_listing_id'  => 'nullable|exists:job_listings,id',
            'phone'           => 'nullable|string|max:20',
            'skills'          => 'nullable|string',
            'experience'      => 'nullable|string',
            // field manual jika tidak pilih dari dropdown
            'job_title'       => 'required_without:job_listing_id|nullable|string|max:100',
            'company_name'    => 'required_without:job_listing_id|nullable|string|max:100',
            'job_location'    => 'nullable|string|max:100',
            'job_type'        => 'nullable|string|max:50',
            'job_description' => 'nullable|string',
        ]);

        $user = Auth::user();

        // Susun biodata dari user + profile
        $biodata = [
            'name'       => $user->name,
            'email'      => $user->email,
            'phone'      => $request->phone ?? $user->applicantProfile->phone ?? '-',
            'skills'     => $request->skills ?? $user->applicantProfile->skills ?? '-',
            'experience' => $request->experience ?? $user->applicantProfile->experience ?? '-',
        ];

        // Susun data job dari DB atau input manual
        if ($request->filled('job_listing_id')) {
            $jobListing = JobListing::findOrFail($request->job_listing_id);
            $jobData = [
                'title'       => $jobListing->title,
                'company'     => $jobListing->company,
                'location'    => $jobListing->location,
                'type'        => $jobListing->type,
                'description' => $jobListing->description,
            ];
        } else {
            $jobData = [
                'title'       => $request->job_title,
                'company'     => $request->company_name,
                'location'    => $request->job_location ?? '-',
                'type'        => $request->job_type ?? '-',
                'description' => $request->job_description ?? '-',
            ];
        }

        try {
            $result = $this->groq->generateCoverLetter($biodata, $jobData);
        } catch (\RuntimeException $e) {
            return back()->withErrors(['groq' => $e->getMessage()])->withInput();
        }

        // Simpan ke database
        $coverLetter = CoverLetter::create([
            'user_id'          => $user->id,
            'job_listing_id'   => $request->job_listing_id ?? null,
            'job_title'        => $jobData['title'],
            'company_name'     => $jobData['company'],
            'content'          => $result,
        ]);

        return redirect()->route('cover-letters.show', $coverLetter)
            ->with('success', 'Surat lamaran berhasil dibuat!');
    }

    /**
     * Tampilkan hasil surat lamaran.
     */
    public function show(CoverLetter $coverLetter)
    {
        abort_if($coverLetter->user_id !== Auth::id(), 403);

        return view('cover-letters.show', compact('coverLetter'));
    }

    /**
     * Riwayat surat lamaran user.
     */
    public function index()
    {
        $coverLetters = CoverLetter::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('cover-letters.index', compact('coverLetters'));
    }

    /**
     * Hapus surat lamaran.
     */
    public function destroy(CoverLetter $coverLetter)
    {
        abort_if($coverLetter->user_id !== Auth::id(), 403);
        $coverLetter->delete();

        return redirect()->route('cover-letters.index')
            ->with('success', 'Surat lamaran dihapus.');
    }
}