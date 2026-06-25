@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-start">
        <div>
            <a href="{{ route('projects.index') }}" class="text-sm text-indigo-600 hover:underline">← Back to Workspace Directory</a>
            <h1 class="text-3xl font-bold text-gray-900 mt-1">{{ $project->name }}</h1>
            <p class="text-xs text-gray-400 mt-1">📅 Active Run: {{ $project->start_date ?? 'N/A' }} thru {{ $project->deadline ?? 'N/A' }}</p>
        </div>
        <div class="flex gap-2">
            @if(auth()->check() && auth()->id() === $project->user_id)
                <a href="{{ route('projects.edit', $project->id) }}" class="bg-gray-100 border text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 font-medium text-sm transition">
                    🔧 Edit Project
                </a>
                <form action="{{ route('projects.destroy', ['project' => $project->id, 'impersonate' => request('impersonate')]) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this project?');" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-50 text-red-600 border border-red-200 px-4 py-2 rounded-lg hover:bg-red-100 font-medium text-sm transition">
                🗑️ Delete Project
            </button>
        </form>
            @endif
            <a href="{{ route('issues.create', ['project_id' => $project->id]) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 font-medium text-sm transition">
                + Add Issue
            </a>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
        <h2 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-2">Scope Manifesto</h2>
        <p class="text-gray-700 whitespace-pre-line text-sm leading-relaxed">{{ $project->description }}</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50/50">
            <h3 class="font-bold text-gray-800 text-sm uppercase tracking-wide">Tasks Tracking Layer ({{ $project->issues->count() }})</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-400 text-xs uppercase tracking-wider font-semibold border-b">
                        <th class="p-4">Issue Name</th>
                        <th class="p-4">Workflow Status</th>
                        <th class="p-4">Priority Rank</th>
                        <th class="p-4 text-right">Review Details</th>
                    </tr>
                </thead>
                <tbody class="divide-y text-sm text-gray-600">
                    @forelse($project->issues as $issue)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="p-4 font-semibold text-gray-900">{{ $issue->title }}</td>
                            <td class="p-4">
                                <span class="px-2 py-0.5 rounded text-xs font-bold uppercase
                                    @if($issue->status === 'open') bg-blue-50 text-blue-700 border border-blue-200
                                    @elseif($issue->status === 'in_progress') bg-amber-50 text-amber-700 border border-amber-200
                                    @else bg-green-50 text-green-700 border border-green-200 @endif">
                                    {{ str_replace('_', ' ', $issue->status) }}
                                </span>
                            </td>
                            <td class="p-4 uppercase text-xs font-extrabold tracking-wider text-gray-500">{{ $issue->priority }}</td>
                            <td class="p-4 text-right">
                                <a href="{{ route('issues.show', $issue->id) }}" class="text-indigo-600 font-bold hover:underline">Thread View &rarr;</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-gray-400 italic">No tasks mapped inside this project container yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection