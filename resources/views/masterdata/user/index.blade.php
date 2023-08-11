@extends('layouts.app')

@push('before-styles')
@endpush

@section('content')
    @if($type == "index")
        @include('masterdata.user.table')
    @else
        @include('masterdata.user.form')
    @endif
@stop

@push('after-scripts')

@include('masterdata.user.script')

@endpush
