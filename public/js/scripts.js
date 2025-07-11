window.addEventListener("load", (event) => {
    if (document.querySelector(".hero .keen-slider")) hero();
    if (document.querySelector(".projects .keen-slider")) projectsSlider();
    if (document.querySelector(".p-page__slider.keen-slider")) pageSlider();
    if (document.querySelector(".p-region__slider .keen-slider")) regionSlider();
    if (document.querySelector(".p-about .keen-slider")) about();
    if (document.querySelector(".p-acccount__events.keen-slider")) accountSlider();
    if (document.querySelector(".partners-slider")) partners();
    if (document.querySelector(".modal")) modals();
    if (document.querySelector("[type='tel']")) phoneMask();
    if (document.querySelector("[data-code]")) codeMask();
    if (document.querySelector(".nav")) sticky();
    if (document.querySelector(".header-burger")) burger();
    if (document.querySelector(".accordion-item")) accordion();
    document.querySelectorAll(".tabs").forEach(tabs);
    if (document.querySelector('.events__select')) {
        initDatepicker();
    }
});

function openModal(modalId, timeout = 0) {
    const modal = document.querySelector(modalId);
    const overlay = document.querySelector(".modal__overlay");
    const html = document.documentElement;

    modal.classList.add("active");
    overlay.classList.add("active");
    html.classList.add("overflow");

    if (timeout > 0) setTimeout(() => {
        modal.classList.remove("active");
        overlay.classList.remove("active");
        html.classList.remove("overflow");
    }, timeout);
}

function closeModals() {
    const html = document.documentElement;
    const overlay = document.querySelector(".modal__overlay");

    document.querySelectorAll(".modal").forEach(modal => {
        modal.classList.remove("active");
    })

    overlay.classList.remove("active");
    html.classList.remove("overflow");
}

function initSlider(selector, options) {
    const sliderElement = document.querySelector(selector);
    const slider = new KeenSlider(sliderElement, options);

    // Получаем существующие элементы управления
    const controls = sliderElement.parentElement.querySelector(".keen-slider__controls");
    if (!controls) return;

    const arrowLeft = controls.querySelector(".keen-slider-arrow--left");
    const arrowRight = controls.querySelector(".keen-slider-arrow--right");
    const dots = controls.querySelector(".keen-slider-dots");

    // Создаем точки в существующем контейнере
    if (dots) {
        const slides = sliderElement.querySelectorAll(".keen-slider__slide");
        slides.forEach((_, idx) => {
            const dot = document.createElement("button");
            dot.className = "keen-slider-dot" + (idx === 0 ? " active" : "");
            dot.addEventListener("click", () => {
                slider.moveToIdx(idx);
            });
            dots.appendChild(dot);
        });
    }

    // Обработчики для стрелок
    if (arrowLeft) {
        arrowLeft.addEventListener("click", () => slider.prev());
    }
    if (arrowRight) {
        arrowRight.addEventListener("click", () => slider.next());
    }

    // Обновление активной точки при смене слайда
    if (dots) {
        slider.on("slideChanged", () => {
            const sliderDots = controls.querySelectorAll(".keen-slider-dot");
            sliderDots.forEach((dot, idx) => {
                dot.classList.toggle("active", idx === slider.track.details.rel);
            });
        });
    }
}

function accountSlider() {
    initSlider(".p-acccount__events.keen-slider", {
        loop: true,
        slides: {
            perView: 3.5,
            spacing: 30
        },
        breakpoints: {
            '(max-width: 768px)': {
                slides: {
                    perView: 1,
                    spacing: 10
                }
            },
        },
    });
}

function about() {
    initSlider(".p-about .keen-slider", {
        loop: true,
        slides: {
            perView: 3,
            spacing: 25
        },
        breakpoints: {
            '(max-width: 768px)': {
                slides: {
                    perView: 1.2,
                    spacing: 10
                }
            },
        },
    });
}

