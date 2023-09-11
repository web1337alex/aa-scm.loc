jQuery(document).ready(function($) {
    allForms = $('.sc-form');
    allForms.each(function(index) {
        el = $(this);
        inputBox = el.find('.inputbox.submit');
        submitText = inputBox.find('input').val;

        var options = {
            url: ajax_form_object.url,
            data: {
                action: 'ajax_form_action',
                nonce: ajax_form_object.nonce
            },
            type: 'POST',
            dataType: 'json',
            beforeSubmit: function(xhr) {

                if (!el.find('.form_row .msg').length) { // Добавляем только, если сообщения нет
                    inputBox.parent('.form_row').append('<div class="msg loader"></div>');
                }
            },
            success: function(request, xhr, status, error) {

                if (request.success === true){
                    var msgElement = el.find(".form_row > .msg");
                    msgElement.removeClass('loader');
                    msgElement.addClass('success');
                    msgElement.html(request.data);
    
                    setTimeout(function() {
                        msgElement.remove();
                    }, 3000);
                }
                else{
                    $.each(request.data, function (key, val){
                        var msgElement = el.find(".form_row > .msg");
                        msgElement.removeClass('loader');
                        msgElement.addClass('danger');
                        msgElement.html(val);
        
                        setTimeout(function() {
                            msgElement.remove();
                        }, 3000);
                    });
                }
            },
            error: function(request, status, error) {
                var msgElement = el.find(".form_row > .msg");
                msgElement.removeClass('loader');
                msgElement.addClass('error');
                msgElement.html(error);

                setTimeout(function() {
                    msgElement.remove();
                }, 3000);
            },
        };

        // Отправка формы
        el.ajaxForm(options);
    });
});