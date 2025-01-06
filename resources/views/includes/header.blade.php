<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="PMIU PESRP">
    <meta name="generator" content="PMIU PESRP">
    <title>Job Form</title>
    <!-- App favicon -->
    <link rel="shortcut icon" href="https://www.pesrp.edu.pk/wp-content/uploads/2024/05/PMIU-Logo-Colored-ai.png">

    <link href="{{ asset('assets/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="{{ asset('assets/dist/js/jquery-3.7.1.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>

<main>
    <header class="py-5border-bottom">
        <nav class="navbar navbar-expand-xl navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="https://www.pesrp.edu.pk/wp-content/uploads/2024/05/PMIU-Logo-Colored-ai.png" alt="PMIU-PESRP JOB PORTAL" width="75" height="75">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample06" aria-controls="navbarsExample06" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarsExample06">
                    @if(!Route::is('jobForm') && !Route::is('applicantDetail'))
                    <ul class="navbar-nav me-auto mb-2 mb-xl-0">
                        <!--<li class="nav-item">
                          <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>          -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('first-submitted-form-listing')}}">First Listing </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('first-submitted-count')}}">Applications Counts </a>
                        </li>
                        @if(Auth::user()->hasRole('Scrutiny'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('first-scrutinize-count')}}">Scrutiny Counts </a>
                        </li>
{{--                            <li class="nav-item">--}}
{{--                                <a class="nav-link" href="{{url('first-review-count')}}">Verify Scrutiny </a>--}}
{{--                            </li>--}}
                        @endif
                        @if(Auth::user()->hasRole('Review'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('first-review-count')}}">Review Counts </a>
                        </li>
{{--                            <li class="nav-item">--}}
{{--                                <a class="nav-link" href="{{url('second-review-count')}}">Verify Review </a>--}}
{{--                            </li>--}}
                        @endif
                        <li class="nav-item">
                            <a class="nav-link"  href="javascript:void(0)"  data-bs-toggle="modal" data-bs-target="#advertisementModal">Switch Advertisement</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('logout')}}">Logout</a>
                        </li>

                    </ul>
                    @endif
                </div>
            </div>
        </nav>
    </header>
    <!------------Header End Here-------------->
