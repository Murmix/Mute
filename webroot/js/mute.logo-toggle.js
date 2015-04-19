$(document).ready(function () {

    $(".sitelogo").on("click", function (e) {
    if (!$(this).hasClass('off')) {
        $(this).attr('src', 'img/speaker-off.png');
        $(this).addClass('off')
    } else  {
        $(this).attr('src', 'img/speaker.png');
        $(this).removeClass('off')
    }
});
});