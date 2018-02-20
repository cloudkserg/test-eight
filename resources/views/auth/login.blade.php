@extends('layout')

{{-- Content --}}
@section('content')
    <div class="row">
        <div class="page-header">
            <h2>Login</h2>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <form method="post" action="/login" >
                @csrf
                <div class="form-group  {{ $errors->has('login') ? 'has-error' : '' }}">
                    <label class="control-label" for="login">Login</label>
                <div class="controls">
                    <input name="login" class="form-control" id="login" />
                    <span class="help-block">{{ $errors->first('login', ':message') }}</span>
                </div>
            </div>
            <div class="form-group  {{ $errors->has('password') ? 'has-error' : '' }}">
                <label class="control-label" for="password">Password</label>
                <div class="controls">
                    <input name="password" class="form-control" id="password" type="password" />
                    <span class="help-block">{{ $errors->first('password', ':message') }}</span></div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary" style="margin-right: 15px;">
                        Login
                    </button>
                </div>
            </div>
            </form>
        </div>
    </div>
@endsection