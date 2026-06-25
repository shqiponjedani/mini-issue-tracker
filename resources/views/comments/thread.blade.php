<div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-6">
    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
        💬 Discussion Thread
    </h3>

  
    <form id="ajax-comment-form" class="space-y-3 border-b pb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <div class="md:col-span-1">
                <input type="text" id="comment-author" required placeholder="Your Name" 
                    class="w-full rounded-lg border-gray-300 p-2 text-sm border focus:ring-2 focus:ring-indigo-500">
            </div>
            <div class="md:col-span-2">
                <input type="text" id="comment-body" required placeholder="Type your comment here..." 
                    class="w-full rounded-lg border-gray-300 p-2 text-sm border focus:ring-2 focus:ring-indigo-500">
            </div>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-indigo-600 text-white px-4 py-1.5 rounded-lg text-xs font-semibold hover:bg-indigo-700 transition">
                Post Comment
            </button>
        </div>
    </form>

  
    <div id="comments-wrapper" class="space-y-4 max-h-[400px] overflow-y-auto pr-2">
        <p id="comments-loading" class="text-xs text-gray-400 italic text-center py-4">Fetching historical logs...</p>
    </div>


    <div class="text-center pt-2">
        <button id="load-more-comments-btn" class="hidden text-xs text-indigo-600 font-bold hover:underline">
            🔄 Load Older Thread Comments
        </button>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const issueId = "{{ $issue->id }}";
        const wrapper = document.getElementById('comments-wrapper');
        const loadingText = document.getElementById('comments-loading');
        const loadMoreBtn = document.getElementById('load-more-comments-btn');
        let nextPageUrl = `/issues/${issueId}/comments`;

      
function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
     
        function appendCommentNode(comment, prepend = false) {
            const placeholder = wrapper.querySelector('p');
            if (placeholder && placeholder.textContent.includes("No logged discussions")) {
                placeholder.remove();
            }

            const timestamp = new Date(comment.created_at).toLocaleString();
            const elementStr = `
                <div class="p-3 bg-gray-50 rounded-lg border border-gray-100 transition hover:bg-gray-100/50">
                    <div class="flex justify-between items-center text-[11px] text-gray-400 mb-1">
                        <span class="font-bold text-gray-700">👤 ${escapeHtml(comment.author_name || 'Anonymous')}</span>
                        <span>${timestamp}</span>
                    </div>
                    <p class="text-xs text-gray-600 leading-relaxed">${escapeHtml(comment.body)}</p>
                </div>
            `;
            if (prepend) {
                wrapper.insertAdjacentHTML('afterbegin', elementStr);
            } else {
                wrapper.insertAdjacentHTML('beforeend', elementStr);
            }
        }


        document.getElementById('ajax-comment-form').addEventListener('submit', function (e) {
            e.preventDefault();
            const authorInput = document.getElementById('comment-author');
            const bodyInput = document.getElementById('comment-body');

            if (!authorInput.value.trim() || !bodyInput.value.trim()) return;

           
            axios.post(`/issues/${issueId}/comments`, {
                author_name: authorInput.value,
                body: bodyInput.value
            }, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(function(response) {
                appendCommentNode(response.data.comment, true);
                bodyInput.value = '';
            })
            .catch(function(err) {
                console.error("AJAX Error:", err);
                alert("Failed to post comment.");
            });
        });
    });
</script>