@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <H4 class="text-lg-center">Statuses</H4>
                @csrf
                @include('flash::message')
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">created_at</th>
                        <th scope="col">updated_at</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($statuses as $status)
                        <tr>
                            <th scope="row">{{{$status->id}}}</th>
                            <td>
                                @if ($status->is_editable == 0)
                                    {{$status->name}}
                                @else
                                    <a href="{{route('taskStatus.edit',$status->id)}}">{{{$status->name}}}</a>
                                @endif
                            </td>
                            <td>{{{$status->created_at}}}</td>
                            <td>{{{$status->updated_at}}}</td>
                            <td>
                                @if ($status->is_editable == 0)
                                    <a href="javascript:void(0)" class="btn btn-sm btn-danger">Delete</a>
                                @else

                                    <form action="{{route('taskStatus.destroy',['id' =>$status->id])}}" method="POST">
                                        {{ method_field('DELETE') }}
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div style="margin-top: 15px" class="d-flex justify-content-center">
                    {{ $statuses->links() }}
                </div>
            </div>
            <div class="col-md-4">
                <a href="{{route('taskStatus.create')}}" class="btn btn-success btn-lg">Create task status</a>
            </div>

        </div>
    </div>
@endsection
