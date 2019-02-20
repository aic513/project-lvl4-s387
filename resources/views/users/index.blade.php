@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <H4 class="text-lg-center">Users</H4>
                @csrf
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <th scope="row">{{{$user->id}}}</th>
                            <td>{{{$user->name}}}</td>
                            <td>{{{$user->email}}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div style="margin-top: 15px" class="d-flex justify-content-center">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
