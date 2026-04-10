(function($) {
    "use strict";

    document.querySelectorAll("[data-year]").forEach(function(el) {
        el.textContent = new Date().getFullYear();
    });

    let actionConfirm = $('.action-confirm');
    if (actionConfirm.length) {
        actionConfirm.on('click', function(e) {
            if (!confirm(config.translates.actionConfirm)) {
                e.preventDefault();
            }
        });
    }

    const dropdown = document.querySelectorAll('[data-dropdown]');
    if (dropdown) {
        dropdown.forEach(function(el) {
            let dropdownMenu = el.querySelector(".drop-down-menu");
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
            });
        });
    }

    var toggle = document.querySelectorAll('[data-toggle]');
    if (toggle) {
        toggle.forEach(function(el) {
            const toggleTitle = el.querySelector(".toggle-title");
            const toggleMenu = el.querySelector(".dashboard-sidebar-link-menu");

            if (toggleTitle && toggleMenu) {
                toggleTitle.addEventListener("click", () => {
                    if (el.classList.contains("active")) {
                        toggleMenu.style.setProperty("height", 0);
                        el.classList.remove("active");
                        el.classList.remove("animated");
                    } else {
                        el.classList.add("active");
                        setTimeout(function() {
                            toggleMenu.style.setProperty("height", `${toggleMenu.scrollHeight}px`);
                            el.classList.add("animated");
                        }, 0);
                    }
                });
            }

            window.addEventListener("load", () => {
                if (el.classList.contains("active")) {
                    setTimeout(function() {
                        toggleMenu.style.setProperty("height", `${toggleMenu.scrollHeight}px`);
                        el.classList.add("animated");
                    }, 0);
                }
            });
        });
    }


    const dashboard = document.querySelector(".dashboard"),
        dashboardToggleBtn = document.querySelectorAll(".dashboard-sidebar-toggle");
    if (dashboard) {
        const sidebarOverlay = dashboard.querySelector(".dashboard-sidebar .overlay");
        dashboardToggleBtn.forEach((el) => {
            el.addEventListener("click", () => {
                dashboard.classList.toggle("toggle");
            });
        });
        sidebarOverlay.addEventListener("click", () => {
            dashboard.classList.remove("toggle");
        });
    }


    function updateSortedItems(ids) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: sortingRoute,
            type: "POST",
            data: { ids: ids },
            dataType: "JSON",
            success: function(response) {
                if (!$.isEmptyObject(response.error)) {
                    toastr.error(response.error);
                }
            },
            error: function(request, status, error) {
                toastr.error(error);
            }
        });
    }

    let nestable = $('.nestable');
    if (nestable.length > 0) {
        nestable.nestable({
            maxDepth: nestableMaxDepth ? nestableMaxDepth : 1,
        });

        const nestAbles = document.querySelectorAll(".dd-item");
        const nestableHeight = () => {
            nestAbles.forEach((el) => {
                el.querySelectorAll("[data-action]").forEach((btn) => {
                    btn.style.setProperty("height", `${btn.parentNode.querySelector(".dd-handle").offsetHeight}px`);
                });
            });
        };

        nestableHeight();

        nestable.on('change', function() {
            nestableHeight();
            const ids = JSON.stringify(nestable.nestable('serialize'));
            updateSortedItems(ids);
        });

        window.addEventListener("resize", () => {
            setTimeout(() => {
                nestableHeight();
            }, 200);
        });
        window.addEventListener("mousemove", nestableHeight);

        const nestableLinks = document.querySelectorAll(".dd-actions a");
        if (nestableLinks) {
            nestableLinks.forEach((el) => {
                el.addEventListener("mousedown", (e) => {
                    e.stopPropagation();
                });
            });
        }
    }

    const sortableElement = document.querySelector(".sortable tbody");
    if (sortableElement) {
        Sortable.create(sortableElement, {
            handle: ".sortable-handle",
            invertSwap: true,
            onEnd: function(evt) {
                const sortedIDs = [...sortableElement.children].map(row => row.getAttribute('data-id'));
                updateSortedItems(sortedIDs);
            }
        });
    }

    const autoSize = document.querySelectorAll("[auto-size]");
    if (autoSize.length > 0) {
        autosize(autoSize);
    }


    let dataTable = $('.datatable'),
        DataTable2 = $('.datatable2');
    if (dataTable.length || DataTable2.length) {
        let dataTableConfig = {
            "language": {
                emptyTable: config.translates.emptyTable,
                searchPlaceholder: config.translates.searchPlaceholder,
                search: "",
                zeroRecords: config.translates.zeroRecords,
                sLengthMenu: config.translates.sLengthMenu,
                info: config.translates.info,
                infoEmpty: config.translates.infoEmpty,
                infoFiltered: config.translates.infoFiltered,
                paginate: {
                    first: config.translates.paginate.first,
                    previous: config.translates.paginate.previous,
                    next: config.translates.paginate.next,
                    last: config.translates.paginate.last,
                },
            },
            "dom": '<"table-header card-header border-bottom"f><"table-wrapper"rt><"table-footer card-footer"ilp><"clear">',
            drawCallback: function(table) {
                table.nTableWrapper.querySelector('.pagination').classList.add('pagination-sm');
                table.nTableWrapper.querySelector('.form-control').classList.remove('form-control-sm');
                $('.dataTables_filter input').attr('type', 'text');
            }
        };

        if (dataTable.length) {
            dataTable.DataTable($.extend({}, dataTableConfig, {
                pageLength: 50,
                order: [
                    [0, "desc"]
                ],
            }));
        }

        if (DataTable2.length) {
            DataTable2.DataTable($.extend({}, dataTableConfig, {
                pageLength: 50,
            }));
        }
    }


    let editors = document.querySelectorAll('.editor');
    if (editors.length > 0) {
        bkLib.onDomLoaded(function() {
            for (let i = 0; i < editors.length; i++) {
                new nicEditor({
                    fullPanel: false,
                    uploadURI: config.admin_url + '/image/upload',
                    iconsPath: '/vendor/libs/nicEdit/nicEditorIcons.gif',
                    buttonList: [
                        'fontSize', 'fontFormat', 'bold', 'italic', 'underline', 'left', 'center', 'right',
                        'justify', 'ol', 'ul', 'subscript', 'superscript', 'strikethrough', 'removeformat',
                        'indent', 'outdent', 'hr', 'image', 'upload', 'link', 'unlink', 'forecolor', 'bgcolor', 'xhtml'
                    ]
                }).panelInstance(editors[i]);
            }
        });
    }


    let slugTitle = $("#slugTitle"),
        slugInput = $('#slugInput');

    slugTitle.on('input', function() {
        let url = $(this).data('url');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            url: url,
            data: {
                content: $(this).val(),
            },
            success: function(data) {
                slugInput.val(data.slug);
            }
        });
    });

    let addonStatus = $('.addon-status');
    addonStatus.on('change', function() {
        let updateLink = $(this).data('update-link'),
            status = $(this).is(':checked') ? 1 : 0;
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: updateLink,
            type: "POST",
            data: { status: status },
            dataType: "JSON",
            success: function(response) {
                if (!$.isEmptyObject(response.error)) {
                    toastr.error(response.error);
                }
            },
            error: function(request, status, error) {
                toastr.error(error);
            }
        });
    });


    let attachImageButton = $('.attach-img-button'),
        attachImageInput = $('.attach-img-input');
    attachImageButton.on('click', function() {
        $(this).siblings('.attach-img-input').click();
    });

    attachImageInput.on('change', function(event) {
        const imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp', 'tiff', 'ico'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), imageExtensions) != -1) {
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

    let selectpicker = $('.selectpicker');
    if (selectpicker.length) {
        selectpicker.selectpicker({
            noneSelectedText: config.translates.noneSelectedText,
            noneResultsText: config.translates.noneResultsText,
            countSelectedText: config.translates.countSelectedText
        });
    }

    let htmlEditor = document.getElementById("html-editor");
    if (htmlEditor) {
        var editor = CodeMirror.fromTextArea(htmlEditor, {
            lineNumbers: true,
            mode: "htmlmixed",
            theme: "monokai",
            keyMap: "sublime",
            autoCloseBrackets: true,
            matchBrackets: true,
            showCursorWhenSelecting: true,
        });
        editor.setSize(null, 400);
    }

    var cssEditor = document.getElementById("css-editor");
    if (cssEditor) {
        var editor = CodeMirror.fromTextArea(cssEditor, {
            lineNumbers: true,
            mode: "text/css",
            theme: "monokai",
            keyMap: "sublime",
            autoCloseBrackets: true,
            matchBrackets: true,
            showCursorWhenSelecting: true,
        });
        editor.setSize(null, 700);
    }

    let colorpicker = $('.colorpicker');
    if (colorpicker.length) {
        Coloris({ el: '.coloris', rtl: config.direction == "rtl" ? true : false, });
        Coloris.setInstance('.coloris', {
            theme: 'pill',
            themeMode: 'light',
            formatToggle: true,
            closeButton: true,
            clearButton: true,
            swatches: ['#067bc2', '#84bcda', '#80e377', '#ecc30b', '#f37748', '#d56062']
        });
    }

    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

    let inputNumeric = document.querySelectorAll('.input-numeric');
    if (inputNumeric) {
        inputNumeric.forEach((el) => {
            el.oninput = () => {
                el.value = el.value.replace(/[^0-9]/g, '');
            };
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

    function generatePassword(length) {
        var charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_=+[]{}|;:,.<>?";
        var password = "";
        for (var i = 0; i < length; i++) {
            var randomIndex = Math.floor(Math.random() * charset.length);
            password += charset.charAt(randomIndex);
        }
        return password;
    }


    let randomPasswordBtn = $('#randomPasswordBtn'),
        randomPasswordInput = $('#randomPasswordInput');
    randomPasswordBtn.on('click', function(e) {
        e.preventDefault();
        randomPasswordInput.val(generatePassword(16));
    });

    if (randomPasswordInput.length) {
        randomPasswordInput.val(generatePassword(16));
    }


    let pageSearchInput = $('#pageSearchInput');
    pageSearchInput.on('input', function() {
        var value = $(this).val().toLowerCase(),
            pageSearchElement = $('.page-search-element');
        pageSearchElement.filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    let auoSelect = $('.period-select');
    auoSelect.on('change', function() {
        location.href = $(this).val();
    });

    let tagsInput = $('.tags-input');
    if (tagsInput.length) {
        tagsInput.tagsinput({
            cancelConfirmKeysOnEmpty: false
        });
    }

    let inputPrice = $('.input-price');
    if (inputPrice.length) {
        inputPrice.priceFormat({
            prefix: '',
            thousandsSeparator: '',
            clearOnEmpty: true
        });
    }

    let customFeatures = $('.custom-features'),
        addCustomFeature = $('#addCustomFeature');

    addCustomFeature.on('click', function(e) {
        e.preventDefault();
        customFeaturesTotal++;
        customFeatures.append('<div class="col-12 custom-feature-box-' + customFeaturesTotal + '">' +
            '<div class="input-group">' +
            '<input type="text" name="custom_features[]" class="form-control form-control-md" required>' +
            '<button class="btn btn-danger btn-md custom-feature-remove" type="button" data-id="' +
            customFeaturesTotal + '">' +
            '<i class="fa-regular fa-trash-can"></i></button>' +
            '</div>' +
            '</div>');
    });

    $(document).on('click', '.custom-feature-remove', function() {
        let id = $(this).data("id");
        customFeaturesTotal--;
        $('.custom-feature-box-' + id).remove();
    });

})(jQuery);