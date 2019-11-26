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
        });
    })
})(jQuery);