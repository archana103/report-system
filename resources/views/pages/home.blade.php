@extends('layouts.public')

@section('content')
  @include('partials.home.hero')
  @include('partials.home.trending-reports')
  @include('partials.home.press-releases')
  @include('partials.home.insights')
  @include('partials.home.services')
  @include('partials.home.about')
  @include('partials.home.contact')
  <div style="min-height: 150px;"></div>
@endsection
