<footer>
    <div class="container-destyle">
        <div class="footer-lvl1">
            <div class="footer-lvl1-left">
                <?php if (get_theme_mod('footer_logo')): ?>
                    <img src="<?php echo esc_url(get_theme_mod('footer_logo')); ?>" alt="<?php bloginfo('name'); ?>">
                <?php endif; ?>

                <div class="footer-lvl1-left-soc">
                    <p>Наши социальные сети:</p>
                    <div class="footer-lvl1-left-soc-bock">
                        <?php if (get_theme_mod('instagram_link')): ?>
                            <a href="<?php echo esc_url(get_theme_mod('instagram_link')); ?>" target="_blank"
                                rel="noopener">
                                <!-- SVG Instagram -->
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect x="2.5" y="2.5" width="19" height="19" rx="4.5" stroke="white" />
                                    <circle cx="12" cy="12" r="5.5" stroke="white" />
                                    <circle cx="17" cy="6" r="1" fill="white" />
                                </svg>
                            </a>
                        <?php endif; ?>

                        <?php if (get_theme_mod('vk_link')): ?>
                            <a href="<?php echo esc_url(get_theme_mod('vk_link')); ?>" target="_blank" rel="noopener">
                                <!-- SVG VK -->
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M5 7C5 9.72727 6.48235 15.1818 12.4118 15.1818V11.0909M12.4118 7V11.0909M12.4118 11.0909C14.3333 11.3636 18.3412 10.9273 19 7M12.4118 11.0909C13.7843 11.0909 17.0235 12.0727 19 16"
                                        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="footer-lvl1-right">
                <p>Полезные ссылки</p>
                <?php if (has_nav_menu('footer_links')): ?>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer_links',
                        'container' => false,
                        'menu_class' => '', // если нужны свои классы, можно указать здесь
                        // завернёт пункты в <ul class="footer-links">…</ul>
                        'items_wrap' => '<ul class="footer-links">%3$s</ul>',
                    ));
                    ?>
                <?php endif; ?>

            </div>
        </div>
        <div class="footer-lvl2">
            <p>Дестайлмебель - производство мебели</p>
            <p>Умная мебель для умных людей</p>
        </div>
    </div>

</footer>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const container = document.querySelector('.video-container');
        const placeholder = container.querySelector('.video-placeholder');
        let overlay = container.querySelector('.video-overlay');
        const video = container.querySelector('.video-element');
        const stopBtn = container.querySelector('.video-stop');

        // Сохраняем HTML оверлея, чтобы потом восстановить
        const overlayHTML = overlay.outerHTML;

        function onOverlayClick() {
            // запускаем видео
            video.muted = false;
            video.play();

            // убираем и оверлей, и плейсхолдер
            overlay.remove();
            placeholder.style.display = 'none';
        }

        overlay.addEventListener('click', onOverlayClick);

        stopBtn.addEventListener('click', (e) => {
            e.preventDefault();

            // пауза и перемотка
            video.pause();
            video.currentTime = 0;
            video.muted = true;

            // если оверлея нет — вставляем его и показываем плейсхолдер
            if (!container.querySelector('.video-overlay')) {
                container.insertAdjacentHTML('beforeend', overlayHTML);
                placeholder.style.display = '';
                overlay = container.querySelector('.video-overlay');
                overlay.addEventListener('click', onOverlayClick);
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.mode-block').forEach((modeBlock) => {
            const btnPrev = modeBlock.querySelector('.btn-prev');
            const btnNext = modeBlock.querySelector('.btn-next');
            const wrapper = modeBlock.querySelector('.destye-obs-slider-wrap');
            const slides = Array.from(wrapper.querySelectorAll('.destye-obs-slider-slide'));
            const progressContainer = modeBlock.querySelector('.destye-obs-progress-container');
            const progressBar = progressContainer?.querySelector('.destye-obs-progress-bar');
            const gap = 20;
            const totalCount = slides.length;

            // сколько показывать слайдов в зависимости от ширины
            const getVisibleCount = () => {
                const w = window.innerWidth;
                if (w <= 500) return 1;
                if (w <= 768) return 2;
                if (w <= 1280) return 3;
                return 4;
            };

            // текущий индекс прокрутки (целый номер первого полностью видимого слайда)
            const getCurrentIndex = () => {
                const slideSize = slides[0].getBoundingClientRect().width + gap;
                return Math.round(wrapper.scrollLeft / slideSize);
            };

            // обновляем состояние кнопок, если они есть
            const updateButtons = () => {
                if (!btnPrev || !btnNext) return;
                const maxIdx = slides.length - getVisibleCount();
                const idx = getCurrentIndex();
                btnPrev.disabled = idx <= 0;
                btnNext.disabled = idx >= maxIdx;
            };

            // скроллим на N слайдов (работает, даже если кнопок нет — просто не будет вызвано)
            const scrollBySlides = (n) => {
                const slideSize = slides[0].getBoundingClientRect().width + gap;
                wrapper.scrollBy({ left: n * slideSize, behavior: 'smooth' });
            };

            // обновляем прогресс-бар
            const updateIndicator = () => {
                if (!progressBar) return;
                // показываем только на мобиле
                if (window.innerWidth > 500) {
                    progressContainer.style.display = 'none';
                    return;
                }
                progressContainer.style.display = 'block';

                const visible = getVisibleCount();
                const slidePercent = 100 / totalCount;                    // шаг каждого слайда в процентах
                const widthPercent = visible * slidePercent;              // ширина «окна» видимых слайдов
                const leftPercent = getCurrentIndex() * slidePercent;     // смещение индикатора

                progressBar.style.width = `${widthPercent}%`;
                progressBar.style.left = `${leftPercent}%`;
            };

            // навешиваем события на кнопки, если есть
            if (btnPrev) btnPrev.addEventListener('click', () => scrollBySlides(-1));
            if (btnNext) btnNext.addEventListener('click', () => scrollBySlides(1));

            // всегда следим за скроллом
            wrapper.addEventListener('scroll', () => {
                window.requestAnimationFrame(() => {
                    updateButtons();
                    updateIndicator();
                });
            });
            window.addEventListener('resize', () => {
                updateButtons();
                updateIndicator();
            });

            // инициализация
            updateButtons();
            updateIndicator();
        });
    });
