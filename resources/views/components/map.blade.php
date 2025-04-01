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
                                @foreach($cities as $city)
                                    <li><a href="{{ route('region', $city->slug) }}">{{ $city->title }}</a></li>
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
            center: [55.76, 37.64], // Москва
            zoom: 10,
            controls: [],
            behaviors: ['drag', 'multiTouch']
        });

        const cities = @json($regions);

        cities.forEach(city => {
            if (city.coors) {
                var coordinates = city.coors.split(',').map(Number);
                var socialLinks = city.social ? city.social.map(s => `<a href="${s.link}"><img src="img/${s.service}.svg" alt=""></a>`).join('') : '';
                var socialBlock = socialLinks ? `<div class="map-balloon__top-social">${socialLinks}</div>` : '';

                var placemark = new ymaps.Placemark(coordinates, {
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
                            <a href="regions/${city.slug}">
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
            }

            myMap.setBounds(myMap.geoObjects.getBounds());
        });
    });
</script>
