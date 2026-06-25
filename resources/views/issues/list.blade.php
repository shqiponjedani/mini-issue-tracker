@forelse($issues as $issue)
    <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:border-indigo-300 transition-all duration-200">
        <div class="flex justify-between items-start">
            <h3 class="font-bold text-gray-900 text-lg hover:text-indigo-600 transition">
                <a href="{{ route('issues.show', $issue->id) }}">{{ $issue->title }}</a>
            </h3>
            <span class="px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider rounded border 
                {{ $issue->status === 'open' ? 'bg-green-50 text-green-700 border-green-200' : 
                   ($issue->status === 'in_progress' ? 'bg-blue-50 text-blue-700 border-blue-200' : 'bg-gray-100 text-gray-600 border-gray-200') }}">
                {{ str_replace('_', ' ', $issue->status) }}
            </span>
        </div>
        <div class="flex -space-x-2">
    @foreach($issue->users as $user)
        <div title="{{ $user->name }}" class="w-6 h-6 rounded-full bg-indigo-500 text-white flex items-center justify-center text-[9px] border-2 border-white font-bold cursor-help">
            {{ substr($user->name, 0, 1) }}
        </div>
    @endforeach
</div>

        <p class="text-sm text-gray-600 mt-2 line-clamp-2">{{ $issue->description }}</p>

        <div class="mt-4 flex items-center justify-between">
            <div class="flex flex-wrap gap-1">
                @foreach($issue->tags as $tag)
                    <span class="text-[10px] font-medium bg-gray-100 text-gray-600 px-2 py-0.5 rounded">
                        {{ $tag->name }}
                    </span>
                @endforeach
            </div>
            <div class="text-[11px] font-bold text-gray-400 uppercase">
                ⚠️ {{ $issue->priority }}
            </div>
        </div>
    </div>
@empty
    <div class="col-span-full py-10 text-center bg-gray-50 rounded-xl border border-dashed border-gray-300">
        <p class="text-gray-500 font-medium">No issues found matching your current filters.</p>
        <a href="{{ route('issues.index') }}" class="text-indigo-600 text-sm font-semibold hover:underline">Clear all filters</a>
    </div>
@endforelse