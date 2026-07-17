const slides = document.querySelectorAll('.image-slider .swiper-slide');
const loopMode = slides.length > 2;
const swiper = new Swiper(".image-slider", {    // Объявление слайдера
  direction: "horizontal",                      // Горизонтальный свайп слайдов
  loop: loopMode,                                   // Бесконечный слайдер
  simulateTouch: true,                          // Листать курсором
  touchRatio: 2,                                // Значение перелистывания курсором
  touchAngle: 45,                               // Градус перелистывания курсором
  grabCursor: true,                             // Юзать курсор-руку при зажатии и наведении
  slidesPerView: 1,                             // Сколько показывать слайдов
  watchOverflow: true,                          // Убрать всё, кроме слайда, если он один
  speed: 800,                                   // Скорость перелистывания
  effect: "fade",                               // Анимация появления
  fadeEffect: {                                 // Крутой эффект появления
    crossFade: true,
  },
  pagination: {                                 // Пагинация
    el: ".swiper-pagination",                   // Класс для пагинации
    type: "bullets",                            // Тип пагинации (точки)
    clickable: true,                            // Кликабельные ли точки
  },
  navigation: {                                 // Навигация
    nextEl: ".swiper-button-next",              // Класс кнопки вправо
    prevEl: ".swiper-button-prev",              // Класс кнопки влево
  },
  keyboard: {                                   // Перелистывание клавиатурой
    enable: true,                               // Включить
    onlyInViewport: true,                       // На стрелочки
    pageUpDown: true,                           // На кнопки pgUp, pgDn
  },
  // mousewheel: {                                 // Перелистывание мышкой
  //   sensitivity: 1,
  //   eventsTarget: ".image-slider",
  // },
  autoplay: {                                   // Автоматический переход на следующий слайд
    delay: 3000,                                // Задержка 3 сек
    stopOnLastSlide: true,                      // Остановить на ласт слайде
    disableOnInteraction: false,                // Отключить переключение после взаимодействия
    pauseOnMouseEnter: true,                    // Пауза при наведении мышкой на слайд
    waitForTransition: true,                    // Ожидание перехода
  },
  preloadImages: false,                         // Лоадер, если инет хуйня
  lazy: {
    loadOnTransitionStart: false,
    loadPrevNext: false,
  },
  parallax: true,                               // Включить параллакс (клёвые анимашки)
});