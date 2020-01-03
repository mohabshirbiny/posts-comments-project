@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Timeline</div>

                <div class="panel-body" >
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @auth
                        @if (is_null(Auth::user()->gender) )
                            You Have to update your gender to see the content of this page
                        @else
                           @include('posts.all_posts')
                        @endif
                    @endauth
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
