/**
 * Theme: Uplon Admin Template
 * Author: Coderthemes
 * Module/App: Main Js
 */

!(function ($) {
    "use strict";

    var Sidemenu = function () {
        (this.$body = $("body")),
            (this.$openLeftBtn = $(".open-left")),
            (this.$menuItem = $("#sidebar-menu a"));
    };
    (Sidemenu.prototype.openLeftBar = function () {
        $("#wrapper").toggleClass("enlarged");
        $("#wrapper").addClass("forced");

        if (
            $("#wrapper").hasClass("enlarged") &&
            $("body").hasClass("fixed-left")
        ) {
            $("body")
                .removeClass("fixed-left")
                .addClass("fixed-left-void");
        } else if (
            !$("#wrapper").hasClass("enlarged") &&
            $("body").hasClass("fixed-left-void")
        ) {
            $("body")
                .removeClass("fixed-left-void")
                .addClass("fixed-left");
        }

        if ($("#wrapper").hasClass("enlarged")) {
            $(".left ul").removeAttr("style");
        } else {
            $(".subdrop")
                .siblings("ul:first")
                .show();
        }

        toggle_slimscroll(".slimscrollleft");
        $("body").trigger("resize");
    }),
        //menu item click
        (Sidemenu.prototype.menuItemClick = function (e) {
            if (!$("#wrapper").hasClass("enlarged")) {
                if (
                    $(this)
                        .parent()
                        .hasClass("has_sub")
                ) {
                }
                if (!$(this).hasClass("subdrop")) {
                    // hide any open menus and remove all other classes
                    $("ul", $(this).parents("ul:first")).slideUp(350);
                    $("a", $(this).parents("ul:first")).removeClass("subdrop");
                    $("#sidebar-menu .pull-right i")
                        .removeClass("md-remove")
                        .addClass("md-add");

                    // open our new menu and add the open class
                    $(this)
                        .next("ul")
                        .slideDown(350);
                    $(this).addClass("subdrop");
                    $(".pull-right i", $(this).parents(".has_sub:last"))
                        .removeClass("md-add")
                        .addClass("md-remove");
                    $(".pull-right i", $(this).siblings("ul"))
                        .removeClass("md-remove")
                        .addClass("md-add");
                } else if ($(this).hasClass("subdrop")) {
                    $(this).removeClass("subdrop");
                    $(this)
                        .next("ul")
                        .slideUp(350);
                    $(".pull-right i", $(this).parent())
                        .removeClass("md-remove")
                        .addClass("md-add");
                }
            }
        }),
        //init sidemenu
        (Sidemenu.prototype.init = function () {
            var $this = this;

            var ua = navigator.userAgent,
                event = ua.match(/iP/i) ? "touchstart" : "click";

            //bind on click
            this.$openLeftBtn.on(event, function (e) {
                e.stopPropagation();
                $this.openLeftBar();
            });

            // LEFT SIDE MAIN NAVIGATION
            $this.$menuItem.on(event, $this.menuItemClick);

            // NAVIGATION HIGHLIGHT & OPEN PARENT
            $("#sidebar-menu ul li.has_sub a.active")
                .parents("li:last")
                .children("a:first")
                .addClass("active")
                .trigger("click");
        }),
        //init Sidemenu
        ($.Sidemenu = new Sidemenu()),
        ($.Sidemenu.Constructor = Sidemenu);
})(window.jQuery),
    (function ($) {
        "use strict";

        var FullScreen = function () {
            (this.$body = $("body")), (this.$fullscreenBtn = $("#btn-fullscreen"));
        };

        //turn on full screen
        // Thanks to http://davidwalsh.name/fullscreen
        (FullScreen.prototype.launchFullscreen = function (element) {
            if (element.requestFullscreen) {
                element.requestFullscreen();
            } else if (element.mozRequestFullScreen) {
                element.mozRequestFullScreen();
            } else if (element.webkitRequestFullscreen) {
                element.webkitRequestFullscreen();
            } else if (element.msRequestFullscreen) {
                element.msRequestFullscreen();
            }
        }),
            (FullScreen.prototype.exitFullscreen = function () {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if (document.webkitExitFullscreen) {
                    document.webkitExitFullscreen();
                }
            }),
            //toggle screen
            (FullScreen.prototype.toggle_fullscreen = function () {
                var $this = this;
                var fullscreenEnabled =
                    document.fullscreenEnabled ||
                    document.mozFullScreenEnabled ||
                    document.webkitFullscreenEnabled;
                if (fullscreenEnabled) {
                    if (
                        !document.fullscreenElement &&
                        !document.mozFullScreenElement &&
                        !document.webkitFullscreenElement &&
                        !document.msFullscreenElement
                    ) {
                        $this.launchFullscreen(document.documentElement);
                    } else {
                        $this.exitFullscreen();
                    }
                }
            }),
            //init sidemenu
            (FullScreen.prototype.init = function () {
                var $this = this;
                //bind
                $this.$fullscreenBtn.on("click", function () {
                    $this.toggle_fullscreen();
                });
            }),
            //init FullScreen
            ($.FullScreen = new FullScreen()),
            ($.FullScreen.Constructor = FullScreen);
    })(window.jQuery),
    //main app module
    (function ($) {
        "use strict";

        var App = function () {
            (this.VERSION = "1.1.0"),
                (this.AUTHOR = "Coderthemes"),
                (this.SUPPORT = "coderthemes@gmail.com"),
                (this.pageScrollElement = "html, body"),
                (this.$body = $("body"));
        };

        //on doc load
        App.prototype.onDocReady = function (e) {
            FastClick.attach(document.body);
            resizefunc.push("initscrolls");
            resizefunc.push("changeptype");

            $(".animate-number").each(function () {
                $(this).animateNumbers(
                    $(this).attr("data-value"),
                    true,
                    parseInt($(this).attr("data-duration"))
                );
            });

            //RUN RESIZE ITEMS
            $(window).resize(debounce(resizeitems, 100));
            $("body").trigger("resize");

            // right side-bar toggle
            $(".right-bar-toggle").on("click", function (e) {
                $("#wrapper").toggleClass("right-bar-enabled");
            });

            var tabIndexs = 0;
            var currentTab = "";
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "6000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }

            $("#createTab").click(function (event) {
                /* Act on the event */
                tabIndexs += 1;
                // add tab
                addTab(tabIndexs);

                currentTab = "#profile" + tabIndexs;

                // set tab active
                activaTab("#profile" + tabIndexs);
            });

            $(document).on("click", ".nav-link", function (event) {
                event.preventDefault();
                /* Act on the event */
                currentTab = $(this).attr("href");
            });

            $(document).on("click", "#close-tab", function (event) {
                event.preventDefault();

                if (
                    currentTab ===
                    $(this)
                        .parent()
                        .find("a")
                        .attr("href")
                ) {
                    // active current tab after removed
                    var href = $(this)
                        .parent()
                        .prev()
                        .find("a")
                        .attr("href");
                    activaTab(href);
                    currentTab = href;
                }

                // remove tab content
                var tabId = $(this)
                    .parent()
                    .find("a")
                    .attr("href")
                    .substr(1);
                $("#" + tabId).remove();

                $(this)
                    .parent()
                    .remove();
            });

            $(document).on("click", ".gender-radio input[type=radio]", function () {
                /* Act on the event */
                var gender = $(this)
                    .parent()
                    .parent()
                    .find("input[type=hidden]");
                gender.val($(this).val());
            });

            $("#form-nhankhau").on("submit", function (event) {
                event.preventDefault();
                $("#wait").css("display", "block");
                var tabs = $("#myTabaltContent > .tab-pane").toArray();
                var tab_idx = 0;

                $.ajax({
                    url: $(this).attr("action"),
                    type: "POST",
                    data: $(this).serialize(),
                    contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                    dataType: "json",
                    success: function (data) {
                        $("#wait").css("display", "none");
                        if ($.isEmptyObject(data.error)) {
                            if (data.message_type == 'alert')
                            {
                                Command: toastr["success"](data.success);
                            }else{
                                printMsg("#success-msg", data.success);
                            }
                            if (data.url) {
                                window.location.href = data.url;
                            }
                        }
                        else
                        {
                            var n = data.error[0].indexOf(".");
                            tab_idx = data.error[0].substring(n + 1, n + 2);

                            // check tab index exist
                            if (tab_idx.match(/\d+/g) != null) {
                                if (data.message_type == 'alert') {
                                    Command: toastr["error"](data.error[0].substr(n + 2));
                                }
                                else
                                {
                                    printMsg("#error-msg", data.error[0].substr(n + 2));
                                }

                                // active tab
                                if (tabs.length > 1) {
                                    activaTab("#" + tabs[tab_idx].id);
                                    $("#" + tabs[tab_idx].id).addClass("active in");
                                }
                            } else {
                                if (data.message_type == 'alert')
                                {
                                    Command: toastr["error"](data.error[0]);
                                }
                                else
                                {
                                    printMsg("#error-msg", data.error[0]);
                                }
                                // printMsg("#error-msg", data.error[0]);
                                
                            }
                        }
                        window.scrollTo(0, 0);
                        // window.location.href = "/nhan-khau/";
                    },
                    error: function (data) {
                        $("#wait").css("display", "none");
                        var errors = $.parseJSON(data.responseText);
                        $.each(errors, function (key, value) {
                            console.log(data.responseText);
                        });
                    }
                });
            });

            $("#form-user").on("submit", function (event) {
                event.preventDefault();
                $("#wait").css("display", "block");
                var tabs = $("#myTabaltContent > .tab-pane").toArray();
                var tab_idx = 0;

                $.ajax({
                    url: $(this).attr("action"),
                    type: "POST",
                    data: $(this).serialize(),
                    contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                    dataType: "json",
                    success: function (data) {
                        $("#wait").css("display", "none");
                        if ($.isEmptyObject(data.error)) {
                            if (data.message_type == 'alert') {
                                Command: toastr["success"](data.success);
                            }
                            else {
                                printMsg("#success-msg", data.success);
                            }
                            if (data.url) {
                                window.location.href = data.url;
                            }
                        } else {
                            if (data.message_type == 'alert') {
                                Command: toastr["error"](data.error[0]);
                            }
                            else {
                                printMsg("#error-msg", data.error[0]);
                            }
                        }
                    },
                    error: function (data) {
                        $("#wait").css("display", "none");
                        var errors = $.parseJSON(data.responseText);
                        $.each(errors, function (key, value) {
                            console.log(data.responseText);
                        });
                    }
                });
            });

            $(document).on("click", ".pagination a", function (event) {
                event.preventDefault();
                $("#wait").css("display", "block");
                var idresult = $("#tim-kiem-hoso").attr("idresult");
                var page = $(this).attr("href").split("page=")[1];
                $.ajax({
                    url: $("#tim-kiem-hoso").attr("action") + "?page=" + page,
                    type: "GET",
                    data: $("#tim-kiem-hoso").serialize(),
                    contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                    dataType: "json",
                    success: function (data) {
                        $("#wait").css("display", "none");
                        if ($.isEmptyObject(data.error)) {
                            if (idresult) {
                                $("#" + idresult).html(data.html);
                            }

                            if (data.url) {
                                window.location.href = data.url;
                            }
                        } else {
                            printMsg("#error-msg", data.error[0]);
                        }
                        window.scrollTo(0, 0);
                    },
                    error: function (data) {
                        var errors = $.parseJSON(data.responseText);
                        $.each(errors, function (key, value) {
                            console.log(data.responseText);
                        });
                    }
                });
            });

            $("#submitBtn").on("click", function (event) {
                event.preventDefault();
                $("#wait").css("display", "block");
                var current_form = $(this).parents("form");
                var idresult = current_form.attr("idresult");
                var page = 1;
                $.ajax({
                    url: current_form.attr("action") + "?page=" + page,
                    type: "GET",
                    data: current_form.serialize(),
                    contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                    dataType: "json",
                    success: function (data) {
                        $("#wait").css("display", "none");
                        $("#error-msg").css("display", "none");
                        
                        if ($.isEmptyObject(data.error)) {
                            if (idresult) {
                                $("#" + idresult).html(data.html);
                            }

                            if (data.url) {
                                window.location.href = data.url;
                            }
                        } else {
                            printMsg("#error-msg", data.error[0]);
                        }
                        window.scrollTo(0, 0);
                    },
                    error: function (data) {
                        $("#wait").css("display", "none");
                        var errors = $.parseJSON(data.responseText);
                        $.each(errors, function (key, value) {
                            console.log(data.responseText);
                        });
                    }
                });
            });
            
            $("#donvi").on('change', function () {
                var donvi = $('#donvi').val();
                var url = bare_url + '/ajax-get-doi/' + donvi;
                ajax_get_data_to_html_json(url, '.doicongtac');
            });

            $("#module").on('change', function () {
                var idmodule = $('#module').val();
                var iduser = $('#iduser').val();
                if (idmodule)
                {
                    var url = bare_url + '/ajax-get-chuc-nang/'+iduser+'/'+idmodule;
                    ajax_get_data_to_html_json(url, '#chucnanglist');
                }else{
                    $('#chucnanglist').empty();
                }
                
            });

            $("#iddoicongtac").on('change', function () {
                var doicongtac_id = $('#iddoicongtac').val();
                var url = bare_url + '/ajax-get-can-bo/' + doicongtac_id;
                ajax_get_data_to_html_json(url, '.canbo');
            });

            if ($(".datepicker_get_date_after_a_week").length > 0) {
                var current_date = new Date();
                current_date.setDate(current_date.getDate() + 7);
                $('.datepicker_get_date_after_a_week').datepicker({
                    autoclose: true,
                    format: 'dd-mm-yyyy',
                    language: 'vi',
                    todayHighlight: true
                }).datepicker('update', current_date);
            }

            if ($(".datepicker_get_current_date").length > 0) {
                $('.datepicker_get_current_date').datepicker({
                    autoclose: true,
                    format: 'dd-mm-yyyy',
                    language: 'vi',
                    todayHighlight: true
                }).datepicker('update', new Date());
            }
        };

        //initilizing
        (App.prototype.init = function () {
            var $this = this;
            //document load initialization
            $(document).ready($this.onDocReady);
            //init side bar - left
            $.Sidemenu.init();
            //init fullscreen
            $.FullScreen.init();
        }),
            ($.App = new App()),
            ($.App.Constructor = App);
    })(window.jQuery),
    //initializing main application module
    (function ($) {
        "use strict";
        $.App.init();
    })(window.jQuery);