function hero() {
    initSlider(".hero .keen-slider", {
        loop: true,
        slides: {
            perView: 1,
            spacing: 10
        },
        breakpoints: {
            '(max-width: 768px)': {
                slides: {
                    perView: 1,
                    spacing: 10
                }
            },
        },
        animation: {
            duration: 1200, // 💡 Увеличиваем длительность анимации (мс)
            easing: t => t // по желанию: ease-in-out, cubic bezier и т.п.
        },
        created(sliderInstance) {
            let autoplayInterval = null;

            function startAutoplay() {
                stopAutoplay();
                autoplayInterval = setInterval(() => {
                    sliderInstance.next();
                }, 8000); // ⏱ Интервал в 8 секунд
            }

            function stopAutoplay() {
                if (autoplayInterval !== null) {
                    clearInterval(autoplayInterval);
                    autoplayInterval = null;
                }
            }

            // Автозапуск
            startAutoplay();

            // Стоп при наведении
            sliderInstance.container.addEventListener("mouseenter", stopAutoplay);
            sliderInstance.container.addEventListener("mouseleave", startAutoplay);

            // Перезапуск при клике на элементы управления
            const resetOnClick = () => {
                stopAutoplay();
                startAutoplay();
            };

            document.querySelectorAll(".hero .arrow, .hero .dot").forEach(el => {
                el.addEventListener("click", resetOnClick);
            });
        },
    });
}



function projectsSlider() {
    initSlider(".projects .keen-slider", {
        loop: true,
        slides: {
            perView: 1.5,
            spacing: 20
        },
        breakpoints: {
            '(max-width: 768px)': {
                slides: {
                    perView: 1,
                    spacing: 20
                }
            },
        },
    });
}

function pageSlider() {
    initSlider(".p-page__slider.keen-slider", {
        loop: true,
        slides: {
            perView: 1,
            spacing: 20
        },
        breakpoints: {
            '(max-width: 768px)': {
                slides: {
                    perView: 1,
                    spacing: 20
                }
            },
        },
    });
}

function regionSlider() {
    initSlider(".p-region__slider .keen-slider", {
        loop: true,
        slides: {
            perView: 1,
            spacing: 20
        },
        breakpoints: {
            '(max-width: 768px)': {
                slides: {
                    perView: 1,
                    spacing: 20
                }
            },
        },
    });
}

function partners() {
    const sliderElement = document.querySelector('.partners-slider');
    if (!sliderElement) return;

    let slider = null;

    function initPartnersSlider() {
        if (window.innerWidth < 768 && !slider) {
            slider = new KeenSlider(sliderElement, {
                loop: true,
                slides: {
                    perView: 1.5,
                    spacing: 20
                }
            });
        }
    }

    function destroyPartnersSlider() {
        if (window.innerWidth >= 768 && slider) {
            slider.destroy();
            slider = null;
        }
    }

    // Инициализация при загрузке
    initPartnersSlider();

    // Обработка изменения размера окна
    window.addEventListener('resize', () => {
        if (window.innerWidth < 768) {
            initPartnersSlider();
        } else {
            destroyPartnersSlider();
        }
    });
}

function modals() {
    const html = document.documentElement;

    // Открытие модального окна
    document.querySelectorAll("[data-modal]").forEach(trigger => {
        trigger.addEventListener("click", function (event) {
            event.preventDefault();
            const modalId = this.getAttribute("data-modal");
            const modal = document.querySelector(modalId);
            const overlay = document.querySelector(".modal__overlay");
            const formTitle = this.getAttribute("data-title");
            const formField = modal.querySelector("[name='form']");

            if (modal) {
                modal.classList.add("active");
                overlay.classList.add("active");
                html.classList.add("overflow");

                if(document.querySelector(formField)) formField.value = formTitle;
            }
        });
    });

    // Закрытие модального окна
    document.querySelectorAll(".modal__close, .modal__overlay").forEach(closeElement => {
        closeElement.addEventListener("click", function () {
            document.querySelectorAll(".modal, .modal__overlay").forEach(el => el.classList.remove("active"));
            html.classList.remove("overflow");
        });
    });

    // Закрытие по Escape
    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape") {
            document.querySelectorAll(".modal, .modal__overlay").forEach(el => el.classList.remove("active"));
            html.classList.remove("overflow");
        }
    });
}

