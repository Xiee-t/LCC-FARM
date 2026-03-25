@extends('layouts.app')

@section('content')
<div class="container-xl my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="row flex-grow-1">
                <!-- Left content column -->
                <div class="col-md-7 order-md-2">
                    <div class="card border-0 shadow-sm p-5" style="background: white;">
                        <h1 class="mb-2 font-medium">Let's get started</h1>
                        <p class="mb-3 text-muted">Laravel has an incredibly rich ecosystem.<br>We suggest starting with the following.</p>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2">
                                <span class="badge bg-light me-3">1</span>
                                Read the 
                                <a href="https://laravel.com/docs" target="_blank" class="text-danger fw-medium text-decoration-underline">
                                    Documentation
                                    <svg width="10" height="11" viewBox="0 0 10 11" fill="none"><path d="M7.70833 6.95834V2.79167H3.54167M2.5 8L7.5 3.00001" stroke="currentColor" stroke-linecap="square"/></svg>
                                </a>
                            </li>
                            <li>
                                <span class="badge bg-light me-3">2</span>
                                Watch video tutorials at 
                                <a href="https://laracasts.com" target="_blank" class="text-danger fw-medium text-decoration-underline">
                                    Laracasts
                                    <svg width="10" height="11" viewBox="0 0 10 11" fill="none"><path d="M7.70833 6.95834V2.79167H3.54167M2.5 8L7.5 3.00001" stroke="currentColor" stroke-linecap="square"/></svg>
                                </a>
                            </li>
                        </ul>
                        <div>
                            <a href="https://cloud.laravel.com" target="_blank" class="btn btn-dark">
                                Deploy now
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Right image column -->
                <div class="col-md-5 order-md-1 mb-4 mb-md-0">
                    <div class="card border-0 rounded-3 position-relative overflow-hidden" style="aspect-ratio: 335/376; background: #fff2f2;">
                        <!-- Laravel Logo SVG -->
                        <svg class="w-100 h-100 text-danger p-4" viewBox="0 0 438 104" fill="none">
                            <!-- Original SVG paths here -->
                            <path d="M17.2036 -3H0V102.197H49.5189V86.7187H17.2036V-3Z" fill="currentColor" />
                            <!-- ... other paths from original ... -->
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