//this full screen
var toggle_fullscreen = function () { };

var activaTab = function (tab) {
    $(".tab-pane").removeClass("active");
    $(".tab-pane").removeClass("in");
    $('.nav-tabs a[href="' + tab + '"]').tab("show");
};

var addTab = function (tabIndexs) {
    var el = '<li class="nav-item">';
    el +=
        '<a class="nav-link" id="profile-tab' +
        tabIndexs +
        '" data-toggle="tab" href="#profile' +
        tabIndexs +
        '" role="tab" aria-controls="profile">';
    el += "NK " + tabIndexs;
    el += "</a>";
    el += '<i class="mt-close-tab fa fa-times" id="close-tab"></i>';
    el += "</li>";
    $("#myTabalt").append(el);

    // add tab content
    el =
        '<div role="tabpanel" class="tab-pane fade in" id="profile' +
        tabIndexs +
        '" aria-labelledby="profile-tab">';
    el += $("#home1 div")
        .clone()
        .html();
    el += "</div>";
    $("#myTabaltContent").append(el);

    // remove redundant element
    $("#profile" + tabIndexs)
        .find(".hokhau-code")
        .remove();
    $("#profile" + tabIndexs)
        .find(".tab-header h4")
        .remove();

    // add title
    el =
        '<h4 class="header-title m-t-0 m-b-30">THÔNG TIN NHÂN KHẨU ' +
        tabIndexs +
        "</h4>";
    $("#profile" + tabIndexs)
        .find(".tab-header")
        .append(el);

    // gender
    $("#profile" + tabIndexs)
        .find("input[type=radio]")
        .attr("name", "gender" + tabIndexs);

    // Select2
    $("#profile" + tabIndexs)
        .find(".select2-container")
        .remove();
    $("#profile" + tabIndexs)
        .find(".select2")
        .select2();

    $("#profile" + tabIndexs)
        .find(".cke")
        .remove();
    var config = {};
    config.entities_latin = false;
    $("#profile" + tabIndexs)
        .find(".ckeditor")
        .ckeditor(config);
    // $(".gender").val('');
};