function phoneMask() {
    document.querySelectorAll('input[type="tel"]').forEach(input => {
        input.addEventListener("input", maskPhone);
        input.addEventListener("focus", maskPhone);
        input.addEventListener("blur", maskPhone);
        input.addEventListener("keydown", maskPhone);
    });

    function maskPhone(event) {
        let keyCode = event.keyCode;
        let input = event.target;
        let pos = input.selectionStart;
        let matrix = "+7 (___) ___-__-__";
        let i = 0;
        let def = matrix.replace(/\D/g, "");
        let val = input.value.replace(/\D/g, "");

        if (def.length >= val.length) val = def;

        let newValue = matrix.replace(/[_\d]/g, a => i < val.length ? val.charAt(i++) : a);
        i = newValue.indexOf("_");
        if (i !== -1) {
            if (i < 5) i = 3;
            newValue = newValue.slice(0, i);
        }

        let reg = matrix
            .substr(0, input.value.length)
            .replace(/_+/g, a => "\\d{1," + a.length + "}")
            .replace(/[+()]/g, "\\$&");
        reg = new RegExp("^" + reg + "$");

        if (!reg.test(input.value) || input.value.length < 5 || (keyCode > 47 && keyCode < 58)) {
            input.value = newValue;
        }
        if (event.type === "blur" && input.value.length < 5) {
            input.value = "";
        }
    }
}

function codeMask() {
    document.querySelectorAll('[data-code]').forEach(input => {
        input.addEventListener("input", maskCode);
        input.addEventListener("blur", maskCode);
    });

    function maskCode(event) {
        let input = event.target;
        let val = input.value.replace(/\D/g, ''); // Убираем всё, кроме цифр
        if (val.length > 4) val = val.slice(0, 4); // Ограничиваем 4 цифрами
        input.value = val;

        // Если блюр и введено меньше 4 символов — очищаем
        if (event.type === "blur" && val.length < 4) {
            input.value = "";
        }
    }
}

function sticky() {
    const nav = document.querySelector(".header");
    if (!nav) return;

    let navHeight = nav.offsetHeight;
    let isSticky = false;

    const updateNavState = () => {
        const navTop = nav.getBoundingClientRect().top;

        if (window.scrollY > 0 && !isSticky) {
            nav.classList.add("sticky");
            isSticky = true;
        } else if (window.scrollY == 0 && isSticky) {
            nav.classList.remove("sticky");
            isSticky = false;
        }
    };

    updateNavState();

    window.addEventListener("scroll", updateNavState);
    window.addEventListener("resize", () => {
        navHeight = nav.offsetHeight; // Пересчитываем высоту при изменении размеров экрана
    });
}

function tabs(tabContainer) {
    const tabs = tabContainer.querySelectorAll(".tabs-nav .tab");
    const contents = tabContainer.querySelectorAll(".tabs-content .tab");
    let sliderInstance = null;

    tabs.forEach((tab, index) => {
        tab.addEventListener("click", function () {
            // Удаляем active у всех вкладок и контента
            tabs.forEach(t => t.classList.remove("active"));
            contents.forEach(c => c.classList.remove("active"));

            // Добавляем active к текущей вкладке и контенту
            tab.classList.add("active");
            contents[index].classList.add("active");

            // Реинициализируем слайдер
            initSlider(tabContainer);
        });
    });

    function initSlider(container) {
        // Удаляем предыдущий экземпляр слайдера, если он есть
        if (sliderInstance) {
            sliderInstance.destroy();
        }

        const activeTab = container.querySelector(".tabs-content .tab.active .keen-slider");
        if (!activeTab) return;

        sliderInstance = new KeenSlider(activeTab, {
            loop: true,
            slides: {
                perView: 2.5,
                spacing: 10
            },
            breakpoints: {
                '(max-width: 800px)': {
                    slides: {
                        perView: 1.5,
                        spacing: 20
                    }
                },
            },
            created: function (instance) {
                const prevBtn = container.querySelector(".tab.active .slider .slider-prev");
                const nextBtn = container.querySelector(".tab.active .slider .slider-next");
                const dotsContainer = container.querySelector(".tab.active .slider-dots");

                if (prevBtn && nextBtn) {
                    prevBtn.addEventListener("click", () => instance.prev());
                    nextBtn.addEventListener("click", () => instance.next());
                }

                if (dotsContainer) {
                    dotsContainer.innerHTML = ""; // Очищаем точки перед созданием новых
                    for (let i = 0; i < instance.track.details.slides.length; i++) {
                        const dot = document.createElement("button");
                        dot.classList.add("slider-dot");
                        dot.dataset.index = i;
                        dot.addEventListener("click", () => instance.moveToIdx(i));
                        dotsContainer.appendChild(dot);
                    }
                }

                function updateActiveDots() {
                    const activeIndex = instance.track.details.rel;
                    if (dotsContainer) {
                        dotsContainer.querySelectorAll(".slider-dot").forEach((dot, dotIndex) => {
                            dot.classList.toggle("active", dotIndex === activeIndex);
                        });
                    }
                }
                instance.on("animationEnded", updateActiveDots);
                updateActiveDots();
            },
        });
    }

    // Инициализируем слайдер для первой вкладки при загрузке страницы
    initSlider(tabContainer);
}