</script>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        const button = document.getElementById('destyle-header-block-mobil-block-button');
        const menu = document.querySelector('.header-destyle-mobil-menu-element');
        const body = document.body;

        // Исходный SVG 
        const svgClosed = `
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 4H20" stroke="#535D62" stroke-width="2" stroke-linecap="round"/>
                    <path d="M4 12H15" stroke="#D0043C" stroke-width="2" stroke-linecap="round"/>
                    <path d="M4 20H20" stroke="#535D62" stroke-width="2" stroke-linecap="round"/>
                </svg>
            `;

        // SVG при открытом меню 
        const svgOpened = `
               <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M4 4H20" stroke="#535D62" stroke-width="2" stroke-linecap="round"/>
<path d="M4 12H20" stroke="#D0043C" stroke-width="2" stroke-linecap="round"/>
<path d="M4 20H20" stroke="#535D62" stroke-width="2" stroke-linecap="round"/>
</svg>

            `;

        if (button && menu) {
            Object.assign(menu.style, {
                opacity: '0',
                transition: 'opacity 0.3s ease',
                display: 'none'
            });

            let isVisible = false;

            button.addEventListener('click', function () {
                if (!isVisible) {
                    // Открытие меню
                    menu.style.display = 'block';

                    requestAnimationFrame(() => {
                        requestAnimationFrame(() => {
                            menu.style.opacity = '1';
                        });
                    });

                    body.style.overflow = 'hidden'; // Блокировка прокрутки
                    button.innerHTML = svgOpened;
                    isVisible = true;
                } else {
                    // Закрытие меню
                    menu.style.opacity = '0';

                    menu.addEventListener('transitionend', function handler() {
                        menu.style.display = 'none';
                        menu.removeEventListener('transitionend', handler);
                    });

                    body.style.overflow = ''; // Разблокировка прокрутки
                    button.innerHTML = svgClosed;
                    isVisible = false;
                }
            });

            // На случай если по умолчанию не задано
            button.innerHTML = svgClosed;
        }
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const subMenus = document.querySelectorAll('.destyle-header-block-menu .sub-menu');
        subMenus.forEach(menu => {
            const items = menu.querySelectorAll('li');
            if (items.length > 8) {
                menu.classList.add('scrollable-submenu'); // на случай дополнительных стилей
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const topLevelItems = document.querySelectorAll('.mobile-menu > li.menu-item-has-children');
        let lastOpenedItem = null;

        topLevelItems.forEach(item => {
            const aTag = item.querySelector('a');
            const submenu = item.querySelector('.sub-menu');

            if (!submenu) return;

            // Инициализация
            submenu.classList.remove('open');
            submenu.style.maxHeight = '0';
            submenu.style.overflow = 'hidden';
            item.dataset.state = 'closed'; // кастомное состояние

            const submenuItems = submenu.querySelectorAll('li');
            const itemHeight = 40; // либо высчитать по первому li
            const hasScroll = submenuItems.length > 8;

            if (hasScroll) submenu.classList.add('scrollable');

            // SVG
            const svgClosed = `<svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M3 6.5L8 10.5L13 6.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>`;

            const svgOpened = `<svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M3 10.5L8 6.5L13 10.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>`;

            const svgContainer = document.createElement('span');
            svgContainer.classList.add('menu-toggle-icon');
            svgContainer.innerHTML = svgClosed;
            aTag.appendChild(svgContainer);

            aTag.addEventListener('click', function (e) {
                e.preventDefault();

                const isOpen = submenu.classList.contains('open');
                const wasClickedBefore = item.dataset.state === 'open';

                // Если другой пункт был открыт — закрыть его
                if (lastOpenedItem && lastOpenedItem !== item) {
                    const lastSub = lastOpenedItem.querySelector('.sub-menu');
                    const lastSVG = lastOpenedItem.querySelector('.menu-toggle-icon');

                    lastSub.classList.remove('open');
                    lastSub.style.maxHeight = '0';
                    lastSVG.innerHTML = svgClosed;
                    lastOpenedItem.dataset.state = 'closed';
                }

                if (!wasClickedBefore) {
                    // Первый клик — открытие
                    submenu.classList.add('open');
                    submenu.style.overflowY = hasScroll ? 'auto' : 'hidden';
                    const verticalPadding = 16; // 8px сверху + 8px снизу
                    submenu.style.maxHeight = hasScroll
                        ? (itemHeight * 8 + verticalPadding) + 'px'
                        : submenu.scrollHeight + 'px';

                    svgContainer.innerHTML = svgOpened;
                    item.dataset.state = 'open';
                    lastOpenedItem = item;
                } else {
                    // Второй клик — переход по ссылке
                    window.location.href = aTag.getAttribute('href');
                }
            });
        });
    });
</script>

<?php wp_footer(); ?>
</body>

</html>