@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <H4 class="text-lg-center">Users</H4>
                @csrf
                <ul class="list-group">
                    @foreach ($users as $user)
                        <li class="list-group-item"> &#8226; {{ $user->name }}</li>
                    @endforeach
                </ul>
                <div style="margin-top: 15px" class="d-flex justify-content-center">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
