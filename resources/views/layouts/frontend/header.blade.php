<header class="sticky-top navigation">
    <div class=container>
        <nav class="navbar navbar-expand-lg navbar-light bg-transparent">
            <a class=navbar-brand href="{{ url('/') }}"><img class="img-fluid" style="width: 150px;"
                    src="{{ asset('img') }}/logo.png" alt="godocs"></a>
            <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navigation">
                <i class="ti-align-right h4 text-dark"></i></button>
            <div class="collapse navbar-collapse text-center" id=navigation>
                <ul class="navbar-nav mx-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a>
                    </li>
                    @if (Auth::check())
                        @if (Auth::user()->role == 'User')
                            <li class="nav-item"><a class="nav-link" href="{{ url('/pengajuan-service') }}">Pengajuan
                                    Service</a>
                            </li>
                        @endif
                    @endif
                </ul>
                @guest
                    <a href="{{ route('register') }}" class="btn btn-sm btn-outline-primary ml-lg-4">Daftar</a>
                    <a href="{{ route('login') }}" class="btn btn-sm btn-primary ml-lg-4">Masuk</a>
                @else
                    @if (Auth::user()->role == 'User')
                        <a href="{{ route('akun-user') }}" class="btn btn-sm btn-outline-primary ml-lg-4">Akun</a>

                        <a class="btn btn-sm btn-primary ml-lg-4" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit();">
                            Keluar </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @else
                        <a href="{{ route('home') }}" class="btn btn-sm btn-primary ml-lg-4">Dashboard</a>
                    @endif
                @endguest
            </div>
        </nav>
    </div>
</header>
