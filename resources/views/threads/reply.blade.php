<div class="card mb-3 mt-3" id="reply-{{$reply->id}}">
    <div class="card-header">
        <div class="level">
            <h5 class="flex">
                <a href="{{ route('profile', $reply->owner->name) }}">{{ $reply->owner->name }} </a> said {{ $reply->created_at->diffForHumans() }}
            </h5>
            <div>
                <form method="post" action="/replies/{{$reply->id}}/favorites">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-dark" {{ $reply->isFavorited() ? 'disabled': '' }}>
                        {{ $reply->favorites_count}} {{str_plural('Favorite', $reply->favorites_count) }}
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        {{$reply->body}}
    </div>
    @can('update', $reply)
    <div class="card-footer">
        <form action="/replies/{{$reply->id}}" method="post">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger" type="submit">Delete</button>
        </form>
    </div>
    @endcan
</div>
