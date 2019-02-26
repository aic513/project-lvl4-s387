@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <H4 class="text-lg-center">Tasks</H4>
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
                            <td>{{{$task->creator->name}}}</td>
                            <td>{{{$task->assignedTo->name}}}</td>
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
