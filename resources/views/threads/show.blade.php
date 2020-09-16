@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="level">
                            <span class="flex">
                                <a href="{{ route('profile', $thread->creator->name) }}">{{ $thread->creator->name }}</a>
                        posted: {{ __($thread->title) }}
                            </span>
                            @can('update', $thread)
                                <form action="{{ $thread->path() }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            @endcan
                        </div>
                    </div>

                    <div class="card-body">
                        {{$thread->body}}
                    </div>
                </div><!-- end of card -->

                @foreach($replies as $reply)
                    @include('threads.reply')
                @endforeach
                {{ $replies->links() }}
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <p>
                            This thread was published {{ $thread->created_at->diffForHumans() }} by
                            <a href="#">{{ $thread->creator->name }}</a>,
                            and currently
                            has {{ $thread->replies_count }} {{ str_plural('comment', $thread->replies_count) }}
                        </p>
                    </div>
                </div><!-- end of card -->
            </div>
        </div>

        @if(auth()->check())
            <div class="row mt-3 mb-lg-5">
                <div class="col-md-8">
                    <form action="{{ $thread->path() . '/replies' }}" method="post">
                        @csrf
                        <div class="form-group">
                            <textarea name="body" id="body" class="form-control" placeholder="Leave a comment"
                                      rows="5"></textarea>
                        </div>
                        <button class="btn btn-success btn-sm" type="submit">Submit</button>
                    </form>
                </div>
            </div>
        @else
            <p class="lead text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in this
                discussion. </p>
        @endif
    </div>
@endsection
