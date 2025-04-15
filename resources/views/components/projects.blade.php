<div class="projects">
    <div class="title">
        <span>Наши проекты</span>
    </div>
    <div class="container">
        <div class="keen-slider">
            @foreach($projects as $item)
                <div class="keen-slider__slide slide">
                    <a href="{{ route('projects.show', $item->slug) }}">
                        <picture>
                            <source media="(max-width: 768px)" srcset="{{ asset('storage/' . $item->image_m) }}">
                            <img src="{{ asset('storage/' . $item->banner_slider ?? $item->banner) }}" alt="{{ $item->title }}">
                        </picture>
                    </a>
                </div>
            @endforeach
        </div>
        <div class="keen-slider__controls">
            <button class="keen-slider-arrow keen-slider-arrow--left">
                <img src="img/prev.svg" alt="">
            </button>
            <div class="keen-slider-dots"></div>
            <button class="keen-slider-arrow keen-slider-arrow--right">
                <img src="img/next.svg" alt="">
            </button>
        </div>
    </div>
</div>
