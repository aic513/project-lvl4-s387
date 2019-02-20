@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">User settings</div>
                    <div class="card-body">
                        @include('flash::message')
                        <form action="{{ route('users.update', ['id' => $user->id]) }}" method="POST">
                            {{ method_field('PATCH') }}
                            @csrf
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                                           value="{{ $user->name }}" required>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                                           value="{{ $user->email }}" required>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                        <hr>
                        <form action="{{ route('users.destroy', ['id' => $user->id]) }}" method="POST" data-confirm="Are you sure, that you you want to delete your account?">
                            {{ method_field('DELETE') }}
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                Delete account
                            </button>
                            <a class="btn btn-primary" href="{{ route('user.changePassword')}}">Change password</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

