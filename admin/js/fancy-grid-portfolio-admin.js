(function ($) {
    'use strict';

    /*
     Do drag drop sort using jQuery UI
     */
    var portfolioSortList = $('ul#portfolio-sort-list');
    var loading = $('.loading');
    var orderSaveMsg = $('.order-save-msg');
    var orderSaveErr = $('.order-save-err');

    portfolioSortList.sortable({
        update: function (e, ui) {
            loading.show();

            $.ajax({
                url: ajaxurl, // WordPress ajax URL
                type: 'post',
                dataType: 'json',
                data: {
                    action: 'save_order',  //
                    order: portfolioSortList.sortable('toArray'),
                    token: FGP_PORTFOLIO.token
                },
                success: function (res) {
                    loading.hide();
                    if (true === res.success) {
                        orderSaveMsg.show();
                        setTimeout(function () {
                            orderSaveMsg.hide();
                        }, 2000);
                    } else {
                        orderSaveErr.show();
                        setTimeout(function () {
                            orderSaveErr.hide();
                        }, 2000);
                    }
                },
                error: function (err) {
                    orderSaveErr.show();
                    setTimeout(function () {
                        orderSaveErr.hide();
                    }, 2000);
                }
            });
        }
    });

})(jQuery);
