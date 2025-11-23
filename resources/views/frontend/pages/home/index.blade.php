@extends('frontend.layouts.main')
@section('content')
    <!-- Hero Section -->
    @include('frontend.components.hero')

    <!-- Sambtuan Kepala Desa -->
    @include('frontend.components.sambutan-kepala-desa')

    <!-- Data Penduduk -->
    @include('frontend.components.card-data-penduduk')

    <!-- Data Penduduk -->
    @include('frontend.components.card-apbdes')

    <!-- Berita Terbaru -->
    @include('frontend.components.card-berita')
@endsection