var printMsg = function (el, data) {
    $(".alert").hide();
    $(el).html("");
    $(el).append(data);
    $(el).css("display", "block");
};

function executeFunctionByName(functionName, context /*, args */) {
    var args = [].slice.call(arguments).splice(2);
    var namespaces = functionName.split(".");
    var func = namespaces.pop();
    for (var i = 0; i < namespaces.length; i++) {
        context = context[namespaces[i]];
    }
    return context[func].apply(this, args);
}
var w, h, dw, dh;
var changeptype = function () {
    w = $(window).width();
    h = $(window).height();
    dw = $(document).width();
    dh = $(document).height();

    if (jQuery.browser.mobile === true) {
        $("body")
            .addClass("mobile")
            .removeClass("fixed-left");
    }

    if (!$("#wrapper").hasClass("forced")) {
        if (w > 990) {
            $("body")
                .removeClass("smallscreen")
                .addClass("widescreen");
            $("#wrapper").removeClass("enlarged");
        } else {
            $("body")
                .removeClass("widescreen")
                .addClass("smallscreen");
            $("#wrapper").addClass("enlarged");
            $(".left ul").removeAttr("style");
        }
        if (
            $("#wrapper").hasClass("enlarged") &&
            $("body").hasClass("fixed-left")
        ) {
            $("body")
                .removeClass("fixed-left")
                .addClass("fixed-left-void");
        } else if (
            !$("#wrapper").hasClass("enlarged") &&
            $("body").hasClass("fixed-left-void")
        ) {
            $("body")
                .removeClass("fixed-left-void")
                .addClass("fixed-left");
        }
    }
    toggle_slimscroll(".slimscrollleft");
};

