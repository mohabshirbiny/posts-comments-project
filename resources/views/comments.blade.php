<h3>Comments</h3>
    @if (Auth::check())

    <form action="" method="" class='add_comment'>
        {{ csrf_field() }}
        <input type="hidden" name="post_id"  value="{{ $post->id }}">
        <textarea class="form-control comment_body" rows="5" name="body" id="comment_body"></textarea>

        <button type="submit" class=" btn btn-success" style="float: right;">
        <span class="glyphicon glyphicon-trash"></span>Add Comment</button>
    </form> 
    
    @endif
            <div id="post-{{$post->id}}-comments">
            @forelse ($post->comments as $comment)
                
                <p><b>{{ $comment->user->name }}</b>  : {{ $comment->body }}</p>
                <hr>
            @empty
            {{-- <p>This post has no comments</p> --}}
            @endforelse
            </div>
