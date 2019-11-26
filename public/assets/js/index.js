// Main js file
// Slider

$('.slider').slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    variableWidth: true,
    responsive: [{
        breakpoint: 1301,
        settings: {
            slidesToShow: 5,
            slidesToScroll: 3,
        }
        },{
          breakpoint: 1180,
          settings: {
              slidesToShow: 4,
              slidesToScroll: 3,
          }
        },{
            breakpoint: 1025,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
            }
        }, {
            breakpoint: 600,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2,
            }
        }, {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
            }
        }]
});

// Hamburger
$(document).ready(function(){
	$('#nav-icon').click(function(){
		$(this).toggleClass('open');
	});
});

// Sidebar
(function(){
    var d = document,
            btnMenuOpen = d.querySelector('.button-menu'),
            html = d.querySelector('html'),
            body = d.querySelector('body'),
            menuContainer = d.querySelector('.sidebar');
            var isOpen = false;

    if (btnMenuOpen) {
        btnMenuOpen.addEventListener('click', e => {
            e.stopPropagation();
            e.preventDefault();
            if(isOpen == false) {
                $('body').scrollTop(0);
                $("html").scrollTop(0);
                window.scrollTo(0, 0);
                body.classList.add('overflow-scroll');
                menuContainer.classList.add('active');
                btnMenuOpen.classList.add('active');
                html.classList.add('overflow-scroll');
                isOpen = true;
            } else {
                body.classList.remove('overflow-scroll');
                menuContainer.classList.remove('active');
                btnMenuOpen.classList.remove('active');
                html.classList.remove('overflow-scroll');
                isOpen = false;
            }
        });
    }
})();

// Tabs
(function(){
  var d = document,
      tabs = d.querySelector('.tabs'),
      tab = d.querySelectorAll('li'),
      contents = d.querySelectorAll('.content');
      if (tabs) {
        tabs.addEventListener('click', function(e) {
            if (e.target && e.target.nodeName === 'LI') {
              // change tabs
              for (var i = 0; i < tab.length; i++) {
                tab[i].classList.remove('active');
              }
              e.target.classList.toggle('active');
      
              // change content
              for (i = 0; i < contents.length; i++) {
                contents[i].classList.remove('active');
              }
              
              var tabId = '#' + e.target.dataset.tabId;
              d.querySelector(tabId).classList.toggle('active'); 
            }
        })
      }
      })();

// Show - Hide
$(".tour-detail-information__details-title.one").click(function(){
  $(this).toggleClass("active");
  $(".tour-detail-information__details-wrap.one").slideToggle();
});

$(".tour-detail-information__details-title.two").click(function(){
  $(this).toggleClass("active");
  $(".tour-detail-information__details-wrap.two").slideToggle();
});

$(".tour-detail-information__details-title.three").click(function(){
  $(this).toggleClass("active");
  $(".tour-detail-information__details-wrap.three").slideToggle();
});

$(".tour-detail-information__details-title.four").click(function(){
  $(this).toggleClass("active");
  $(".tour-detail-information__details-wrap.four").slideToggle();
});

$(".tour-detail-information__details-title.five").click(function(){
  $(this).toggleClass("active");
  $(".tour-detail-information__details-wrap.five").slideToggle();
});

// Popup
$('#feedback').magnificPopup({
  type:'inline',
  midClick: true
});
$('#login').magnificPopup({
  type:'inline',
  midClick: true
});
$('#registration').magnificPopup({
  type:'inline',
  midClick: true
});

// Pagination
var items = $(".list-wrapper .list-item");
    var numItems = items.length;
    var perPage = window.location.href.indexOf('news') > -1 ? 12 : 6;

    items.slice(perPage).hide();

    $('#pagination-container').pagination({
        items: numItems,
        itemsOnPage: perPage,
        prevText: "&laquo;",
        nextText: "&raquo;",
        onPageClick: function (pageNumber) {
            var showFrom = perPage * (pageNumber - 1);
            var showTo = showFrom + perPage;
            items.hide().slice(showFrom, showTo).show();
        }
    });

//Image
$('.without-caption').magnificPopup({
  type: 'image',
  closeOnContentClick: true,
  closeBtnInside: false,
  mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
  image: {
    verticalFit: true
  },
  zoom: {
    enabled: true,
    duration: 300 // don't foget to change the duration also in CSS
  }
});

//Gallery
$(document).ready(function() {
	$('.popup-gallery').magnificPopup({
		delegate: 'a',
		type: 'image',
		tLoading: 'Loading image #%curr%...',
		mainClass: 'mfp-img-mobile',
		gallery: {
			enabled: true,
			navigateByImgClick: true,
			preload: [0,1] // Will preload 0 - before current, and 1 after the current image
		},
		image: {
			tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
		}
	});
});

