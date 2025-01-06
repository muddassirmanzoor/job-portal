@include('includes.header')

<section class="hero-section">
    <div class="px-4 py-3 mb-3 text-center">
        <h1 class="display-5 fw-bold text-body-emphasis hero-heading">All Post Status</h1>
    </div>
</section>

<section class="after-hero-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12 bg p-3 text-black">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-------------------->
                    <div class="row white-container">
                        @foreach($applications as $cv)
                        <div class="four col-md-3 my-2">
                            @if(url()->current() == url('/first-scrutinize-count'))
                            <a href="{{url('first-scrutinize-form-data/'.$cv->post_id)}}" class="counter-box">
                                <span class="counter">{{$cv->profile_count}}</span>
                                <p class="post-title-card">{{$cv->title}}</p>
                            </a>
                                @elseif(url()->current() == url('/first-review-count'))
                                <a href="{{url('first-review-form-data/'.$cv->post_id)}}" class="counter-box">
                                    <span class="counter">{{$cv->profile_count}}</span>
                                    <p class="post-title-card">{{$cv->title}}</p>
                                </a>
                            @elseif(url()->current() == url('/second-review-count'))
                                <a href="{{url('second-review-form-data/'.$cv->post_id)}}" class="counter-box">
                                    <span class="counter">{{$cv->profile_count}}</span>
                                    <p class="post-title-card">{{$cv->title}}</p>
                                </a>
                            @else
                                <a href="{{url('first-submitted-form-data/'.$cv->post_id)}}" class="counter-box">
                                    <span class="counter">{{$cv->profile_count}}</span>
                                    <p class="post-title-card">{{$cv->title}}</p>
                                </a>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    <!-------------------->
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    footer.container {
        position: absolute;
        bottom: 0;
        max-width: 100%;
    }
    footer.container p.text-center.pt-3.pb-3 {
        padding-bottom: 0px !important;
    }
    </style>
@include('includes.footer')
