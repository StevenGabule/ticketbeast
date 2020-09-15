@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Create a new thread') }}</div>

                    <div class="card-body">
                        <form action="{{ route('threads.store') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="channel_id">Choose a channel:</label>
                                <select name="channel_id" required id="channel_id" class="form-control">
                                    <option value="">Choose one...</option>
                                    @foreach($channels as $channel)
                                        <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : '' }}>
                                            {{ $channel->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" required value="{{ old('title') }}" class="form-control" id="title"
                                       placeholder="Title" name="title">
                            </div>
                            <div class="form-group">
                                <label for="body">Description:</label>
                                <textarea name="body" id="body" required class="form-control" rows="5"
                                          placeholder="Enter a description">{{ old('body') }}</textarea>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-sm btn-info" type="submit">Publish</button>
                            </div>
                        </form>
                        @if(count($errors))
                            <ul class="alert alert-danger">
                                @foreach($errors->all()  as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
