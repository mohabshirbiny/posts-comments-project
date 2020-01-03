@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add new post</div>

                
                <div class="panel-body">
                    @if (is_null(Auth::user()->gender) )
                        You Have to update your gender to see the content of this page
                    @else
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form class="form-horizontal" method="POST" action="{{ route('posts.store') }}">
                        {{ csrf_field() }}
                        
                        <input type="hidden" value="{{Auth::user()->id}}" name="user_id">
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-2 control-label">Title</label>

                            <div class="col-md-8">
                            <input id="name"  type="text" class="form-control" name="title" value="{{ old('title') }}" required autofocus>

                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('national_id') ? ' has-error' : '' }}">
                            <label for="national_id" class="col-md-2 control-label">Body</label>

                            <div class="col-md-8">
                                <textarea class="form-control" rows="5" name="body" id="body"></textarea>
                                @if ($errors->has('national_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('national_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Create Post
                                </button>

                            
                            </div>
                        </div>
                    </form>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
