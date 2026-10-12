@extends('layouts.portfolio')

@section('title', app()->getLocale() === 'ar' ? 'جميع الشهادات' : 'All Certificates')

@section('content')

<section id="certificates" style="padding-top: 110px; padding-bottom: 70px;">
    <div class="container">

        <div class="text-center section-header fade-up mb-5">
            <span class="section-badge">
                {{ __('portfolio.cert_badge') }}
            </span>

            <h2 class="section-title">
                {{ app()->getLocale() === 'ar' ? 'جميع الشهادات' : 'All Certificates' }}
            </h2>

            <div class="section-line mx-auto"></div>
        </div>

        <div class="row g-4">

            @forelse($certificates as $cert)
                <div class="col-md-6 col-lg-4 fade-up">
                    <div class="cert-card card h-100">

                        @if ($cert->image)
                            <img
                                src="{{ asset('storage/' . $cert->image) }}"
                                class="card-img-top"
                                alt="{{ $cert->title }}"
                                style="height: 180px; object-fit: cover;"
                            >
                        @else
                            <div class="cert-icon-wrap">
                                <i class="bi bi-patch-check-fill"
                                   style="font-size: 3.5rem; color: #6366f1;"></i>
                            </div>
                        @endif

                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-1">{{ $cert->title }}</h6>

                            <div class="text-primary small fw-medium mb-1">
                                {{ $cert->issuer }}
                            </div>

                            <div class="text-muted small mb-3">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ $cert->issue_date ? $cert->issue_date->format('M Y') : '' }}
                            </div>

                            @if ($cert->credential_url)
                                <a
                                    href="{{ $cert->credential_url }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="btn btn-sm btn-outline-primary rounded-pill"
                                >
                                    <i class="bi bi-patch-check me-1"></i>
                                    {{ __('portfolio.cert_verify') }}
                                </a>
                            @endif
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted py-5">
                    {{ __('portfolio.cert_none') }}
                </div>
            @endforelse

        </div>

        <div class="text-center mt-5">
            <a href="{{ url('/') }}#certificates"
               class="btn btn-outline-primary rounded-pill px-4 py-2">
                {{ app()->getLocale() === 'ar' ? 'العودة إلى الصفحة الرئيسية' : 'Back to Home' }}
            </a>
        </div>

    </div>
</section>

@endsection