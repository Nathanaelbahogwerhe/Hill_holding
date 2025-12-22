<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentApiController extends Controller
{
    public function index()
    {
        return response()->json(Department::with('filiale')->get(), 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255|unique:departments,name',
            'filiale_id' => 'nullable|exists:filiales,id',
        ]);
        $d = Department::create($data);
        return response()->json($d->load('filiale'), 201);
    }

    public function show(Department $department)
    {
        return response()->json($department->load('filiale'), 200);
    }

    public function update(Request $request, Department $department)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255|unique:departments,name,'.$department->id,
            'filiale_id' => 'nullable|exists:filiales,id',
        ]);
        $department->update($data);
        return response()->json($department->load('filiale'), 200);
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return response()->json(['message' => 'Département supprimé'], 200);
    }
}




