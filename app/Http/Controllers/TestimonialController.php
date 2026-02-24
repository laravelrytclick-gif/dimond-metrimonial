<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    /**
     * Display a listing of testimonials.
     */
    public function index()
    {
        $testimonials = Testimonial::latest()->paginate(10);
        return view('testimonials.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new testimonial.
     */
    public function create()
    {
        return view('testimonials.create');
    }

    /**
     * Store a newly created testimonial.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'author' => 'required|string|max:255',
            'rating' => 'nullable|integer|min:1|max:5',
            'status' => 'nullable|string|in:active,inactive',
        ]);

        Testimonial::create($validated);

        return redirect()->route('testimonials.index')
            ->with('success', 'Testimonial created successfully.');
    }

    /**
     * Display the specified testimonial.
     */
    public function show(Testimonial $testimonial)
    {
        return view('testimonials.show', compact('testimonial'));
    }

    /**
     * Show the form for editing the specified testimonial.
     */
    public function edit(Testimonial $testimonial)
    {
        return view('testimonials.edit', compact('testimonial'));
    }

    /**
     * Update the specified testimonial.
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'author' => 'required|string|max:255',
            'rating' => 'nullable|integer|min:1|max:5',
            'status' => 'nullable|string|in:active,inactive',
        ]);

        $testimonial->update($validated);

        return redirect()->route('testimonials.index')
            ->with('success', 'Testimonial updated successfully.');
    }

    /**
     * Remove the specified testimonial.
     */
    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return redirect()->route('testimonials.index')
            ->with('success', 'Testimonial deleted successfully.');
    }

    /**
     * Approve the specified testimonial.
     */
    public function approve(Testimonial $testimonial)
    {
        $testimonial->update(['status' => 'active']);

        return redirect()->back()
            ->with('success', 'Testimonial approved successfully.');
    }

    /**
     * Feature the specified testimonial.
     */
    public function feature(Testimonial $testimonial)
    {
        $testimonial->update(['featured' => true]);

        return redirect()->back()
            ->with('success', 'Testimonial featured successfully.');
    }
}
