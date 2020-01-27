$(document).ready(function(){
    $('.coin_char').on('click', function() { // Клик по параметрам
        if ($(this).hasClass('cur_select_2')) {
            $(this).removeClass('cur_select_2');
        } else {
            $(this).parent().find($('.coin_char')).removeClass('cur_select_2');
            $(this).addClass('cur_select_2')
        }
    })

    $('.create_pdf_and_send').on('click', function() {
        var this_3 = $(this);
        console.log("2"+" "+$(this_3).text());       
        if ($('.cur_select_2').length == 5) {

            $(this_3).text('КП отправлено');
            $(this_3).css('background-color', '#ccffcc');

            setTimeout(function() {
                $(this_3).text('Сформировать и отправить');
                $(this_3).css('background-color', 'buttonface'); 
            },2000);

        } else {
          alert('Выбраны не все параметры');
        }
    })
});