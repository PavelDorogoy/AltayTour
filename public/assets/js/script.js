/*-----------------
   Login popup
------------------*/
let loginPopup = $('#popup-login');
$.ajax({
    type: "POST",
    url: "/login",
    cache: true,
    async: true,
    success:function(response)
    {
        loginPopup.html(response);
        loginPopup.find('#error-popup-login').remove();
        loginPopup.find('#registration').magnificPopup({
            type:'inline',
            midClick: true
        });
    }
});
loginPopup.on("submit", 'form', function(e) {
    e.preventDefault();
    $.ajax({
        type : $(this).attr( 'method' ),
        url : '/login',
        data : $(this).serialize(),
        success : function(response) {
            if(!response.match('id="error-popup-login"')) {
                location.reload();
            }
            else {
                loginPopup.html(response);
                loginPopup.find('#registration').magnificPopup({
                    type:'inline',
                    midClick: true
                });
            }
        }
    });
});
/*----------------------
   Registration popup
----------------------*/
let registerPopup = $('#popup-registration');
$.ajax({
    type: "POST",
    url: "/register",
    cache: true,
    async: true,
    success:function(response)
    {
        registerPopup.html(response);
    }
});
registerPopup.on("submit", 'form', function(e) {
    e.preventDefault();
    $.ajax({
        type : $(this).attr( 'method' ),
        url : '/register',
        data : $(this).serialize(),
        success : function(response) {
            registerPopup.html(response);
        }
    });
});
/*-----------------
   Tour filter
------------------*/
let tourFilter = $('#tour-filter');
if(tourFilter.length) {
    let tourProducts = $('#tour-product');
    let typeFilter = tourFilter.find('.type-select-dropdown');
    let timeFilter = tourFilter.find('.time-select-dropdown');
    let seasonFilter = tourFilter.find('.season-select-dropdown');
    let priceFilter = tourFilter.find('.price-select-dropdown');

    tourFilter.find('button').on("click", function(e) {
        let data = {};
        var type = typeFilter.attr('data-selected-value');
        let time = timeFilter.attr('data-selected-value');
        let season = seasonFilter.attr('data-selected-value');
        let price = priceFilter.attr('data-selected-value');
        if(type !== "type-never-mind") data['type'] = type;
        if(time !== "time-never-mind") data['time'] = time;
        if(season !== "season-never-mind") data['season'] = season;
        if(price !== "price-never-mind") data['price'] = price;
        let params = "";
        if(Object.keys(data).length !== 0) params = '?'+$.param(data);
        window.history.pushState('1', 'Title', window.location.pathname + params);
        $.ajax({
            type : 'GET',
            url : window.location.pathname,
            data : data,
            success : function(response) {
                tourProducts.html($(response).find('#tour-product').html());
            }
        });
    });
}
/*--------------------
   Tour change date
--------------------*/
let tourBookDate = $('#book-date');
let dateBlock;

