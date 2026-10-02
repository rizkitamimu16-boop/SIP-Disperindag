@extends('layouts.app')

@section('sidebar')
    @include('components.sidebar-pegawai')
@endsection

@push('modals')
    @include('components.pegawai-modals')
@endpush

@push('scripts')
    @include('components.pegawai-scripts')
@endpush
