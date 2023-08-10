@extends('layouts_homepage.app')

@section('content')

<form id="myForm" method="POST" action="{{ route('login') }}">
@csrf
  <div class="form-group col-md-12">
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
  <div class="form-group col-md-12">
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
  <div class="col-lg-11 offset-lg-1 text-center">
    <button class="btn text-uppercase col">{{ __('Log in') }}</button>
  </div>
</form>
          



@endsection