@extends('layouts.portfolio')

@section('title', $project->title)

@section('content')
    <section style="padding-top:110px; padding-bottom:70px; background:#f8fafc; min-height:80vh;">
        <div class="container">

            {{-- Back to projects --}}
            <a href="{{ route('projects') }}" class="btn px-4 py-2 rounded-0 mb-4 fw-bold back-projects-btn">
                <i class="bi {{ app()->getLocale() === 'ar' ? 'bi-arrow-right' : 'bi-arrow-left' }} me-1"></i>
                {{ app()->getLocale() === 'ar' ? 'العودة إلى المشاريع' : 'Back to Projects' }}
            </a>
            {{-- Project heading --}}
            <div class="mb-4">
                <h1 class="fw-bold mb-3">{{ $project->title }}</h1>

                @if ($project->status === 'featured')
                    <span class="badge bg-warning text-dark mb-3">
                        <i class="bi bi-star-fill me-1"></i>Featured
                    </span>
                @endif
            </div>

            {{-- Main image --}}
            @if ($project->image)
                <div class="mb-5 text-center">
                    <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}"
                        class="img-fluid rounded-4 shadow-sm project-main-image" onclick="openProjectImage(this.src)">
                </div>
            @endif

            {{-- Project description --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4 p-md-5">
                    <h3 class="fw-bold mb-3">
                        {{ app()->getLocale() === 'ar' ? 'عن المشروع' : 'About the Project' }}
                    </h3>

                    <p class="text-muted mb-0 project-description">
                        {{ $project->description }}
                    </p>

                    @if ($project->technologies && count($project->technologies))
                        <h5 class="fw-bold mt-4 mb-3">
                            {{ app()->getLocale() === 'ar' ? 'التقنيات المستخدمة' : 'Technologies Used' }}
                        </h5>

                        <div class="d-flex flex-wrap gap-2">
                            @foreach ($project->technologies as $tech)
                                <span class="badge rounded-pill text-bg-light border px-3 py-2">
                                    {{ $tech }}
                                </span>
                            @endforeach
                        </div>
                    @endif

                    <div class="d-flex flex-wrap gap-2 mt-4">
                        @if ($project->github_link)
                            <a href="{{ $project->github_link }}" target="_blank" rel="noopener noreferrer"
                                class="btn btn-outline-dark rounded-pill px-4">
                                <i class="bi bi-github me-1"></i>
                                {{ app()->getLocale() === 'ar' ? 'عرض الكود' : 'View Code' }}
                            </a>
                        @endif

                        @if ($project->live_demo)
                            <a href="{{ $project->live_demo }}" target="_blank" rel="noopener noreferrer"
                                class="btn btn-primary rounded-pill px-4">
                                <i class="bi bi-box-arrow-up-right me-1"></i>
                                {{ app()->getLocale() === 'ar' ? 'عرض المشروع' : 'Live Demo' }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Gallery --}}
            @if (is_array($project->gallery) && count($project->gallery) > 0)
                <div class="mt-5">
                    <h3 class="fw-bold mb-4">
                        {{ app()->getLocale() === 'ar' ? 'معرض الصور' : 'Project Gallery' }}
                    </h3>

                    <div class="row g-3">
                        @foreach ($project->gallery as $image)
                            <div class="col-6 col-md-4">
                                <button type="button" class="gallery-image-button"
                                    onclick="openProjectImage(@js(asset('storage/' . $image)))"
                                    aria-label="{{ app()->getLocale() === 'ar' ? 'تكبير الصورة' : 'Enlarge image' }}">
                                    <img src="{{ asset('storage/' . $image) }}" alt="{{ $project->title }}"
                                        class="gallery-image" loading="lazy">
                                    <span class="gallery-zoom-icon">
                                        <i class="bi bi-zoom-in"></i>
                                    </span>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </section>

    {{-- Image lightbox --}}
    <div id="projectImageLightbox" class="project-lightbox" role="dialog" aria-modal="true" aria-label="Image preview"
        onclick="if(event.target === this) closeProjectImage()">

        <button type="button" class="lightbox-close" onclick="closeProjectImage()" aria-label="Close image">
            &times;
        </button>

        <img id="projectLightboxImage" src="" alt="{{ $project->title }}">
    </div>

    <style>
        .project-main-image {
            max-height: 520px;
            max-width: 100%;
            object-fit: contain;
            cursor: zoom-in;
        }

        .project-description {
            white-space: pre-line;
            line-height: 1.9;
            font-size: 1rem;
        }

        .gallery-image-button {
            display: block;
            position: relative;
            width: 100%;
            height: 230px;
            padding: 0;
            overflow: hidden;
            border: 0;
            border-radius: 14px;
            background: #e2e8f0;
            cursor: zoom-in;
        }

        .gallery-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .3s ease;
        }

        .gallery-image-button:hover .gallery-image {
            transform: scale(1.06);
        }

        .gallery-zoom-icon {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.8rem;
            background: rgba(15, 23, 42, .3);
            opacity: 0;
            transition: opacity .25s ease;
        }

        .gallery-image-button:hover .gallery-zoom-icon,
        .gallery-image-button:focus-visible .gallery-zoom-icon {
            opacity: 1;
        }

        .project-lightbox {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 99999;
            padding: 55px 20px 20px;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, .92);
        }

        .project-lightbox.is-open {
            display: flex;
        }

        .project-lightbox img {
            display: block;
            max-width: 95%;
            max-height: 90vh;
            object-fit: contain;
            border-radius: 8px;
        }

        .lightbox-close {
            position: absolute;
            top: 12px;
            right: 22px;
            color: white;
            background: transparent;
            border: 0;
            font-size: 42px;
            line-height: 1;
            cursor: pointer;
        }

        body.lightbox-open {
            overflow: hidden;
        }

        .back-projects-btn {
            background-color: #E0E7FF;
            color: #0a0a0a;
            border: 1px solid #C7D2FE;
            transition: background-color 0.25s ease, color 0.25s ease;
        }

        .back-projects-btn:hover {
            background-color: #C7D2FE;
            color: #4338CA;
            border-color: #A5B4FC;
        }

        @media (max-width: 576px) {
            .gallery-image-button {
                height: 155px;
            }
        }
    </style>

    <script>
        function openProjectImage(src) {
            const lightbox = document.getElementById('projectImageLightbox');
            const image = document.getElementById('projectLightboxImage');

            image.src = src;
            lightbox.classList.add('is-open');
            document.body.classList.add('lightbox-open');
        }

        function closeProjectImage() {
            const lightbox = document.getElementById('projectImageLightbox');
            const image = document.getElementById('projectLightboxImage');

            lightbox.classList.remove('is-open');
            document.body.classList.remove('lightbox-open');
            image.src = '';
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeProjectImage();
            }
        });
    </script>
@endsection
