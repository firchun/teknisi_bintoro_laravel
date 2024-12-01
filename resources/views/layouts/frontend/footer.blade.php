<footer>
    <div class="container">
        <div class="row align-items-center border-bottom py-5">
            <div class="col-lg-4">
                {{-- <ul class="list-inline footer-menu text-center text-lg-left">
                    <li class="list-inline-item"><a href="{{ asset('frontend_theme') }}/changelog.html">Changelog</a></li>
                    <li class="list-inline-item"><a href="{{ asset('frontend_theme') }}/contact.html">contact</a>
                    </li>
                    <li class="list-inline-item"><a href="{{ asset('frontend_theme') }}/search.html">Search</a>
                    </li>
                </ul> --}}
            </div>
            <div class="col-lg-4 text-center mb-4 mb-lg-0">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img class="img-fluid" src="{{ asset('img') }}/logo.png" style="width:200px;"
                        alt="Hugo documentation theme">
                </a>
            </div>
            <div class="col-lg-4">
                <ul class="list-inline social-icons text-lg-right text-center">
                    <li class="list-inline-item"><a href="#"><i class="ti-facebook"></i></a></li>
                    <li class="list-inline-item"><a href="#"><i class="ti-twitter-alt"></i></a></li>
                    <li class="list-inline-item"><a href="#"><i class="ti-github"></i></a>
                    </li>
                    <li class="list-inline-item"><a href="#"><i class="ti-linkedin"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="py-4 text-center">
            <small class="text-light">Copyright © {{ date('Y') }} SERVICE AC BINTORO</small>
        </div>
    </div>
</footer>
