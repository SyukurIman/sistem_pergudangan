@extends('layouts.app')

@push('before-styles')
@endpush

@section('content')
    @if($type == "index")
        @include('transaksi.pemindahan.table')
    @else
        @include('transaksi.pemindahan.form')
    @endif
@stop

@push('after-scripts')

@include('transaksi.pemindahan.script')

@endpush
