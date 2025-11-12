<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Setting;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agendas = Agenda::orderBy('date', 'desc')->paginate(10);
        return view('admin.agendas.index', compact('agendas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.agendas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Global upload settings
        $maxKb = (int) (Setting::get('upload_max_file_size', 10240) ?? 10240); // Default 10MB
        $allowed = (string) (Setting::get('upload_allowed_extensions', 'jpg,jpeg,png,gif') ?? 'jpg,jpeg,png,gif');
        $allowedMimes = implode(',', array_map('trim', explode(',', $allowed)));

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'purpose' => 'nullable|string',
            'participants' => 'nullable|string',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'image' => 'nullable|image|mimes:' . $allowedMimes . '|max:' . $maxKb,
            'category' => 'required|string|max:255',
        ]);

        // Set is_active: true if checkbox is checked, false otherwise
        $validated['is_active'] = $request->has('is_active') ? true : false;

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/agendas'), $imageName);
            $validated['image'] = 'images/agendas/' . $imageName;
        }

        Agenda::create($validated);

        return redirect()->route('admin.agendas.index')
                        ->with('success', 'Agenda berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Agenda $agenda)
    {
        return view('admin.agendas.edit', compact('agenda'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Agenda $agenda)
    {
        // Global upload settings
        $maxKb = (int) (Setting::get('upload_max_file_size', 10240) ?? 10240); // Default 10MB
        $allowed = (string) (Setting::get('upload_allowed_extensions', 'jpg,jpeg,png,gif') ?? 'jpg,jpeg,png,gif');
        $allowedMimes = implode(',', array_map('trim', explode(',', $allowed)));

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'purpose' => 'nullable|string',
            'participants' => 'nullable|string',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'image' => 'nullable|image|mimes:' . $allowedMimes . '|max:' . $maxKb,
            'category' => 'required|string|max:255',
        ]);

        // Set is_active: true if checkbox is checked, false otherwise
        $validated['is_active'] = $request->has('is_active') ? true : false;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($agenda->image && file_exists(public_path($agenda->image))) {
                unlink(public_path($agenda->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/agendas'), $imageName);
            $validated['image'] = 'images/agendas/' . $imageName;
        }

        $agenda->update($validated);

        return redirect()->route('admin.agendas.index')
                        ->with('success', 'Agenda berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agenda $agenda)
    {
        // Delete image if exists
        if ($agenda->image && file_exists(public_path($agenda->image))) {
            unlink(public_path($agenda->image));
        }
        
        $agenda->delete();

        return redirect()->route('admin.agendas.index')
                        ->with('success', 'Agenda berhasil dihapus!');
    }

    /**
     * Toggle status agenda
     */
    public function toggleStatus(Agenda $agenda)
    {
        $agenda->update(['is_active' => !$agenda->is_active]);

        return redirect()->route('admin.agendas.index')
                        ->with('success', 'Status agenda berhasil diubah!');
    }
}