function burger() {
    const burger = document.querySelector('.header-burger');
    const mobile = document.querySelector('.mobile');
    const close = document.querySelector('.mobile-close');

    burger.addEventListener("click", function (event) {
        event.preventDefault();
        mobile.classList.add('active');
    });

    close.addEventListener("click", function (event) {
        event.preventDefault();
        mobile.classList.remove('active');
    });
}

function scrollTo() {
    const anchors = document.querySelectorAll('a[href^="#"]');
    anchors.forEach(anchor => {
        anchor.addEventListener("click", function (e) {
            e.preventDefault();

            const targetId = anchor.getAttribute("href").substring(1); // Убираем #
            const target = document.getElementById(targetId); // Получаем элемент по ID

            const targetPosition = target.getBoundingClientRect().top + window.scrollY;

            window.scrollTo({
                top: targetPosition,
                behavior: "smooth",
            });
        });
    });
}

function accordion() {
    const accordions = document.querySelectorAll(".accordion-item");

    accordions.forEach(item => {
        const header = item.querySelector(".accordion-header");
        const content = item.querySelector(".accordion-content");

        header.addEventListener("click", function () {
            const isOpen = item.classList.contains("active");

            accordions.forEach(acc => {
                acc.classList.remove("active");
                acc.querySelector(".accordion-content").style.maxHeight = 0;
            });

            if (!isOpen) {
                item.classList.add("active");
                content.style.maxHeight = content.scrollHeight + "px";
            }
        });
    });

    const firstHeader = document.querySelector(".accordion-item .accordion-header");
    if (firstHeader) {
        firstHeader.click();
    }
}


