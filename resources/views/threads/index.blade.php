@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                @forelse($threads as $thread)
                    <div class="card mt-3">
                        <div class="card-body">
                            <article>
                                <div class="level">
                                    <h4 class="flex">
                                        <a href="{{ $thread->path() }}" class="btn-link">{{ $thread->title }}</a>
                                    </h4>
                                    <a href="{{$thread->path()}}">{{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}</a>
                                </div>
                                <div class="body">
                                    {{$thread->body}}
                                </div>
                            </article>
                        </div><!-- end of card body -->
                    </div><!-- end of card -->
                @empty
                    <p>There are no relevant results at this time.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
