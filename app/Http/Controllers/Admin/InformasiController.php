<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Informasi;
use Illuminate\Http\Request;

class InformasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $informasis = Informasi::orderBy('date', 'desc')->paginate(10);
        return view('admin.informasis.index', compact('informasis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.informasis.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'category' => 'required|string|max:255',
            'badge' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
            'content' => 'required|string',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        Informasi::create($validated);

        return redirect()->route('admin.informasis.index')
                        ->with('success', 'Informasi berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Informasi $informasi)
    {
        return view('admin.informasis.edit', compact('informasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Informasi $informasi)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'category' => 'required|string|max:255',
            'badge' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
            'content' => 'required|string',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        $informasi->update($validated);

        return redirect()->route('admin.informasis.index')
                        ->with('success', 'Informasi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Informasi $informasi)
    {
        $informasi->delete();

        return redirect()->route('admin.informasis.index')
                        ->with('success', 'Informasi berhasil dihapus!');
    }

    /**
     * Toggle status informasi
     */
    public function toggleStatus(Informasi $informasi)
    {
        $informasi->update(['is_active' => !$informasi->is_active]);

        return redirect()->route('admin.informasis.index')
                        ->with('success', 'Status informasi berhasil diubah!');
    }
}
