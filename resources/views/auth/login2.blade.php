@extends('layouts_homepage.app')

@section('content')


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
</head>
<body>

<div class="container ">
    <div class="row justify-content-center mt-5 ">
        <div class="col-md-6 ">
            <div class="card ">
                <div class="card-header">
                    <h4 class="text-center">Login</h4>
                </div>
                <div class="card-body">
                    <form id="myForm" method="POST" action="{{ route('login') }}">
                    @csrf
                        <div class="form-group">
                        <input
                          type="text"
                          class="form-control"
                          id="name"
                          name="username"
                          placeholder="Username"
                          onfocus="this.placeholder = ''"
                          :value="old('username')"
                          onblur="this.placeholder = 'Username'"
                          required
                          />
                        </div>
                        <div class="form-group">
                        <input
                        type="password"
                        class="form-control"
                        id="subject"
                        name="password"
                        placeholder="Password"
                        onfocus="this.placeholder = ''"
                        onblur="this.placeholder = 'Password'"
                        required
                        autocomplete="current-password"
                          />
                        </div>
                        <button class="btn text-uppercase col btn-primary btn-block">{{ __('Log in') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

@endsection