<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Filiale;
use Illuminate\Http\Request;

class FilialeApiController extends Controller
{
    public function index()
    {
        return response()->json(Filiale::all(), 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255|unique:filiales,name',
            'address' => 'nullable|string|max:255',
            'phone'   => 'nullable|string|max:30',
        ]);
        $f = Filiale::create($data);
        return response()->json($f, 201);
    }

    public function show(Filiale $filiale)
    {
        return response()->json($filiale, 200);
    }

    public function update(Request $request, Filiale $filiale)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255|unique:filiales,name,'.$filiale->id,
            'address' => 'nullable|string|max:255',
            'phone'   => 'nullable|string|max:30',
        ]);
        $filiale->update($data);
        return response()->json($filiale, 200);
    }

    public function destroy(Filiale $filiale)
    {
        $filiale->delete();
        return response()->json(['message' => 'Filiale supprimée'], 200);
    }

    /**
     * Retourne les agences d'une filiale
     */
    public function agences(Filiale $filiale)
    {
        return response()->json($filiale->agences()->get(['id', 'name']), 200);
    }

    /**
     * Retourne les départements d'une filiale
     */
    public function departments(Filiale $filiale)
    {
        return response()->json($filiale->departments()->get(['id', 'name']), 200);
    }
}




