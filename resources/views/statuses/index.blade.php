@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <H4 class="text-lg-center">Statuses</H4>
                @csrf
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">created_at</th>
                        <th scope="col">updated_at</th>
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
                                    <a href="{{route('taskStatus.show',['id' =>$status->id])}}">{{{$status->name}}}</a>
                                @endif
                            </td>
                            <td>{{{$status->created_at}}}</td>
                            <td>{{{$status->updated_at}}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div style="margin-top: 15px" class="d-flex justify-content-center">
                    {{ $statuses->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
