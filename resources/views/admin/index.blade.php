@extends('admin.layout.main')
@section('content')
<!-- Content -->


<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Selamat datang,  🎉</h5>
                            <p class="mb-4">
                                Kamu berada di 
                                <strong id="city" style="font-size: 20px"></strong> 
                                dengan cuaca hari ini 
                                <img src="" id="weather" class="tooltip-weather" alt="Ikon Cuaca.">
                                , suhu sekitar yaitu 
                                <span style="font-size: 20px" id="temp" class="tooltip-temp"></span>
                                dan kelembapan sekitar 
                                <span id="humidity" style="font-size: 20px"></span>
                            </p>
                        </div>
                    </div>

                    
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="{{ asset('admin/img/illustrations/man-with-laptop-light.png') }}" height="140"
                                alt="View Badge User"/>
                        </div>
                    </div>

                    
                </div>
            </div>
        </div>
<!-- Order Statistics -->
<!-- Item Statistics -->
<!-- Item Statistics -->
<div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-4">
  <div class="card h-100">
    <div class="card-header d-flex align-items-center justify-content-between pb-0">
      <div class="card-title mb-0">
        <h5 class="m-0 me-2">Statistic Items per Category</h5>
        <small class="text-muted">{{ $totalItems }} Total Items</small> <!-- Total items -->
      </div>
      <div class="dropdown">
        
      </div>
    </div>
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex flex-column align-items-center gap-1">
          <h2 class="mb-2">{{ $totalItems }}</h2> <!-- Total count of items -->
          <span>Total Items</span>
        </div>
        <div id="itemStatisticsChart"></div>
      </div>

      <!-- Display categories and item counts -->
      <ul class="p-0 m-0">
        @foreach($categories as $category)
        <li class="d-flex mb-4 pb-1">
          <div class="avatar flex-shrink-0 me-3">
            <span class="avatar-initial rounded bg-label-primary">
              <i class="bx bx-categorize"></i> <!-- Example icon for category -->
            </span>
          </div>
          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
            <div class="me-2">
              <h6 class="mb-0">{{ $category->name }}</h6>
              <small class="text-muted">{{ $category->items_count }} Items</small> <!-- Number of items in the category -->
            </div>
            <div class="user-progress">
              <small class="fw-semibold">{{ $category->items_count }} Items</small>
            </div>
          </div>
        </li>
        @endforeach
      </ul>
    </div>
  </div>
</div>
<!--/ Item Statistics -->


            @endsection
