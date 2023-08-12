@extends('layouts.app')

@push('before-styles')
@endpush

@section('content')
    @if($type == "index")
        @include('masterdata.barang.table')
    @elseif ($type == "add_dimensi_barang")
        @include('masterdata.barang.form_dimensi')
    @elseif ($type == "add_kategori_barang")
        @include('masterdata.barang.form_kategori')
    @else
        @include('masterdata.barang.form')
    @endif
@stop

@push('after-scripts')

@include('masterdata.barang.script')

@endpush

{{-- add_kategori_barang --}}