@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
          <x-dashboard.free-space/>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <x-dashboard.visitor-count/>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <x-dashboard.image-count/>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <x-dashboard.avg-page-load-speed/>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <x-dashboard.daily-visitors/>
        </div>
        <div class="col-md-4">
          <x-dashboard.daily-views/>
        </div>
        <div class="col-md-4">
          <x-dashboard.images-per-month/>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6 col-md-12">
          <x-dashboard.session-sources/>
        </div>
        <div class="col-lg-6 col-md-12">
          <x-dashboard.most-popular-images/>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('js')
  <script>
    $(document).ready(function() {
      /* Javascript method's body can be found in assets/js/demos.js */
      md.initDashboardPageCharts();
    });
  </script>
@endpush