if(tourBookDate.length) {
    let tourPageDate = $('#tour-date');
    let tourPagePrice = $('#tour-price');
    let tourPagePerson = $('#tour-person');
    let tourEquipments = $('.tour-equipment__content');
    let tourEquipmentTitle = $('.tour-equipment').find('.title');
    let tourTotalPriceBlock = $('.tour-equipment__total span');
    let tourBookButton = $('.js-tour-book-button');
    let tourUnBookButton = $('.js-tour-unbook-button');
    let tourSaveButton = $('.js-tour-save-button');
    let tourParticipants = $('.participant-card__content');
    let tourTotalPrice;
    let tourId = parseHref(window.location.href)['tour'];

    if(tourId) dateBlock = tourBookDate.find('.book-date-select-item[rel='+ tourId +']');
    else dateBlock = tourBookDate.find('.book-date-select-item').filter( ':first' );
    changeDate();

    tourEquipments.on("change", '.equipment-card input', function(e) {
        if($(this).prop('checked')) {
            tourTotalPrice += parseFloat($(this).attr('data-equipmet-price'));
        } else {
            tourTotalPrice -= parseFloat($(this).attr('data-equipmet-price'));
        }
        tourTotalPriceBlock.html(tourTotalPrice + " ₽");
    });
    tourBookDate.on("click", '.book-date-select-item', function(e) {
        dateBlock = $(this);
        changeDate();
    });
    function changeDate() {
        window.history.pushState('1', 'Title', window.location.pathname + "?tour=" + dateBlock.attr("rel"));

        let equipmentBlock = tourEquipments.filter( $( "[data-tour = " + dateBlock.attr('rel') + "]" ) );
        let tourIsBooked = Boolean(dateBlock.attr('data-booked'));
        tourTotalPrice = parseFloat(dateBlock.attr('data-price'));

        tourPageDate.html(dateBlock.html());
        tourPagePrice.html(tourTotalPrice + " руб/чел.");
        tourPagePerson.html(dateBlock.attr('data-reservation_count') + "/" + dateBlock.attr('data-count_person') + " чел.");

        tourEquipments.css('display', 'none');
        if(equipmentBlock.children().length !== 0) {
            tourEquipmentTitle.html("Забронируйте снаряжение");
            equipmentBlock.css('display', 'flex');

            equipmentBlock.find('.equipment-card').each(function () {
                let equipment = $(this).find('input');
                if(equipment.prop("checked")) {
                    tourTotalPrice += parseFloat(equipment.attr('data-equipmet-price'));
                }
            })
        }
        else {
            tourEquipmentTitle.html("");
        }
        tourTotalPriceBlock.html(tourTotalPrice + " ₽");

        tourSaveButton.hide();
        if(tourIsBooked) {
            tourBookButton.hide();
            tourUnBookButton.show();
        }
        else {
            tourBookButton.show();
            tourUnBookButton.hide();
        }

        tourParticipants.find('.participant-card-avatars').hide();
        tourParticipants.find('.participant-card-avatars[data-tour=' + dateBlock.attr("rel") + ']').show();
    }
}
/*-----------------
    Tour book
------------------*/
$('.js-tour-book-button').on("click", function(e) {
    bookTour($(this).attr('data-token'));
});
$('.js-tour-save-button').on("click", function(e) {
    bookTour($(this).attr('data-token'));
    $(this).hide();
});
$('.tour-equipment__content .equipment-card').on("change", 'input', function(e) {
    $('.js-tour-save-button').show();
});
function bookTour(token) {
    if(dateBlock.length) {
        let data = {};
        data['tour'] = dateBlock.attr('rel');
        data['token'] = token;
        data['equipments'] = [];
        $('.tour-equipment__content[data-tour = ' + dateBlock.attr('rel') + ']').find('.equipment-card').each(function () {
            let equipment = $(this).find('input');
            if(equipment.prop('checked')) {
                data['equipments'].push(equipment.attr('data-equipmet-id'));
            }
        });
        $.ajax({
            type : 'POST',
            url : '/tour-booking',
            data : data,
            success : function(response) {
                if(response === 'booked') {
                    dateBlock.attr('data-booked', 1);
                    dateBlock.addClass('booked');
                    $('.js-tour-book-button').hide();
                    $('.js-tour-unbook-button').show();
                }
            }
        });
    }
}
/*---------------------
    Tour cancel book
---------------------*/
$('.js-tour-unbook-button').on("click", function(e) {
    if(dateBlock.length) {
        let data = {};
        data['tour'] = dateBlock.attr('rel');
        data['token'] = $(this).attr('data-token');
        $.ajax({
            type : 'POST',
            url : '/tour-unbooking',
            data : data,
            success : function(response) {
                if(response === 'unbooked') {
                    dateBlock.attr('data-booked', '');
                    dateBlock.removeClass('booked');
                    $('.js-tour-book-button').show();
                    $('.js-tour-unbook-button').hide();
                }
            }
        });
    }
});
/*---------------------------
    Tour remove participant
---------------------------*/
$('.participant-card-avatar').on("click", function(e) {
    if(dateBlock.length) {
        let data = {};
        let person = $(this);
        data['tour'] = dateBlock.attr('rel');
        data['token'] = person.attr('data-token');
        data['reservation_id'] = person.attr('data-reservation');
        $.ajax({
            type : 'POST',
            url : '/tour-unbooking',
            data : data,
            success : function(response) {
                if(response === 'unbooked') {
                    person.remove();
                }
            }
        });
    }
});
/* --------------------------
    Tour right block fixed
-------------------------- */
let contentTourBlock = $('.container-detail-info');
if(contentTourBlock.length) {
    let fixedToutBlock = $('.container-detail-card .wrap-fixed');
    let contentTourBlockTop = contentTourBlock.offset().top;
    $(window).scroll(function(){
        fixationTourBlock();
    });
    function fixationTourBlock() {
        if(contentTourBlock.height() > fixedToutBlock.height()) {
            let contentTourBlockBottom = contentTourBlock.offset().top + contentTourBlock.height();

            if ($(window).scrollTop()  + $( window ).height() >= contentTourBlockTop + fixedToutBlock.height() + 20) {
                fixedToutBlock.addClass('fixed');
                fixedToutBlock.removeClass('bottom');
            }
            else {
                fixedToutBlock.removeClass('fixed');
                fixedToutBlock.removeClass('bottom');
            }
            if (($(window).scrollTop() + $( window ).height()) >= contentTourBlockBottom + 40) {
                fixedToutBlock.addClass('bottom');
                fixedToutBlock.removeClass('fixed');
            }
        }
        else {
            fixedToutBlock.removeClass('fixed');
            fixedToutBlock.removeClass('bottom');
        }
    }
}
/*---------------------
    Account routing
---------------------*/
if(window.location.pathname === "/account") {
    let page = parseHref(window.location.href)['page'];
    if(page === "mytour") {
        $('#section2 input').prop('checked', true);
    }
}
/*---------------------
    Account | My tour cancel book
---------------------*/
$('.js-my-tour-unbook-button').on("click", function(e) {
    let card = $(this).closest('.my-tour__card');
    let data = {};
    data['tour'] = card.attr('data-tour');
    data['token'] = card.attr('data-token');
    $.ajax({
        type : 'POST',
        url : '/tour-unbooking',
        data : data,
        success : function(response) {
            if(response === 'unbooked') {
                card.remove();
            }
        }
    });
});
/* --------------------------
    parse get params
-------------------------- */
function parseHref(h) {
    var iOf = h.indexOf('?');
    var a = h.substring(iOf, h.length).substr(1).split('&');
    if (a === "") return {};
    var b = {};
    for (var i = 0; i < a.length; ++i){
        var p=a[ i ].split('=');
        if (p.length !== 2) continue;
        b[p[0]] = decodeURIComponent(p[1].replace(/\+/g, " "));
    }
    return b;
}