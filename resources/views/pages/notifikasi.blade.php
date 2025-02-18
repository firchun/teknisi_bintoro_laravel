@extends('layouts.frontend.app')

@section('content')
    <section class="section">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h3>{{ $title }}</h3>
                    <hr>
                    @forelse ($notifikasi as $item)
                        <div class="card my-2" style="border:1px solid #003A5D;">
                            <div class="card-body p-2">
                                <b>{{ $item->isi_notifikasi }}</b>
                                <br>
                                <small
                                    class="text-mutted">{{ $item->created_at ? $item->created_at->format('d F Y H:i') : '-' }}</small>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-mutted">
                            Belum ada notifikasi
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
@endsection