document.addEventListener('DOMContentLoaded', function() {
    const searchButton = document.querySelector('.header__controls-search button');
    const searchInput = document.querySelector('.header__search');
    const menu = document.querySelector('.header__menu > div:first-child');
    const searchClose = document.querySelector('.header__search img');
    let isSearchOpen = false;

    searchButton.addEventListener('click', function() {
        isSearchOpen = !isSearchOpen;

        if (isSearchOpen) {
            searchInput.style.display = 'flex';
            menu.classList.add('hidden');
            searchInput.querySelector('input').focus();
        } else {
            searchInput.style.display = 'none';
            menu.classList.remove('hidden');
        }
    });

    // Закрытие поиска при клике на иконку
    searchClose.addEventListener('click', function() {
        isSearchOpen = false;
        searchInput.style.display = 'none';
        menu.classList.remove('hidden');
    });

    // Закрытие поиска при клике вне его области
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchButton.contains(e.target)) {
            isSearchOpen = false;
            searchInput.style.display = 'none';
            menu.classList.remove('hidden');
        }
    });


    // Переключение мобильного меню
    const burgerIcon = document.querySelector('.m-header__controls-burger svg:first-child');
    const burgerIconClose = document.querySelector('.m-header__controls-burger svg:nth-child(2)');
    const mobileNav = document.querySelector('.m-header__nav');

    if (burgerIcon && mobileNav) {
        burgerIcon.addEventListener('click', function() {
            if (mobileNav.style.display === 'block') {
                mobileNav.style.display = 'none';
                this.style.display = 'none';
                this.nextElementSibling.style.display = 'inline';
            } else {
                mobileNav.style.display = 'block';
                this.style.display = 'none';
                this.nextElementSibling.style.display = 'inline';
            }
        });
    }

    if (burgerIconClose && mobileNav) {
        burgerIconClose.addEventListener('click', function() {
            if (mobileNav.style.display === 'block') {
                mobileNav.style.display = 'none';
                this.style.display = 'none';
                this.previousElementSibling.style.display = 'inline';
            } else {
                mobileNav.style.display = 'block';
                this.style.display = 'none';
                this.previousElementSibling.style.display = 'inline';
            }
        });
    }

    // Мобильный поиск
    const mobileSearchBtn = document.querySelector('.m-header__controls-search');
    const mobileSearch = document.querySelector('.m-search');
    const mobileSearchClose = document.querySelector('.m-search__close');
    const mobileSearchInput = document.querySelector('.m-search__input input');

    if (mobileSearchBtn && mobileSearch) {
        mobileSearchBtn.addEventListener('click', function() {
            mobileSearch.style.display = 'block';
            setTimeout(() => {
                mobileSearch.classList.add('active');
            }, 10);
            mobileSearchInput.focus();
        });
    }

    if (mobileSearchClose && mobileSearch) {
        mobileSearchClose.addEventListener('click', function() {
            mobileSearch.classList.remove('active');
            setTimeout(() => {
                mobileSearch.style.display = 'none';
            }, 300);
        });
    }

    // Закрытие поиска при клике вне поля ввода
    document.addEventListener('click', function(e) {
        if (mobileSearch && mobileSearch.style.display === 'block') {
            if (!mobileSearchInput.contains(e.target) && !mobileSearchBtn.contains(e.target)) {
                mobileSearch.classList.remove('active');
                setTimeout(() => {
                    mobileSearch.style.display = 'none';
                }, 300);
            }
        }
    });



});

function initDatepicker() {
    const inputElements = document.querySelectorAll('[x-model="date"]');

    function setRange(dp, days) {
        let startDate = new Date();
        let endDate = new Date(startDate);
        endDate.setDate(startDate.getDate() + days);

        dp.clear();
        dp.selectDate([startDate, endDate]);
        dp.setViewDate(startDate);

        triggerChangeEvent(dp.$el);
    }

    function triggerChangeEvent(element) {
        if (element) {
            let event = new Event('change', { bubbles: true });
            element.dispatchEvent(event);
        }
    }

    inputElements.forEach(inputElement => {
        const weekButton = {
            content: 'Неделя',
            className: 'button-select',
            onClick: (dp) => setRange(dp, 7)
        };

        const monthButton = {
            content: 'Месяц',
            className: 'button-select',
            onClick: (dp) => setRange(dp, 30)
        };

        const threeMonthsButton = {
            content: '3 месяца',
            className: 'button-select',
            onClick: (dp) => setRange(dp, 90)
        };

        const showButton = {
            content: 'Показать мероприятия',
            className: 'button-submit',
            onClick: (dp) => {
                const selectedDates = dp.selectedDates.map(date => {
                    return date.toISOString().split('T')[0];
                });
                dp.hide();
                triggerChangeEvent(dp.$el);
            }
        };

        const resetButton = {
            content: 'Сбросить',
            className: 'button-reset',
            onClick: (dp) => {
                dp.clear();
                dp.hide();
                triggerChangeEvent(dp.$el);
            }
        };

        new AirDatepicker(inputElement, {
            range: true,
            position: 'bottom right',
            buttons: [weekButton, monthButton, threeMonthsButton, showButton, resetButton],
            multipleDatesSeparator: ' - ',
            dateFormat: 'dd MMM',
        });
    });
}


