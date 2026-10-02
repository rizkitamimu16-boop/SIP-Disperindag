@extends('layouts.app')

@section('sidebar')
    @include('components.sidebar-admin')
@endsection

@push('modals')
    @include('components.admin-modals')
@endpush

@push('scripts')
    @include('components.admin-scripts')
@endpush
