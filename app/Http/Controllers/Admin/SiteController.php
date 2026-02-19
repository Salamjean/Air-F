<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Site;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sites = Site::latest()->paginate(10);
        return view('admin.sites.index', compact('sites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sites.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:sites',
            'location' => 'nullable|string|max:255',
        ]);

        Site::create($request->all());

        return redirect()->route('admin.sites.index')
            ->with('success', 'Site créé avec succès.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Site $site)
    {
        return view('admin.sites.edit', compact('site'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Site $site)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:sites,code,' . $site->id,
            'location' => 'nullable|string|max:255',
        ]);

        $site->update($request->all());

        return redirect()->route('admin.sites.index')
            ->with('success', 'Site mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Site $site)
    {
        $site->delete();

        return redirect()->route('admin.sites.index')
            ->with('success', 'Site supprimé avec succès.');
    }
}
