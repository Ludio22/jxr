$(document).ready(function () {
    $('.user__avatar img').click(function () {
        $("#avatar-checker").trigger('click');
    });
    $('#avatar-checker').change(function () {
        $("#put-avatar").trigger('click');
    });
    $('.user__switch-to-chat').click(function () {
        if ($(this).val() == "Пись Пись") {
            $.ajax({
                url: "up_switcher.php",
                type: "POST",
                data: ({
                    target: 'chat'
                }),
                dataType: "html",
                success: function (data) {
                    $('.user__meta + div').remove();
                    $('.user').append(data);
                    $('.user__switch-to-chat').val('см см');
                }
            });
        } else {
            $.ajax({
                url: "up_switcher.php",
                type: "POST",
                data: ({
                    target: 'view',
                    user: document.location.search.substring(1),
                }),
                dataType: "html",
                success: function (data) {
                    $('.user__meta + div').remove();
                    $('.user').append(data);
                    $('.user__switch-to-chat').val('Пись Пись');
                }
            });
        }
    });


    //ПРИМЕРЫ ДИНАМИЧЕСКОГО ПРИСВОЕНИЯ ОБРАБОТЧИКОВ В JQUERY
    $(document).bind('keydown', '.message-sender', function (e) {
        if (e.keyCode === 13) {
            if ($("#message-box").val() != "") {
                $.ajax({
                    url: "message-send.php",
                    type: "POST",
                    data: ({
                        text: $("#message-box").val(),
                    }),
                    dataType: "html",
                    success: function (data) {
                        //console.log(data);
                        $('.user__messages').append(data);
                        $("#message-box").val("");
                    },
                });
            }
        }
    });

    $(document).on('click', '.message-sender', function () {
        if ($("#message-box").val() != "") {
            $.ajax({
                url: "message-send.php",
                type: "POST",
                data: ({
                    text: $("#message-box").val(),
                }),
                dataType: "html",
                success: function (data) {
                    $('.user__messages').append(data);
                    $("#message-box").val("");
                },
            });
        }
    });

    let userInfo = ['hobbies', 'birthday', 'dream'];

    for (let index = 0; index < userInfo.length; index++) {
        $(".user__info-data." + userInfo[index]).click(function () {
            if (!$('input').is('.user__info-input')) {
                if (userInfo[index] != 'birthday') {
                    $(".user__info-item." + userInfo[index]).append(`<input type='text' style="margin-left: 1em;" class='user__info-input ${userInfo[index]}'>`);
                } else {
                    $(".user__info-item." + userInfo[index]).append(`<input type='date' style="margin-left: 1em;" class='user__info-input ${userInfo[index]}'>`);
                }
            }
        });

        $(document).bind('keydown', '.user__info-input.' + userInfo[index], function (e) {
            if (e.keyCode == 13) {
                $(".user__info-data." + userInfo[index]).text($('.user__info-input.' + userInfo[index]).val());
                $('.user__info-input.' + userInfo[index]).remove();
            }
        });
    }

    // Если нужно что то постоянно проверять - нужно юзать setInterval(func, time ms)
    setInterval(function () {
        $.ajax({
            type: "POST",
            url: "update-messages.php",
            data: {},
            dataType: "html",
            success: function (data) {
                if (data != $('.user__messages').html()) {
                    //console.log(data);
                    $('.user__messages').empty();
                    $('.user__messages').append(data);
                }
            }
        });
    }, 5000);
});