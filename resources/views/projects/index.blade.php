@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Projects Directory</h1>
        <a href="{{ route('projects.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 font-medium text-sm transition">
            + New Project
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($projects as $project)
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex flex-col justify-between hover:shadow-md transition">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $project->name }}</h2>
                    <p class="text-gray-600 text-sm mb-4">{{ Str::limit($project->description, 110) }}</p>
                    <div class="text-xs text-gray-400 mb-2">
                        📅 Timeline: {{ $project->start_date ?? 'N/A' }} to {{ $project->deadline ?? 'N/A' }}
                    </div>
                </div>
                <div class="flex justify-between items-center border-t pt-3 mt-4 text-xs">
                    <span class="text-gray-400">Owner ID: {{ $project->user_id }}</span>
                    <a href="{{ route('projects.show', $project->id) }}" class="text-indigo-600 font-bold hover:underline">
                        View Board &rarr;
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 bg-white rounded-xl border border-gray-200 text-gray-400 italic">
                No active tracking projects found.
            </div>
        @endforelse
    </div>
</div>
@endsection