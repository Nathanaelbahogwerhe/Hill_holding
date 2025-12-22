<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\Employee;
use App\Models\Filiale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Task::with(['project', 'employee', 'employee.filiale']);

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhereHas('employee', function ($q) use ($request) {
                      $q->where('first_name', 'like', '%' . $request->search . '%')
                        ->orWhere('last_name', 'like', '%' . $request->search . '%');
                  });
        }

        if ($user->hasRole('Super Admin')) {
            $tasks = $query->paginate(10);
        } elseif ($user->filiale_id) {
            $tasks = $query->whereHas('employee', function ($q) use ($user) {
                $q->where('filiale_id', $user->filiale_id)
                  ->orWhereNull('filiale_id');
            })->paginate(10);
        } else {
            $tasks = $query->whereHas('employee', function ($q) {
                $q->whereNull('filiale_id');
            })->paginate(10);
        }

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $user = Auth::user();

        if ($user->filiale_id) {
            $employees = Employee::where('filiale_id', $user->filiale_id)
                                ->orWhereNull('filiale_id')
                                ->get();
        } else {
            $employees = Employee::whereNull('filiale_id')->get();
        }

        $projects = Project::all();
        $filiales = Filiale::all();

        return view('tasks.create', compact('employees', 'projects', 'filiales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_id'    => 'required|exists:projects,id',
            'employee_id'   => 'nullable|exists:employees,id',
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'status'        => 'required|in:pending,in_progress,completed',
            'due_date'      => 'nullable|date',
            'priority'      => 'nullable|in:low,medium,high',
        ]);

        Task::create($request->all());

        return redirect()->route('tasks.index')->with('success', 'Tâche créée.');
    }

    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $user = Auth::user();

        if ($user->filiale_id) {
            $employees = Employee::where('filiale_id', $user->filiale_id)
                                ->orWhereNull('filiale_id')
                                ->get();
        } else {
            $employees = Employee::whereNull('filiale_id')->get();
        }

        $projects = Project::all();
        $filiales = Filiale::all();

        return view('tasks.edit', compact('task', 'employees', 'projects', 'filiales'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'project_id'    => 'required|exists:projects,id',
            'employee_id'   => 'nullable|exists:employees,id',
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'status'        => 'required|in:pending,in_progress,completed',
            'due_date'      => 'nullable|date',
            'priority'      => 'nullable|in:low,medium,high',
        ]);

        $task->update($request->all());

        return redirect()->route('tasks.show', $task->id)
                         ->with('success', 'Tâche mise à jour.');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Tâche supprimée.');
    }
}




