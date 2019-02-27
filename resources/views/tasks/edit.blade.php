@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h1 class="text-center">Task</h1>
                    </div>
                    <p class="lead text-center">On this page you can edit your task</p>
                    <div class="card-body">
                        @include('flash::message')
                        <form action="{{ route('task.update',$task->id) }}" method="post">
                            @csrf
                            @method('PATCH')
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                                           value="{{$task->name}}" required>
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
                                              placeholder="Write description about your task" rows="10" cols="45">{{$task->description}}
                                    </textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="status_id" class="col-md-4 col-form-label text-md-right">Status</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="status_id" id="status_id">
                                        @foreach($statuses as $status)
                                            <option
                                                value="{{ $status->id }}" {{ $status->id == $task->status->id ? 'selected' : '' }}>{{ $status->name }}</option>
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
                                        @if($task->assignedTo)
                                            <option value="{{ $task->assignedTo->id }}" selected>{{ $task->assignedTo->name }}</option>
                                        @endif
                                        @foreach($executors as $executor)
                                            <option
                                                value="{{ $executor->id }}" {{ $executor->id == $task->assignedTo->id ? 'selected' : '' }}>{{ $executor->name }}</option>
                                        @endforeach

                                    </select>
                                    @if ($errors->has('assigned_to_id'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('assigned_to_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="assigned_to_id" class="col-md-4 col-form-label text-md-right">Tags</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="enter tags across ','" name="tags"
                                           value="{{ $task->tags->pluck('name')->implode(', ') }}">
                                </div>
                            </div>
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
