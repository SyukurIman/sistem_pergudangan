@extends('layouts.app')

@push('before-styles')
@endpush

@section('content')
    @if($type == "index")
        @include('masterdata.barang.table')
    @elseif ($type == "index_dimensi_barang")
        @include('masterdata.barang.table_dimensi')
    @elseif ($type == "index_kategori")
        @include('masterdata.barang.table_kategori')
    @elseif ($type == "add_dimensi_barang" || $type == "edit_dimensi_barang")
        @include('masterdata.barang.form_dimensi')
    @elseif ($type == "add_kategori_barang" || $type == "edit_kategori")
        @include('masterdata.barang.form_kategori')
    @else
        @include('masterdata.barang.form')
    @endif
@stop

@push('after-scripts')

@include('masterdata.barang.script')

@endpush

{{-- add_kategori_barang --}}