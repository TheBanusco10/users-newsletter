(function ($) {

    const sendEmailButton = $('[data-send-email]');
    checkSendEmailButton();

    $('.user').on('click', function () {
        $(this).hasClass('user-selected') ? $(this).removeClass('user-selected') : $(this).addClass('user-selected');

        checkSendEmailButton();

    });

    $('[data-send-email]').on('click', function(evt) {
       evt.preventDefault();
       const users = $('.user-selected');

       const emails = $.map(users, function (el, index) {
           return el.querySelector('.email').textContent.trim();
       });

       $.ajax({
           type: 'POST',
           url: ajax.ajaxurl,
           dataType: 'json',
           data: {
               action: 'users_newsletter_sendEmailToUsers',
               emails
           }
       }).done(function (res) {
           console.log(res)
           $('.send-email-container').append(`
           
            <p>${res.message}:</p>
            <ul>
                ${res.emails.map(email => {
                    return '<li>' + email.toString() + '</li>'
                }).join('')}
            </ul>
           
           `);
       });

    });

    function checkSendEmailButton() {
        const users = $('.user-selected');
        users.length == 0 ? sendEmailButton.css('display', 'none') : sendEmailButton.css('display', '');
    }

})(jQuery)