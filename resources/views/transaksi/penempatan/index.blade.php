@extends('layouts.app')

@push('before-styles')
@endpush

@section('content')
    @if($type == "index")
        @include('transaksi.penempatan.table')
    @else
        @include('transaksi.penempatan.form')
    @endif
@stop

@push('after-scripts')

@include('transaksi.penempatan.script')

@endpush
