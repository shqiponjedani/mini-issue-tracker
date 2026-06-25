@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <div class="lg:col-span-2 space-y-6">
        <div>
            <a href="{{ route('projects.show', ['project' => $issue->project_id, 'impersonate' => request('impersonate')]) }}" class="text-xs text-indigo-600 font-medium hover:underline">← Return to Project Dashboard</a>
            <h1 class="text-2xl font-bold text-gray-900 mt-1">{{ $issue->title }}</h1>
            <p class="text-xs text-gray-400 mt-0.5">Target Due Date: {{ $issue->due_date ?? 'No hard limit' }}</p>
        </div>

        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Issue Diagnostic Summary</h4>
            <p class="text-sm text-gray-700 whitespace-pre-line leading-relaxed">{{ $issue->description }}</p>
        </div>

        @include('comments.thread', ['issue' => $issue])

    </div>

    <div class="space-y-6">
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-4">
            <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider border-b pb-2">Properties Map</h3>
            
            <div class="space-y-3 text-xs">
                <div>
                    <span class="text-gray-400 block mb-1">Workflow Pipeline Status:</span>
                    <span class="px-2.5 py-0.5 rounded font-bold uppercase tracking-wide text-[10px] bg-gray-100 text-gray-700 border">
                        {{ $issue->status }}
                    </span>
                </div>
                <div>
                    <span class="text-gray-400 block mb-1">Priority Rank Metrics:</span>
                    <span class="font-extrabold uppercase text-gray-900 tracking-wider">
                        ⚠️ {{ $issue->priority }}
                    </span>
                </div>
            </div>

            <div class="pt-4 border-t space-y-2">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Tags (Toggle via AJAX)</span>
                <div class="flex flex-wrap gap-2">
                    @foreach($allTags as $tag)
                        <label class="flex items-center gap-1.5 cursor-pointer bg-gray-50 px-2 py-1 rounded-md border text-[11px] hover:bg-gray-100 transition">
                            <input type="checkbox" 
                                   class="tag-toggle-checkbox text-indigo-600 rounded border-gray-300 focus:ring-indigo-500" 
                                   data-tag-id="{{ $tag->id }}"
                                   {{ $issue->tags->contains($tag->id) ? 'checked' : '' }}>
                            <span class="font-medium text-gray-700">{{ $tag->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="pt-4 border-t space-y-2">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Assigned Members (AJAX)</span>
                <div class="space-y-1.5 max-h-[150px] overflow-y-auto pr-1">
                    @foreach(\App\Models\User::all() as $user)
                        <label class="flex items-center gap-2 cursor-pointer bg-gray-50 p-1.5 rounded-lg border text-[11px] hover:bg-gray-100 transition w-full">
                            <input type="checkbox" 
                                   class="user-toggle-checkbox text-indigo-600 rounded border-gray-300 focus:ring-indigo-500" 
                                   data-user-id="{{ $user->id }}"
                                   {{ $issue->users->contains($user->id) ? 'checked' : '' }}>
                            <span class="text-gray-700 font-medium">👤 {{ $user->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="pt-4 border-t">
                <a href="{{ route('issues.edit', ['issue' => $issue->id, 'impersonate' => request('impersonate')]) }}" class="block text-center w-full bg-gray-900 text-white py-2 rounded-lg text-xs font-bold hover:bg-black transition">
                    🔧 Adjust Task Variables
                </a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const issueId = "{{ $issue->id }}";

    document.querySelectorAll('.tag-toggle-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            const tagId = this.getAttribute('data-tag-id');

            axios.post(`/issues/${issueId}/toggle-tag`, { tag_id: tagId })
                .then(response => {
                    console.log("Tag state updated successfully.", response.data);
                })
                .catch(err => {
                    console.error("AJAX Error updating tag status:", err);
                    this.checked = !this.checked;
        });
    });

 
    document.querySelectorAll('.user-toggle-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            const userId = this.getAttribute('data-user-id');

            axios.post(`/issues/${issueId}/toggle-user`, { user_id: userId })
                .then(response => {
                    console.log("User assignment state toggled.", response.data);
                })
                .catch(err => {
                    console.error("AJAX Error toggling secure channel assignment:", err);
                    this.checked = !this.checked;
                });
        });
    });
});
</script>
@endsection