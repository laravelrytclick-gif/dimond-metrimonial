<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\ProfileAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileAttachmentController extends Controller
{
    public function index(Profile $profile)
    {
        $this->authorize('update', $profile);
        
        $attachments = $profile->attachments()
            ->with('uploadedBy')
            ->latest()
            ->get()
            ->groupBy('category');

        return view('profiles.attachments.index', [
            'profile' => $profile,
            'attachments' => $attachments
        ]);
    }

    public function store(Request $request, Profile $profile)
    {
        $this->authorize('update', $profile);
        
        $validated = $request->validate([
            'category' => 'required|in:photo,biodata,id',
            'attachments.*' => 'required|file|max:10240', // 10MB max
            'description' => 'nullable|string|max:255'
        ]);

        $uploadedFiles = [];

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $originalName = $file->getClientOriginalName();
                $path = $file->store("profiles/{$profile->id}/attachments", 'public');
                
                $attachment = $profile->attachments()->create([
                    'category' => $validated['category'],
                    'file_name' => $originalName,
                    'file_path' => $path,
                    'meta' => [
                        'description' => $validated['description'] ?? null,
                        'size' => $file->getSize(),
                        'mime_type' => $file->getMimeType(),
                    ],
                    'uploaded_by' => auth()->id()
                ]);

                $uploadedFiles[] = $attachment;
            }
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Files uploaded successfully',
                'files' => $uploadedFiles
            ]);
        }

        return redirect()
            ->route('profiles.attachments.index', $profile)
            ->with('success', 'Files uploaded successfully');
    }

    public function show(Profile $profile, ProfileAttachment $attachment)
    {
        $this->authorize('view', $profile);
        
        if ($attachment->profile_id !== $profile->id) {
            abort(404);
        }

        return Storage::disk('public')->download($attachment->file_path, $attachment->file_name);
    }

    public function destroy(Profile $profile, ProfileAttachment $attachment)
    {
        $this->authorize('update', $profile);
        
        if ($attachment->profile_id !== $profile->id) {
            abort(404);
        }

        Storage::disk('public')->delete($attachment->file_path);
        $attachment->delete();

        return back()->with('success', 'Attachment deleted successfully');
    }
}