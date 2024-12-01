@extends('layouts.frontend.app')

@section('content')
    <!-- banner -->
    <section class="section pb-0">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-7 text-center text-lg-left">
                    <h1 class="mb-4">Layanan Service AC Terpercaya</h1>
                    <p class="mb-4">Kami menyediakan layanan service AC profesional untuk menjaga kenyamanan udara Anda.
                        Dapatkan perawatan berkala dan perbaikan dari teknisi berpengalaman.</p>
                    {{-- <form class="search-wrapper" action="search.html">
                        <input id="search-by" name="s" type="search" class="form-control form-control-lg"
                            placeholder="Cari layanan atau info di sini...">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </form> --}}
                </div>
                <div class="col-lg-4 d-lg-block d-none">
                    <img src="{{ asset('img') }}/logo.png" alt="Service AC" class="img-fluid">
                </div>
            </div>
        </div>
    </section>
    <!-- /banner -->

    <!-- topics -->
    <section class="section pb-0">
        <div class="container">
            <h2 class="section-title">Layanan Kami</h2>
            <div class="row">
                <!-- topic -->
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card match-height">
                        <div class="card-body">
                            <i class="card-icon ti-panel mb-4"></i>
                            <h3 class="card-title h4">Pembersihan AC</h3>
                            <p class="card-text">Layanan pembersihan AC untuk menjaga kebersihan dan kualitas udara.</p>
                            <a href="{{ asset('frontend_theme') }}/list.html" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
                <!-- topic -->
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card match-height">
                        <div class="card-body">
                            <i class="card-icon ti-credit-card mb-4"></i>
                            <h3 class="card-title h4">Perawatan Rutin</h3>
                            <p class="card-text">Jasa perawatan AC berkala untuk memastikan performa optimal.</p>
                            <a href="{{ asset('frontend_theme') }}/list.html" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
                <!-- topic -->
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card match-height">
                        <div class="card-body">
                            <i class="card-icon ti-package mb-4"></i>
                            <h3 class="card-title h4">Perbaikan AC</h3>
                            <p class="card-text">Solusi perbaikan cepat untuk semua jenis kerusakan AC.</p>
                            <a href="{{ asset('frontend_theme') }}/list.html" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
                <!-- topic -->
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card match-height">
                        <div class="card-body">
                            <i class="card-icon ti-settings mb-4"></i>
                            <h3 class="card-title h4">Penggantian Sparepart</h3>
                            <p class="card-text">Penggantian sparepart AC dengan kualitas terbaik dan original.</p>
                            <a href="{{ asset('frontend_theme') }}/list.html" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /topics -->

    <!-- faq -->
    <section class="section pb-0">
        <div class="container">
            <h2 class="section-title">Pertanyaan Umum</h2>
            <div class="row masonry-wrapper">
                <!-- faq item -->
                <div class="col-md-6 mb-4">
                    <div class="card card-lg">
                        <div class="card-body">
                            <h3 class="card-title h5">Berapa lama waktu pengerjaan?</h3>
                            <p class="card-text">Waktu pengerjaan tergantung pada jenis layanan, biasanya berkisar 1-2 jam
                                untuk pembersihan rutin.</p>
                        </div>
                    </div>
                </div>
                <!-- faq item -->
                <div class="col-md-6 mb-4">
                    <div class="card card-lg">
                        <div class="card-body">
                            <h3 class="card-title h5">Apakah ada garansi layanan?</h3>
                            <p class="card-text">Kami memberikan garansi layanan selama 30 hari untuk memastikan kepuasan
                                Anda.</p>
                        </div>
                    </div>
                </div>
                <!-- faq item -->
                <div class="col-md-6 mb-4">
                    <div class="card card-lg">
                        <div class="card-body">
                            <h3 class="card-title h5">Bagaimana cara memesan layanan?</h3>
                            <p class="card-text">Pesan layanan melalui website kami atau hubungi langsung tim customer
                                service.</p>
                        </div>
                    </div>
                </div>
                <!-- faq item -->
                <div class="col-md-6 mb-4">
                    <div class="card card-lg">
                        <div class="card-body">
                            <h3 class="card-title h5">Apakah melayani area di luar kota?</h3>
                            <p class="card-text">Kami melayani area tertentu di luar kota, hubungi kami untuk info lebih
                                lanjut.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /faq -->

    <!-- call to action -->
    <section class="section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 text-center d-lg-block d-none">
                    <img src="{{ asset('img') }}/logo.png" class="img-fluid" alt="">
                </div>
                <div class="col-lg-8 text-lg-left text-center">
                    <h2 class="mb-3">Butuh Bantuan Segera?</h2>
                    <p>Hubungi tim kami untuk layanan darurat atau informasi lebih lanjut.</p>
                    <a href="{{ route('register') }}" class="btn btn-primary">Hubungi Kami</a>
                </div>
            </div>
        </div>
    </section>
    <!-- /call to action -->
@endsection
