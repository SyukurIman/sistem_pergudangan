@extends('layouts.app')

@push('before-styles')
@endpush

@section('content')
    @if ($type == 'index')
        @include('masterdata.pegawai.table')
    @else
        @include('masterdata.pegawai.form')
    @endif
@endsection

@push('after-scripts')
    @include('masterdata.pegawai.script')
@endpush