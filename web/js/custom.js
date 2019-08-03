$(function () {
    $(document).on('click', '.add-to-cart', function () {
        $.ajax({
            type: "POST",
            url: $(this).data('url'),
            success: function (data) {
                $('#flash-msg').html(data).fadeIn('slow');
                $('#flash-msg').delay(2000).fadeOut('slow');
            }
        })
    });
})
