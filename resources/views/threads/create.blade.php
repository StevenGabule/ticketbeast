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
                                <label for="title">Title:</label>
                                <input type="text" class="form-control" id="title" placeholder="Title" name="title">
                            </div>
                            <div class="form-group">
                                <label for="body">Description:</label>
                                <textarea name="body" id="body" class="form-control" rows="5" placeholder="Enter a description"></textarea>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-sm btn-info" type="submit">Publish</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
