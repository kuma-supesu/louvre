$('ul').css("margin-top", "10px")
$('input').click(function () {
    $('#message_reduc').remove();
    if ($(this).prop('checked')) {
        $('H1').after('<p id="message_reduc">Il sera nécessaire de présenter sa carte d\'étudiant, militaire ou équivalent à l\'entrée du musée.</p>')
        $('p').css("color", "red")
        $('ul').css("margin-top", "-30px")
    } else {
        $('ul').css("margin-top", "10px")
    }
})
$('input').css("textTransform", "uppercase")
