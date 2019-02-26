@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h1 class="text-center">Task</h1>
                    </div>
                    <p class="lead text-center">On this page you can create your task</p>
                    <div class="card-body">
                        @include('flash::message')
                        <form action="{{ route('task.store') }}" method="post">
                            {{ method_field('POST') }}
                            @csrf
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" required>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label text-md-right">Description</label>
                                <div class="col-md-6">
                                    <textarea id="description" class="form-control" name="description"
                                              placeholder="Write description about your task" rows="10" cols="45"></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="status_id" class="col-md-4 col-form-label text-md-right">Status</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="status_id" id="status_id">
                                        @foreach($statuses as $status)
                                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('status_id'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('status_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="assigned_to_id" class="col-md-4 col-form-label text-md-right">Assigned To</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="assigned_to_id" id="assigned_to_id">
                                        @foreach($executors as $executor)
                                            <option value="{{ $executor->id }}">{{ $executor->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('assigned_to_id'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('assigned_to_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            {{--<div class="form-group row">--}}
                                {{--<label for="tags" class="col-md-4 col-form-label text-md-right">Tags</label>--}}
                                {{--<div class="col-md-6">--}}
                                    {{--<select multiple class="form-control" name="tags" id="tags">--}}
                                        {{--@foreach($tags as $tag)--}}
                                            {{--<option value="{{ $tag->id }}">{{ $tag->name }}</option>--}}
                                        {{--@endforeach--}}
                                    {{--</select>--}}
                                    {{--@if ($errors->has('tags'))--}}
                                        {{--<span class="invalid-feedback">--}}
                                        {{--<strong>{{ $errors->first('tags') }}</strong>--}}
                                    {{--</span>--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            <div>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