var debounce = function (func, wait, immediate) {
    var timeout, result;
    return function () {
        var context = this,
            args = arguments;
        var later = function () {
            timeout = null;
            if (!immediate) result = func.apply(context, args);
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) result = func.apply(context, args);
        return result;
    };
};

function resizeitems() {
    if ($.isArray(resizefunc)) {
        for (i = 0; i < resizefunc.length; i++) {
            window[resizefunc[i]]();
        }
    }
}

function initscrolls() {
    if (jQuery.browser.mobile !== true) {
        //SLIM SCROLL
        $(".slimscroller").slimscroll({
            height: "auto",
            size: "5px"
        });

        $(".slimscrollleft").slimScroll({
            height: "auto",
            position: "right",
            size: "5px",
            color: "#dcdcdc",
            wheelStep: 5
        });
    }
}
function toggle_slimscroll(item) {
    if ($("#wrapper").hasClass("enlarged")) {
        $(item)
            .css("overflow", "inherit")
            .parent()
            .css("overflow", "inherit");
        $(item)
            .siblings(".slimScrollBar")
            .css("visibility", "hidden");
    } else {
        $(item)
            .css("overflow", "hidden")
            .parent()
            .css("overflow", "hidden");
        $(item)
            .siblings(".slimScrollBar")
            .css("visibility", "visible");
    }
}

function ajax_get_data_to_html_json(url, attr_result)
{
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: url,
        type: "GET",
        dataType: "json",
        success: function (data) {
            if ($.isEmptyObject(data.error)) {
                if (attr_result) {
                    $(attr_result).empty();
                    $(attr_result).val(null).trigger("change");
                    $(attr_result).html(data.html);
                }

                if (data.url) {
                    window.location.href = data.url;
                }
            } else {
                printMsg("#error-msg", data.error[0]);
            }
        },
        error: function (data) {
            var errors = $.parseJSON(data.responseText);
            $.each(errors, function (key, value) {
                console.log(data.responseText);
            });
        }
    });
}
