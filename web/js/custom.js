$(function () {
    $(document).on('click', '.add-to-cart', function () {
        $('.modal').modal('show');
        $.ajax({
            type: "POST",
            url: $(this).data('url'),
            success: function (data) {
                setTimeout(function () {
                    $('.modal').modal('hide');
                }, 1000);
                $('#flash-msg').html(data).fadeIn('slow');
                $('#flash-msg').delay(1500).fadeOut('slow');
            }
        })
    });
})
