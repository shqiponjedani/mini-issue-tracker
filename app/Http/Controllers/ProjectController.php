<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use Illuminate\Support\Facades\Gate;

class ProjectController extends Controller
{
    //
    public function index()
    {
        $projects = Project::latest()->get();
        return view('projects.index', compact('projects'));
    }

    public function create() { return view('projects.create'); }

    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id() ?? 1;
        Project::create($request->validated());
        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    public function show($id)
    {
       
        $project = Project::with('issues')->findOrFail($id);
        return view('projects.show', compact('project'));
    }

  public function edit(Project $project) 
{ 
    Gate::authorize('update', $project);
    return view('projects.edit', compact('project')); 
}

public function update(StoreProjectRequest $request, Project $project)
{
    Gate::authorize('update', $project);
    $project->update($request->validated());
    return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
}

   public function destroy(Project $project)
{
    Gate::authorize('delete', $project);
    $project->delete();
    return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
}
}
