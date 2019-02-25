@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <H4 class="text-lg-center">Tasks</H4>
                @csrf
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Status</th>
                            <th scope="col">Creator</th>
                            <th scope="col">Assigned to</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($tasks as $task)
                            <tr>
                                <th scope="row">{{{$task->id}}}</th>
                                <td>{{{$task->name}}}</td>
                                <td>{{{$task->description}}}</td>
                                <td>{{{$task->status->name}}}</td>
                                <td>{{{$task->creator->name}}}</td>
                                <td>{{{$task->assignedTo->name}}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div style="margin-top: 15px" class="d-flex justify-content-center">
                        {{ $tasks->links() }}
                    </div>
            </div>

            <div class="col-md-4">
                <a href="{{route('task.create')}}" class="btn btn-success btn-lg">Create task status</a>
            </div>
        </div>
    </div>
@endsection
