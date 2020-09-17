<reply inline-template :attributes="{{ $reply }}" v-cloak>
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
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control form-control-sm" name="body" v-model="body"></textarea>
                </div>
                <button class="btn btn-sm btn-primary" @click="update">Update</button>
                <button class="btn btn-sm btn-dark" @click="editing = false">Cancel</button>
            </div>
            <div v-else v-text="body"></div>
        </div>
        @can('update', $reply)
            <div class="card-footer">
                <div class="d-flex">
                    <button class="btn-info btn btn-sm" @click="editing = true">Edit</button>
                    <form action="/replies/{{$reply->id}}" method="post" class="ml-2">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                    </form>
                </div>
            </div>
        @endcan
    </div>

</reply>
