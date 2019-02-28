@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <H4 class="text-lg-center">Tasks</H4>
                <form class="mb-2" action="{{ route('task.index') }}" method="GET">
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label for="status_id">Status</label>
                            <select id="status_id" class="custom-select" name="status_id">
                                <option value="" {{ Request::get('status_id') ? '' : 'selected' }}>All</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}" {{ Request::get('status_id') === $status->id ? 'selected' : '' }}>
                                        {{ $status->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-5">
                            <label for="assigned_to_id">Assigned user</label>
                            <select id="assigned_to_id" class="custom-select" name="assigned_to_id">
                                <option value="" {{ Request::get('assigned_to_id') ? '' : 'selected' }}>All</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ Request::get('assigned_to_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="tag_id">Tag</label>
                            <select id="tag_id" class="custom-select" name="tag_id">
                                <option value="" {{ Request::get('tag_id') ? '' : 'selected' }}>All</option>
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->id }}" {{ Request::get('tag_id') === $tag->id ? 'selected' : '' }}>{{ $tag->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-9">
                            <div class="form-check">
                                <input id=is_my_task" class="form-check-input" type="checkbox" name="is_my_task" {{ Request::get('is_my_task') ? 'checked' : '' }}>
                                <label for="is_my_task" class="form-check-label">Created by me</label>
                            </div>
                        </div>
                        <div class="form-group col-md-3 d-flex justify-content-around">
                            <button type="submit" class="btn btn-outline-success">Search</button>
                            <a class="btn btn-outline-success" href="{{ route('task.index') }}">Show all</a>
                        </div>
                    </div>
                </form>
                @csrf
                @include('flash::message')
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Tags</th>
                        <th scope="col">Status</th>
                        <th scope="col">Creator</th>
                        <th scope="col">Assigned to</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($tasks as $task)

                        <tr>
                            <th scope="row">{{{$task->id}}}</th>
                            <td><a href="{{route('task.edit',$task->id)}}">{{{$task->name}}}</a></td>
                            <td>{{{$task->description}}}</td>
                            <td>{{ $task->tags->pluck('name')->implode(', ') }}</td>
                            <td>{{{$task->status->name}}}</td>
                            <td>{{{$task->creator?$task->creator->name:' deleted '}}}</td>
                            <td>{{{$task->assignedTo?$task->assignedTo->name:' deleted '}}}</td>
                            <td>
                                <form action="{{route('task.destroy',['id' =>$task->id])}}" method="POST">
                                    {{ method_field('DELETE') }}
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div style="margin-top: 15px" class="d-flex justify-content-center">
                    {{ $tasks->links() }}
                </div>
            </div>
            <div class="col-md-4">
                <a href="{{route('task.create')}}" class="btn btn-success btn-lg">Create task</a>
            </div>
        </div>
    </div>
@endsection
