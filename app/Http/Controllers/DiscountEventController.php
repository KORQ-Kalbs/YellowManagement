<?php

namespace App\Http\Controllers;

use App\Models\DiscountEvent;
use Illuminate\Http\Request;

class DiscountEventController extends Controller
{
    public function index()
    {
        $events = DiscountEvent::latest()->paginate(10);
        return view('admin.event-diskon.index', compact('events'));
    }

    public function create()
    {
        return view('admin.event-diskon.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        DiscountEvent::create($validated);

        return redirect()->route('admin.event-diskon.index')->with('success', 'Discount Event created successfully.');
    }

    public function edit(DiscountEvent $event_diskon)
    {
        return view('admin.event-diskon.edit', ['event' => $event_diskon]);
    }

    public function update(Request $request, DiscountEvent $event_diskon)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $event_diskon->update($validated);

        return redirect()->route('admin.event-diskon.index')->with('success', 'Discount Event updated successfully.');
    }

    public function destroy(DiscountEvent $event_diskon)
    {
        $event_diskon->delete();
        return redirect()->route('admin.event-diskon.index')->with('success', 'Discount Event deleted successfully.');
    }
}
