@extends('layouts.app')

@push('before-styles')
@endpush

@section('content')
    @if($type == "index")
        @include('transaksi.barang.list_barang')
    @elseif ($type == 'barang_masuk')
        @include('transaksi.barang.barang_masuk')
    @elseif ($type == 'barang_keluar')
        @include('transaksi.barang.barang_keluar')
    @endif
@stop

@push('after-scripts')

@include('transaksi.barang.script')

@endpush
