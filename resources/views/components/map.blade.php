<div class="map bg--gray">
    <div class="container">
        <div class="wrap">
            <div class="row gx-0">
                <div class="col-12 col-sm-6">
                    <div class="map__title">
                        <strong>Культурно-образовательный центр Молдовы</strong> в регионах
                    </div>
                    <div class="map__cities">
                        <div class="map__cities-main">
                            <ul>
                                <li><a href="region/moskva">Москва</a></li>
                                <li><a href="region/sankt-peterburg">Санкт-Петербург</a></li>
                            </ul>
                        </div>
                        <div class="map__cities-list">
                            <ul>
                                @foreach($cities as $item)
                                    <li><a href="{{ route('region', $item->slug) }}">{{ $item->title }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    ymaps.ready(function () {
        var myMap = new ymaps.Map('map', {
            center: [58.281825, 47.269673], // Центр России
            zoom: 4,
            controls: [],
            behaviors: ['drag', 'multiTouch']
        });

        const cities = @json($regions);
        const activeCity = '{{ $city->title ?? '' }}';

        let activePlacemark = null;

        cities.forEach(city => {
            if (city.coors) {
                const coords = city.coors.split(',').map(Number);
                if (coords.length !== 2 || coords.some(isNaN)) return; // пропуск невалидных координат

                const socialLinks = Array.isArray(city.social)
                    ? city.social.map(s => `<a href="${s.link}" target="_blank" rel="noopener"><img src="img/${s.service}.svg" alt=""></a>`).join('')
                    : '';

                const socialBlock = socialLinks
                    ? `<div class="map-balloon__top-social">${socialLinks}</div>`
                    : '';

                const placemark = new ymaps.Placemark(coords, {
                    balloonContent: `
                    <div class="map-balloon">
                        <div class="map-balloon__top">
                            <div class="map-balloon__top-title">
                                <h3>${city.title}</h3>
                            </div>
                            ${socialBlock}
                        </div>
                        <div class="map-balloon__text">
                            <p>${city.phone || ''}</p>
                            <p>${city.email || ''}</p>
                        </div>
                        <div class="map-balloon__bottom">
                            <a href="region/${city.slug}">
                                <span>Подробнее</span>
                                <img src="img/more.svg" alt="">
                            </a>
                        </div>
                    </div>
                `
                }, {
                    iconLayout: 'default#image',
                    iconImageHref: 'img/marker.svg',
                    iconImageSize: [32, 32],
                    iconImageOffset: [-16, -32]
                });

                myMap.geoObjects.add(placemark);

                if (city.title === activeCity) {
                    activePlacemark = { placemark, coords };
                }
            }
        });

        if (activePlacemark) {
            myMap.setCenter(activePlacemark.coords, 12, { duration: 500 });
            activePlacemark.placemark.balloon.open();
        }
    });
</script>
