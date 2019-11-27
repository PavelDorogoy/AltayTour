(function ($) {
    $(function () {
        $(document).ready(function(){
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
            /*-----------------
               Registration popup
            ------------------*/
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
                        console.log(response);
                        tourProducts.html($(response).find('#tour-product').html());
                    }
                });
            });

        });
    })
})(jQuery);