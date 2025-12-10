<?php

namespace App\Http\Controllers;

use App\Models\Filiale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FilialeController extends Controller
{
    public function index(Request $request)
    {
        $query = Filiale::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $filiales = $query->orderBy('name')->paginate(10);
        return view('filiales.index', compact('filiales'));
    }

    public function create()
    {
        return view('filiales.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Filiale::create($request->all());
        return redirect()->route('filiales.index')->with('success', 'Filiale crÃ©Ã©e avec succÃ¨s.');
    }

    public function edit(Filiale $filiale)
    {
        return view('filiales.edit', compact('filiale'));
    }

    public function update(Request $request, Filiale $filiale)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $filiale->update($request->all());
        return redirect()->route('filiales.index')->with('success', 'Filiale mise Ã  jour.');
    }

    public function destroy(Filiale $filiale)
    {
        $filiale->delete();
        return redirect()->route('filiales.index')->with('success', 'Filiale supprimÃ©e.');
    }
}







