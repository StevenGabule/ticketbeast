@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="#">{{ $thread->creator->name }}</a>
                        posted: {{ __($thread->title) }}
                    </div>

                    <div class="card-body">
                        {{$thread->body}}
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <div class="col-md-8">
                @foreach($thread->replies as $reply)
                    @include('threads.reply')
                @endforeach
            </div>
        </div>

        @if(auth()->check())
            <div class="row justify-content-center mt-3 mb-lg-5">
                <div class="col-md-8">
                    <form action="{{ $thread->path() . '/replies' }}" method="post">
                        @csrf
                        <div class="form-group">
                            <textarea name="body" id="body" class="form-control" placeholder="Leave a comment" rows="5"></textarea>
                        </div>
                        <button class="btn btn-success btn-sm" type="submit">Submit</button>
                    </form>
                </div>
            </div>
            @else
            <p class="lead text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion. </p>
        @endif
    </div>
@endsection
