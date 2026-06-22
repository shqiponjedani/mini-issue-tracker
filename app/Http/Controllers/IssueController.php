<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateIssueRequest;
use Illuminate\Http\Request;
use App\Models\Issue;
use App\Models\Project;
use App\Models\Tag;
use App\Http\Requests\StoreIssueRequest;

class IssueController extends Controller
{
   public function index(Request $request)
    {
      
        $query = Issue::with(['project', 'tags']);

        if ($request->filled('search')) {
        $searchTerm = $request->search;
        $query->where(function ($q) use ($searchTerm) {
            $q->where('title', 'like', '%' . $searchTerm . '%')
              ->orWhere('description', 'like', '%' . $searchTerm . '%');
        });
    }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }
        if ($request->filled('tag_id')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('tags.id', $request->tag_id);
            });
        }

        $issues = $query->latest()->get();
        $tags = Tag::all(); 

        return view('issues.index', compact('issues', 'tags'));
    }

    public function create()
    {
        $projects = Project::all();
        return view('issues.create', compact('projects'));
    }

    public function store(StoreIssueRequest $request)
    {
        Issue::create($request->validated());
        return redirect()->route('issues.index')->with('success', 'Issue created.');
    }

    public function show($id)
    {
     
        $issue = Issue::with('tags','users')->findOrFail($id);
        $allTags = Tag::all(); 
        return view('issues.show', compact('issue', 'allTags'));
    }

    public function edit(Issue $issue)
    {
        $projects = Project::all();
        return view('issues.edit', compact('issue', 'projects'));
    }

    public function update(UpdateIssueRequest $request, Issue $issue)
    {
        $issue->update($request->validated());
        return redirect()->route('issues.index')->with('success', 'Issue updated.');
    }

    public function destroy(Issue $issue)
    {
        $issue->delete();
        return redirect()->route('issues.index')->with('success', 'Issue deleted.');
    }

   
    public function toggleTag(Request $request, Issue $issue)
    {
        $request->validate(['tag_id' => 'required|exists:tags,id']);
        
       
        $issue->tags()->toggle($request->tag_id);

        return response()->json([
            'success' => true,
            'attached' => $issue->tags()->where('tags.id', $request->tag_id)->exists(),
            'tags' => $issue->tags
        ]);
    }
    public function toggleUser(Request $request, Issue $issue)
{
    $request->validate([
        'user_id' => 'required|exists:users,id'
    ]);

    $issue->users()->toggle($request->user_id);

    return response()->json([
        'success' => true,
        'users' => $issue->users
    ]);
}
}