// Btn back
$('#btn-back').click(() => {
  window.history.back();
});

//
$(".book-date-select div").click(function() {
  var activeTab = $(this).attr("rel");
  $("#"+activeTab).fadeIn();
  $(".book-date-select div").removeClass("active");
  $(this).addClass("active");
});

// Add participants
$("#participants").click(function() {
  var table = document.getElementById("table-participants");
  var row = table.insertRow(-1);
  var cell1 = row.insertCell(0);
  var cell2 = row.insertCell(1);
  var cell3 = row.insertCell(2);
  var cell4 = row.insertCell(3);
  var cell5 = row.insertCell(4);
  var cell6 = row.insertCell(-1);
  cell1.innerHTML = table.rows.length - 1;
  cell2.innerHTML = '<input value="" class="input" placeholder="Введите фамилию и имя участника" type="text" pattern=".+" required />';
  cell3.innerHTML = '<input value="" class="input" placeholder="Номер телефона type="tel" pattern=".+" required />';
  cell4.innerHTML = '<ul class="equipments"><li><div><input value="" class="input" placeholder="Введите название снаряжения" type="text" pattern=".+" /><a href="#"><i class="material-icons">add_circle</i></a></div></li></ul>';
  cell5.innerHTML = '<ul class="equipment-count"><li><div class="add-equipment"><input id="equipment-new" value="0" class="count" placeholder="Введите кол-во" type="number" pattern=".+" /><a href="#"><i class="material-icons">add_circle</i></a></div></li></ul>';
  cell6.innerHTML = '<input type="button" class="material-icons" onclick="deleteRowParticipants(this)" value="delete"/></td>';
});

// Add instructor
$("#instructors").click(function() {
  var table = document.getElementById("table-instructors");
  var row = table.insertRow(-1);
  var cell1 = row.insertCell(0);
  var cell2 = row.insertCell(1);
  var cell3 = row.insertCell(2);
  var cell4 = row.insertCell(-1);
  cell1.innerHTML = table.rows.length - 1;
  cell2.innerHTML = '<input value="" class="input" placeholder="Введите фамилию и имя инструктора" type="text" pattern=".+" required />';
  cell3.innerHTML = '<input value="" class="input" placeholder="Введите номер телефона инструктора" type="tel" pattern=".+" required />';
  cell4.innerHTML = '<input type="button" class="material-icons" onclick="deleteRow(this)" value="delete"/>';
});

// Add снаряжение
$(".equipment-new").click(function() {
  $(".equipments").append('<li><div><input value="" class="input" placeholder="Введите название снаряжения" type="text" pattern=".+" /><a href="#" class="equipment-new"><i class="material-icons">add_circle</i></a></div></li>');
  $(".equipment-count").append('<li><div class="add-equipment"><input value="0" class="count" placeholder="Введите кол-во" type="number" pattern=".+" /><a href="#" class="equipment-count-new"><i class="material-icons">add_circle</i></a></div></li>');
});

// Add кол-во снаряжения
$(".equipment-count-new").click(function() {
  $(".equipment-count").append('<li><div class="add-equipment"><input value="0" class="count" placeholder="Введите кол-во" type="number" pattern=".+" /><a href="#" class="equipment-count-new"><i class="material-icons">add_circle</i></a></div></li>');
  $(".equipments").append('<li><div><input value="" class="input" placeholder="Введите название снаряжения" type="text" pattern=".+" /><a href="#" class="equipment-new"><i class="material-icons">add_circle</i></a></div></li>');
});

// Add тур
$("#add-tour").click(function() {
  var table = document.getElementById("table-tours");
  var row = table.insertRow(-1);
  var cell1 = row.insertCell(0);
  var cell2 = row.insertCell(1);
  var cell3 = row.insertCell(2);
  var cell4 = row.insertCell(3);
  var cell5 = row.insertCell(4);
  var cell6 = row.insertCell(5);
  var cell7 = row.insertCell(-1);
  cell1.innerHTML = table.rows.length - 1;
  cell2.innerHTML = '<input value="" class="input" placeholder="Введите Название тура" type="text" pattern=".+" required />';
  cell3.innerHTML = '0';
  cell4.innerHTML = '0';
  cell5.innerHTML = '0';
  cell6.innerHTML = '<a href="/admin-edit-tour"><i class="material-icons">edit</i></a>';
  cell7.innerHTML = '<input type="button" class="material-icons" onclick="deleteRowTour(this)" value="delete"/>';
});