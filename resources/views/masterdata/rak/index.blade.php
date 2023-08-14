@extends('layouts.app')

@push('before-styles')
@endpush

@section('content')
    @if($type == "index")
        @include('masterdata.rak.table')
    @else
        @include('masterdata.rak.form')
    @endif
@stop

@push('after-scripts')

@include('masterdata.rak.script')

@endpush
