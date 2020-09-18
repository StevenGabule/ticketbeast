@extends('layouts.app')

@section('content')
    <thread-view inline-template :initial-replies-count="{{ $thread->replies_count }}">
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

                    <replies :data="{{ $thread->replies }}"
                             @added="repliesCount++"
                             @removed="repliesCount--"></replies>

                    {{ $replies->links() }}

                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <p>
                                This thread was published {{ $thread->created_at->diffForHumans() }} by
                                <a href="#">{{ $thread->creator->name }}</a>,
                                and currently
                                has <span v-text="repliesCount"></span> {{ str_plural('comment', $thread->replies_count) }}
                            </p>
                        </div>
                    </div><!-- end of card -->
                </div>
            </div>


        </div>
    </thread-view>

@endsection
