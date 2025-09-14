<div class="card mb-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <strong>{{ $comment->user->name }}</strong>
            <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
        </div>
        <p class="mb-3">{{ $comment->content }}</p>
        
        @auth
        <div class="d-flex gap-2">
            <button class="btn btn-sm btn-outline-secondary" onclick="document.getElementById('reply-form-{{ $comment->id }}').classList.toggle('d-none')">
                Reply
            </button>
            @can('delete', $comment)
            <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
            @endcan
        </div>

        <div id="reply-form-{{ $comment->id }}" class="mt-3 d-none">
            <form action="{{ route('comments.store', $post) }}" method="POST">
                @csrf
                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                <div class="mb-2">
                    <textarea class="form-control form-control-sm" name="content" rows="2" placeholder="Write a reply..." required></textarea>
                </div>
                <button type="submit" class="btn btn-sm btn-primary">Post Reply</button>
                <button type="button" class="btn btn-sm btn-secondary" onclick="document.getElementById('reply-form-{{ $comment->id }}').classList.add('d-none')">Cancel</button>
            </form>
        </div>
        @endauth

        @if($comment->replies->count() > 0)
            <div class="mt-3 ps-4 border-start">
                @foreach($comment->replies as $reply)
                    @include('comments._comment', ['comment' => $reply])
                @endforeach
            </div>
        @endif
    </div>
</div>
