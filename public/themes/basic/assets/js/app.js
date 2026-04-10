(function($) {
    "use strict";

    document.querySelectorAll("[data-year]").forEach(function(el) {
        el.textContent = new Date().getFullYear();
    });

    document.addEventListener('livewire:init', () => {
        Livewire.on('alert', event => {
            toastr[event.type](event.message);
        });

        Livewire.on('close-modal', (event) => {
            let modal = document.getElementById(event.id);
            if (modal) {
                let modalInstance = bootstrap.Modal.getInstance(modal);
                if (!modalInstance) {
                    modalInstance = new bootstrap.Modal(modal);
                }
                modalInstance.hide();
            }
        });
    });


    if ($("[data-aos]").length > 0) {
        function aosFunc() {
            AOS.init({
                once: true,
            });
        }

        window.addEventListener("load", aosFunc);
        window.addEventListener("scroll", aosFunc);
    }

    let actionConfirm = $('.action-confirm');
    if (actionConfirm.length) {
        actionConfirm.on('click', function(e) {
            if (!confirm(config.translates.actionConfirm)) {
                e.preventDefault();
            }
        });
    }

    let clipboardBtn = document.querySelectorAll(".btn-copy");
    if (clipboardBtn) {
        clipboardBtn.forEach((el) => {
            let clipboard = new ClipboardJS(el);
            clipboard.on("success", () => {
                toastr.success(config.translates.copied);
            });
        });
    }


    let inputNumeric = document.querySelectorAll('.input-numeric');
    if (inputNumeric) {
        inputNumeric.forEach((el) => {
            el.oninput = () => {
                el.value = el.value.replace(/[^0-9]/g, '').substr(0, 6);
            };
        });
    }

    const dropdown = document.querySelectorAll('[data-dropdown]');
    if (dropdown) {
        dropdown.forEach(function(el) {
            let dropdownMenu = el.querySelector(".drop-down-menu");

            function dropdownOP() {
                dropdownMenu.style.top = "40px";
            }
            window.addEventListener("click", function(e) {
                if (el.contains(e.target)) {
                    el.classList.toggle('active');
                    setTimeout(function() {
                        el.classList.toggle('animated');
                    }, 0);
                } else {
                    el.classList.remove('active');
                    el.classList.remove('animated');
                }
                dropdownOP();
            });
        });
    }

    var toggle = document.querySelectorAll('[data-toggle]');
    if (toggle) {
        toggle.forEach(function(el, id) {
            el.querySelector(".toggle-title").addEventListener("click", () => {
                for (var i = 0; i < toggle.length; i++) {
                    if (i !== id) {
                        toggle[i].classList.remove("active");
                        toggle[i].classList.remove("animated");
                    }
                }
                if (el.classList.contains("active")) {
                    el.classList.remove("active");
                    el.classList.remove("animated");
                } else {
                    el.classList.add("active");
                    setTimeout(function() {
                        el.classList.add("animated");
                    }, 0);
                }
            });
        });
    }

    let navbar = document.querySelector(".nav-bar");
    if (navbar) {
        let navbarOp = () => {
            if (window.scrollY > 0) {
                navbar.classList.add("scrolling");
            } else {
                navbar.classList.remove("scrolling");
            }
        };
        window.addEventListener("scroll", navbarOp);
        window.addEventListener("load", navbarOp);
    }

    let navbarMenu = document.querySelector(".nav-bar-menu"),
        navbarMenuBtn = document.querySelector(".nav-bar-menu-btn");
    if (navbarMenu) {
        let navbarMenuClose = navbarMenu.querySelector(".nav-bar-menu-close"),
            navbarMenuOverlay = navbarMenu.querySelector(".overlay"),
            navUploadBtn = document.querySelector(".nav-bar-menu [data-upload-btn]");
        navbarMenuBtn.onclick = () => {
            navbarMenu.classList.add("show");
            document.body.classList.add("overflow-hidden");
        };

        navbarMenuClose.onclick = navbarMenuOverlay.onclick = () => {
            navbarMenu.classList.remove("show");
            document.body.classList.remove("overflow-hidden");
        };
        if (navUploadBtn) {
            navUploadBtn.addEventListener("click", () => {
                navbarMenu.classList.remove("show");
            });
        }
    }

    function setCookie(cname, cvalue, exdays) {
        const d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        let expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(cname) {
        let name = cname + "=";
        let decodedCookie = decodeURIComponent(document.cookie);
        let ca = decodedCookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    const items = document.querySelector(".items");
    if (items) {
        const itemElements = items.querySelectorAll(".item");

        itemElements.forEach((el) => {
            el.classList.contains("item-inline") ? itemsList.setAttribute("disabled", "") : itemsGrid.setAttribute("disabled", "");
        });

        itemsList.addEventListener("click", () => {
            itemsList.setAttribute("disabled", "");
            itemsGrid.removeAttribute("disabled", "");
            itemElements.forEach((el) => {
                el.classList.add("item-inline");
                el.parentNode.classList.add("w-100");
                setCookie("items_grid", "list", 100);
            });
        });

        itemsGrid.addEventListener("click", () => {
            itemsGrid.setAttribute("disabled", "");
            itemsList.removeAttribute("disabled", "");
            itemElements.forEach((el) => {
                el.classList.remove("item-inline");
                el.parentNode.classList.remove("w-100");
                setCookie("items_grid", "grid", 100);
            });
        });

        if (getCookie("items_grid") == "list") {
            itemsList.setAttribute("disabled", "");
            itemsGrid.removeAttribute("disabled", "");
            itemElements.forEach((el) => {
                el.classList.add("item-inline");
                el.parentNode.classList.add("w-100");
                setCookie("items_grid", "list", 100);
            });
        } else if (getCookie("items_grid") == "grid") {
            itemsGrid.setAttribute("disabled", "");
            itemsList.removeAttribute("disabled", "");
            itemElements.forEach((el) => {
                el.classList.remove("item-inline");
                el.parentNode.classList.remove("w-100");
                setCookie("items_grid", "grid", 100);
            });
        }
    }

    let cookies = document.querySelector('.cookies');
    if (cookies) {
        window.addEventListener('load', () => {
            setTimeout(() => {
                cookies.classList.add('show');
            }, 1000);
        });
    }

    let acceptCookie = $('#acceptCookie'),
        cookieNotice = $('.cookies');
    acceptCookie.on('click', function(e) {
        e.preventDefault();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: config.url + '/cookie/accept',
            type: 'POST',
        });
        cookieNotice.remove();
    });

    let attachImageButton = $('.attach-img-button'),
        attachImageInput = $('.attach-img-input');
    attachImageButton.on('click', function() {
        $(this).siblings('.attach-img-input').click();
    });

    attachImageInput.on('change', function(event) {
        const ImageExtension = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), ImageExtension) != -1) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                const $preview = $(this).closest('.attach-img').find('.attach-img-preview');

                reader.onload = function(e) {
                    $preview.attr('src', e.target.result);
                    $preview.removeClass('d-none');
                };
                reader.readAsDataURL(file);
            }
        }
    });

    const swiperCategories = document.querySelector(".home-categories-swiper");
    if (swiperCategories) {
        const categorySlidesCount = swiperCategories.querySelectorAll(".swiper-slide").length;
        const categoryBreakpoints = {
            0: {
                slidesPerView: 1.2,
            },
            576: {
                slidesPerView: 2,
            },
            992: {
                slidesPerView: 3,
            },
            1400: {
                slidesPerView: 4,
            },
        };
        const maxCategorySlidesPerView = Math.max(...Object.values(categoryBreakpoints).map((point) => point.slidesPerView));
        new Swiper(swiperCategories, {
            spaceBetween: 16,
            loop: categorySlidesCount > maxCategorySlidesPerView,
            rewind: categorySlidesCount <= maxCategorySlidesPerView,
            navigation: {
                nextEl: ".home-categories-swiper-next",
                prevEl: ".home-categories-swiper-prev",
            },
            breakpoints: categoryBreakpoints,
        });
    }

    const swiperReviews = document.querySelector(".reviews-swiper");
    if (swiperReviews) {
        new Swiper(swiperReviews, {
            spaceBetween: 16,
            navigation: {
                nextEl: ".reviews-swiper-next",
                prevEl: ".reviews-swiper-prev",
            },
            grid: {
                fill: 'row',
                rows: 2
            },
            breakpoints: {
                0: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                1200: {
                    slidesPerView: 3,
                },
            },
        });
    }

    const ratings = document.querySelectorAll(".ratings-selective");
    if (ratings) {
        ratings.forEach((el) => {
            const rating = el.querySelectorAll(".rating");
            rating.forEach((ratingEl, id) => {
                ratingEl.addEventListener("click", () => {
                    ratingEl.querySelector("input[type=radio]").checked = true;
                    rating.forEach((ratingActive, activeId) => {
                        ratingActive.classList.remove("rating-active");
                        if (id >= activeId) {
                            ratingActive.classList.add("rating-active");
                        }
                    });
                });
            });
        });
    }


    let homeSearch = $('.home-search'),
        homeSearchInput = homeSearch.find('input'),
        homeSearchResults = homeSearch.find('.search-results .search-results-inner div');

    homeSearchInput.on('input', function() {
        let value = $(this).val();
        if (value !== '') {
            let homeSearchForm = homeSearch.find('form'),
                homeSearchFormAction = homeSearchForm.attr('action'),
                homeSearchAjaxAction = homeSearchForm.data('ajax-action'),
                homeSearchAjaxEmpty = homeSearchForm.data('ajax-empty'),
                homeSearchAction = homeSearch.find('.search-action');
            homeSearchAction.attr('href', homeSearchFormAction + '?search=' + value);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: homeSearchAjaxAction,
                method: 'POST',
                data: {
                    search: value,
                },
                success: function(response) {
                    homeSearchResults.empty();
                    if (!$.isEmptyObject(response.error)) {
                        toastr.error(response.error);
                    } else {
                        if (response.length === 0) {
                            if (config.add_business == true) {
                                let noResults = '<div class="text-center p-5">' +
                                    '<h4>' + config.translates.noneBusinessTitle + '</h4>' +
                                    '<p class="small">' + config.translates.noneBusinessDescription + '</p>' +
                                    '<button class="btn btn-outline-primary px-4" data-bs-toggle="modal" data-bs-target="#addBusinessModal"><i class="fa fa-plus me-2"></i>' + config.translates.noneBusinessButtonText + '</button>' +
                                    '</div>';
                                homeSearchResults.append(noResults);
                            } else {
                                let noResults = '<div class="text-muted text-center py-5">' +
                                    homeSearchAjaxEmpty + '</div>';
                                homeSearchResults.append(noResults);
                            }
                        } else {
                            $.each(response, function(index, item) {
                                let isVerified = item.is_verified ?
                                    '<div class="item-verified">' +
                                    '<i class="bi bi-patch-check-fill" data-bs-toggle="tooltip" data-bs-title="' + config.translates.verified + '"></i>' +
                                    '</div>' : ''; +

                                homeSearchResults.append('<a href="' + item.link + '" class="search-item position-relative d-block">' +
                                    '<div class="item-sm d-flex align-items-center gap-3">' +
                                    '<div class="item-img flex-shrink-0">' +
                                    '<img loading="lazy" src="' + item.logo + '" alt="' + item.name + '">' + isVerified +
                                    '</div>' +
                                    '<div class="item-info">' +
                                    '<h6 class="item-title mb-0">' + item.name + '</h6>' +
                                    ' <p class="item-link small text-muted mb-0">' + item.domain + '</p>' +
                                    ' </div>' +
                                    '</div>' +
                                    ' <div class="ratings ratings-sm position-absolute top-50 end-0 translate-middle-y d-none d-lg-inline me-3">' +
                                    '<span class="text-muted me-1">' + item.rating_avg + '</span>' +
                                    '<img src="' + item.rating_stars + '" alt="' + item.rating_avg + '">' +
                                    ' </div>' +
                                    ' </a>');
                            });
                        }
                    }
                },
                error: function(request, status, error) {
                    toastr.error(error);
                }
            });
            homeSearch.addClass("show");
        } else
            homeSearch.removeClass("show");
    });

    const customTitle = document.querySelectorAll(".custom-title");
    if (customTitle) {
        window.addEventListener("load", () => {
            customTitle.forEach((el) => {
                const firstWord = el.textContent.trim().split(" ")[0];
                el.innerHTML = el.textContent.trim().replace(/\w+/, `<span>${firstWord}</span>`);
            });
        });
    }

    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

    const tooltip = document.createElement('div');
    tooltip.className = 'tool-tip';
    document.body.appendChild(tooltip);

    let activeElem = null;
    let hideTimeout = null;

    function positionTooltip(elem) {
        if (!elem) return;

        const content = elem.querySelector('.tooltip-content');
        if (!content) return;
        tooltip.innerHTML = content.innerHTML;

        tooltip.classList.remove('above', 'below', 'show');
        tooltip.style.left = '0';
        tooltip.style.top = '0';
        tooltip.style.width = 'auto';
        tooltip.style.display = 'block';

        const elemRect = elem.getBoundingClientRect();
        const scrollX = window.pageXOffset;
        const scrollY = window.pageYOffset;
        const margin = 12;
        const screenWidth = window.innerWidth;
        const screenHeight = window.innerHeight;
        const topGap = 100;

        const ttRect = tooltip.getBoundingClientRect();
        const tooltipWidth = ttRect.width;

        let top = elemRect.top + scrollY - ttRect.height - 10;
        let placement = 'above';

        if (top < scrollY + topGap) {
            top = elemRect.bottom + scrollY + 10;
            placement = 'below';

            if (top + ttRect.height > scrollY + screenHeight - margin) {
                top = Math.max(scrollY + topGap, scrollY + screenHeight - ttRect.height - margin);
                placement = 'below';
            }

            if (top < elemRect.bottom + scrollY + 10) {
                top = elemRect.bottom + scrollY + 10;
            }
        }

        let left;
        const arrowPos = elem.getAttribute('data-arrow') || 'center';
        const elemCenterX = elemRect.left + scrollX + elemRect.width / 2;

        if (screenWidth <= 600) {
            left = elemCenterX - tooltipWidth / 2;
        } else {
            if (arrowPos === 'left') {
                left = elemRect.left + scrollX;
            } else if (arrowPos === 'right') {
                left = elemRect.right + scrollX - tooltipWidth;
            } else {
                left = elemCenterX - tooltipWidth / 2;
            }
        }

        left = Math.min(scrollX + screenWidth - tooltipWidth - margin, Math.max(left, scrollX + margin));

        tooltip.style.top = `${top}px`;
        tooltip.style.left = `${left}px`;
        tooltip.classList.add(placement);

        let arrowLeftValue;
        const tooltipLeft = left;

        if (screenWidth <= 600) {
            arrowLeftValue = `${elemCenterX - tooltipLeft}px`;
        } else {
            if (arrowPos === 'left') {
                arrowLeftValue = `${elemRect.left + scrollX + 16 - tooltipLeft}px`;
            } else if (arrowPos === 'right') {
                arrowLeftValue = `${elemRect.right + scrollX - 16 - tooltipLeft}px`;
            } else {
                arrowLeftValue = `${elemCenterX - tooltipLeft}px`;
            }
        }

        arrowLeftValue = `${Math.min(Math.max(parseFloat(arrowLeftValue), 16), tooltipWidth - 16)}px`;

        tooltip.style.setProperty('--arrow-left', arrowLeftValue);
        tooltip.classList.add('show');
    }

    function showTooltip(elem) {
        clearTimeout(hideTimeout);
        activeElem = elem;
        positionTooltip(elem);
    }

    function hideTooltip() {
        tooltip.classList.remove('show');
        tooltip.style.display = 'none';
        activeElem = null;
    }

    function scheduleHide() {
        hideTimeout = setTimeout(() => {
            if (!activeElem) return;
            if (!activeElem.matches(':hover') && !tooltip.matches(':hover')) {
                hideTooltip();
            }
        }, 200);
    }

    document.querySelectorAll('.tooltip-badge').forEach(elem => {
        elem.addEventListener('mouseenter', () => showTooltip(elem));
        elem.addEventListener('mouseleave', () => scheduleHide());
    });

    tooltip.addEventListener('mouseenter', () => clearTimeout(hideTimeout));
    tooltip.addEventListener('mouseleave', () => scheduleHide());

    window.addEventListener('resize', () => {
        if (activeElem) positionTooltip(activeElem);
    });

    window.addEventListener('scroll', () => {
        if (activeElem) positionTooltip(activeElem);
    });

    let itemReviewAction = document.querySelectorAll('.item-review-action');
    itemReviewAction.forEach(button => {
        const targetId = button.getAttribute('data-bs-target');
        const targetElement = document.querySelector(targetId);

        if (targetElement) {
            targetElement.addEventListener('shown.bs.collapse', () => {
                const yOffset = -300;
                const y = targetElement.getBoundingClientRect().top + window.pageYOffset + yOffset;
                window.scrollTo({
                    top: y,
                    behavior: 'smooth'
                });
            });
        }
    });

    const dashboard = document.querySelector(".dashboard"),
        dashboardToggleBtn = document.querySelectorAll(".dashboard-toggle-btn");
    if (dashboard) {
        dashboardToggleBtn.forEach((el) => {
            el.addEventListener("click", () => {
                dashboard.classList.toggle("toggle");
            });
        });
        dashboard.querySelector(".dashboard-sidebar .overlay").addEventListener("click", () => {
            dashboard.classList.remove("toggle");
        });
    }

    let selectpicker = $('.selectpicker');
    if (selectpicker.length) {
        selectpicker.selectpicker({
            noneSelectedText: config.translates.noneSelectedText,
            noneResultsText: config.translates.noneResultsText,
            countSelectedText: config.translates.countSelectedText
        });
    }

    let searchPage = $('#searchPage');
    let searchParam = $('#searchFilters .search-param');

    if (searchPage.length) {
        searchParam = $('#searchPage .search-param');
    } else if (window.innerWidth <= 1200) {
        searchParam = $('#searchFiltersMenu .search-param');
    }


    $.each(searchParam, function(index, element) {
        let url = new URL($(location).attr("href")),
            params = new URLSearchParams(url.search);

        params.forEach((value, key) => {
            if ($(element).attr('name') == key && $(element).val() == value) {
                $(element).prop('checked', true);
            }
        });
    });

    let searchForm = $('.search-form'),
        searchSelect = $('.search-select'),
        autoSearchInput = $('.auto-search-input');

    searchForm.on('submit', function(e) {
        e.preventDefault();
        let input = $(this).find('input'),
            url = addInputParamsToUrl(input.attr('name'), input.val());
        window.location.href = url;
    });

    autoSearchInput.on('change', function() {
        let url = addInputParamsToUrl($(this).attr('name'), $(this).val());
        window.location.href = url;
    });


    searchSelect.on('change', function() {
        let name = $(this).attr('name'),
            value = $(this).val();
        let url = addInputParamsToUrl(name, value);
        if (name && value !== undefined) {
            window.location.href = url;
        }
    });


    $(document).on('click', '.search-param', function() {
        let url = new URL($(location).attr('href')),
            param = $(this).attr('name'),
            value = $(this).val(),
            multiple = $(this).data('multiple') ? $(this).data('multiple') : null;

        url = removeParameterFromUrl(url);

        if (!multiple) {
            let paramExists = $(`[name='${param}']`).not(this);

            $.each(paramExists, function(index, element) {
                let params = new URLSearchParams(url.search),
                    param = $(element).attr('name'),
                    value = $(element).val();

                params.forEach((val, key) => {
                    if (param == key && value == val) {
                        url = removeParameterFromUrl(url, param, value);
                    }
                });

                $(element).prop('checked', false);
            });
        }

        if ($(this).is(':checked')) {
            $(this).prop('checked', true);
            url = addParameterToUrl(url, param, value);
        } else {
            $(this).prop('checked', false);
            url = removeParameterFromUrl(url, param, value, multiple);
        }

        window.location.href = url;
    });

    function addInputParamsToUrl(attr, value) {
        let url = new URL($(location).attr('href'));

        if (value != '') {
            url = removeParameterFromUrl(url, attr);
            url = addParameterToUrl(url, attr, value);
        } else {
            url = removeParameterFromUrl(url, attr);
        }

        return url;
    }

    function addParameterToUrl(url, param = null, value = null) {
        var url = new URL(url);
        const params = new URLSearchParams([
            ...Array.from(url.searchParams.entries()),
            ...Object.entries({
                [param]: value
            })
        ]);

        return new URL(`${url.origin}${url.pathname}?${params}`);
    }

    function removeParameterFromUrl(url, param = null, param_value = null, multiple = false) {
        var url = new URL(url),
            params = new URLSearchParams(url.search);

        if (multiple) {
            const multipleParams = params.getAll(param).filter(param => param != param_value);
            params.delete(param);
            for (const value of multipleParams) {
                params.append(param, value);
            }
        } else {
            params.delete(param);
        }

        return new URL(`${url.origin}${url.pathname}?${params}`);
    }

    let auoSelect = $('.period-select');
    auoSelect.on('change', function() {
        location.href = $(this).val();
    });

    let kycDocument = $('#kycDocument');

    kycDocument.on('change', function() {
        let kycDocumentVal = $(this).val();

        let nationalId = $('#nationalId'),
            nationalIDNumber = $('#nationalIDNumber'),
            passport = $('#passport'),
            passportNumber = $('#passportNumber');

        if (kycDocumentVal == "national_id") {
            passport.addClass('d-none');
            passportNumber.addClass('d-none');
            nationalId.removeClass('d-none');
            nationalIDNumber.removeClass('d-none');
        } else if (kycDocumentVal == "passport") {
            nationalId.addClass('d-none');
            nationalIDNumber.addClass('d-none');
            passport.removeClass('d-none');
            passportNumber.removeClass('d-none');
        }
    });

    let aiReviewWriter = $('.ai-review-writer'),
        aiWriterButton = $('.ai-writer-button');

    if (aiReviewWriter.length) {
        aiWriterButton.on('click', function() {
            let clickedButton = $(this),
                inputID = $(this).data('input'),
                targetedInput = $('#' + inputID);

            targetedInput.val('');
            targetedInput.attr('placeholder', targetedInput.data('ai-placeholder'));
            targetedInput.focus();

            let aiGenerateButton = $('.ai-generate-button[data-input=' + inputID + ']'),
                aiCancelButton = $('.ai-cancel-button[data-input=' + inputID + ']')

            clickedButton.parent().addClass('d-none');
            aiGenerateButton.parent().removeClass('d-none');
            aiCancelButton.parent().removeClass('d-none');
        });


        let aiCancelButton = $('.ai-cancel-button');
        aiCancelButton.on('click', function() {
            resetTargetedInput($('#' + $(this).data('input')));
        });

        let aiGenerateButton = $('.ai-generate-button');
        aiGenerateButton.on('click', function(e) {

            let clickedButton = $(this),
                clickedButtonAction = clickedButton.data('action'),
                inputID = clickedButton.data('input'),
                targetedInput = $('#' + inputID);

            if (targetedInput.val() == "") {
                targetedInput.focus();
            } else {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: clickedButtonAction,
                    method: 'POST',
                    data: {
                        input: inputID,
                        prompt: targetedInput.val(),
                    },
                    beforeSend: function() {
                        clickedButton.prop('disabled', true);
                        targetedInput.prop('disabled', true);
                        clickedButton.empty();
                        clickedButton.html(
                            '<div class="spinner-border spinner-grow-sm" role="status"><span class="visually-hidden"></span></div>'
                        );
                    },
                    success: function(response) {
                        if (!$.isEmptyObject(response.error)) {
                            resetTargetedInput(targetedInput);
                            toastr.error(response.error);
                        } else {
                            resetTargetedInput(targetedInput);
                            targetedInput.val(response.content);
                            targetedInput.focus();

                        }
                    },
                    error: function(request, status, error) {
                        resetTargetedInput(targetedInput);
                        toastr.error(error);
                    }
                });
            }
        });

        function resetTargetedInput(targetedInput) {
            let inputID = targetedInput.attr('id'),
                aiWriterButton = $('.ai-writer-button[data-input=' + inputID + ']'),
                aiGenerateButton = $('.ai-generate-button[data-input=' + inputID + ']'),
                aiCancelButton = $('.ai-cancel-button[data-input=' + inputID + ']')

            targetedInput.val('');
            targetedInput.attr('placeholder', targetedInput.data('default-placeholder'));
            targetedInput.focus();

            aiWriterButton.parent().removeClass('d-none');
            aiGenerateButton.parent().addClass('d-none');
            aiCancelButton.parent().addClass('d-none');

            changeAiGenerateButtonContent(aiGenerateButton);

            aiGenerateButton.prop('disabled', false);
            targetedInput.prop('disabled', false);
        }


        function changeAiGenerateButtonContent(button) {
            button.empty();
            button.html(
                '<i class="bi bi-pencil me-2"></i>' + button.data('default-content')
            );
        }
    }
})(jQuery);