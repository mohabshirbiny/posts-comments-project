@forelse ($posts as $post)

<div class="card mb-4" id="post-{{$post->id}}">
    <div class="card-body">
        <h2 class="card-title" id="post-title-{{$post->id}}">{{ $post->title }}</h2>
        <p class="card-text" id="post-body-{{$post->id}}">{{ $post->body }}</p>
    </div>
    <br>

    <div class="row">
        <div class="col-md-8">
            Posted on {{ date_format($post->created_at,'M d,Y') }} by <b>{{ $post->user->name }}</b>
        </div>

        {{-- user can only update and delete his posts --}}
        @if (in_array($post->id,Auth::user()->posts()->pluck('id')->Toarray()))
            <div class="col-md-2">
                <button class="edit-modal btn btn-info" data-id="{{$post->id}}" data-title="{{$post->title}}" data-content="{{$post->body}}">
                <span class="glyphicon glyphicon-edit"></span> Edit</button>
            </div>
            <div class="col-md-2">
                <form action="" method="delete" class="delete_post" id='delete_post'>
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <input type="hidden" name="post_id" value="{{ $post->id }}">

                    <button type="submit" class="delete-modal btn btn-danger">
                    <span class="glyphicon glyphicon-trash delete_post"></span> Delete</button>
                </form> 
            </div>
        @endif
    </div>
    @include('comments')

    

</div>
<br>
<hr>
@empty
    <p>No posts</p>
@endforelse


<!-- Modal form to edit a form -->
<div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="id">ID:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="id_edit" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="title">Title:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="title_edit" autofocus>
                            <p class="errorTitle text-center alert alert-danger hidden"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="content">Content:</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="content_edit" cols="40" rows="5"></textarea>
                            <p class="errorContent text-center alert alert-danger hidden"></p>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary edit" data-dismiss="modal">
                        <span class='glyphicon glyphicon-check'></span> Edit
                    </button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                        <span class='glyphicon glyphicon-remove'></span> Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


@section('js')
    <script>
        $(".delete_post").click(function(e){

            e.preventDefault();

            if(confirm("Are You sure that you want to delete this post ?")){
                var id = this.post_id.value;
                var token = this._token.value ;
                $.ajax(
                {
                    url: "{{url('posts')}}"+"/"+id,
                    type: 'DELETE',
                    dataType: "JSON",
                    data: {
                        "id": id,
                        "_method": 'DELETE',
                        "_token": token,
                    },
                    success: function ()
                    {
                        $('#post-'+id).show(0).delay(500).hide(0);
                    }
                });
            }
            e.preventDefault();
        });


        /*************************   ***********************************/
        $(".add_comment").on('submit',function(e){

            e.preventDefault();

            $.ajax(
            {
                url: "{{route('comments.store')}}",
                type: 'POST',
                dataType: "JSON",
                data: $(this).serialize(),
                success: function (data)
                {  
                    $("#post-"+data.post_id+"-comments").append("<p><b>{{Auth::user()->name}}</b> : "+data.body+"</p><hr>");
                    $(".comment_body" ).val('');
                    $(".comment_body" ).empty();
                    $('.comment_body').attr("value", "");
                    // $('#id_edit').val();
                }
            });
            e.preventDefault();
        });

        /******************* Edit a post ******************************/
        $(document).on('click', '.edit-modal', function() {
            $('.modal-title').text('Edit');
            $('#id_edit').val($(this).data('id'));
            $('#title_edit').val($(this).data('title'));
            $('#content_edit').val($(this).data('content'));
            id = $('#id_edit').val();
            $('#editModal').modal('show');
        });
        $('.modal-footer').on('click', '.edit', function() {
            $.ajax({
                type: 'PUT',
                url: 'posts/' + id,
                data: {
                    '_token': $('input[name=_token]').val(),
                    'id': $("#id_edit").val(),
                    'title': $('#title_edit').val(),
                    'body': $('#content_edit').val()
                },
                success: function(data) {
                    $('.errorTitle').addClass('hidden');
                    $('.errorContent').addClass('hidden');

                    if ((data.errors)) {
                        setTimeout(function () {
                            $('#editModal').modal('show');
                            toastr.error('Validation error!', 'Error Alert', {timeOut: 5000});
                        }, 500);

                        if (data.errors.title) {
                            $('.errorTitle').removeClass('hidden');
                            $('.errorTitle').text(data.errors.title);
                        }
                        if (data.errors.content) {
                            $('.errorContent').removeClass('hidden');
                            $('.errorContent').text(data.errors.content);
                        }
                    } else {
                        $('#post-title-' + data.id).html(data.title);
                        $('#post-body-' + data.id).html(data.body);                            
                    }
                }
            });
        });
        /*************************************************************/

    </script>
@endsection