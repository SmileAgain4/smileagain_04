var chat = io.connect("ws://localhost:8080/chat?userId="+userId);

$(function() {
    var chatData = {
        sendMessage: function(e) {
            chat.emit("send", e);
        },
        MessageAdd: function(e) {
            $(".cont_chat ul").append(
                "<li>" +
                "<div class=\"inner_talk\">" +
                "<div class=\"user_thumb\"><a href=\"#\"><img src=\""+g5_url+"/img/no_profile.gif\" width=\"40\" height=\"40\" alt=\"프로필 이미지\"></a></div>"+
                "<div class=\"talk_info\">" +
                "<strong class=\"name\">"+e.message['usernick']+"</strong>"+
                "<div class=\"bubble\"><p class=\"txt\">"+e.message['contents']+"</p></div>"+
                "</div>"+
                "</div>" +
                "</li>"
            );
        },
        clearChatLog: function() {
            $(".cont_chat ul").html('');
        }
    };

    $("#msgInputArea").attr('placeholder', '메시지를 입력해주세요,');

    chat.on("connect", function() {
        chatData.clearChatLog();
        $(".cont_chat ul").append("<li class=\"notice\">채팅방에 입장하셨습니다.</li>");

        chat.on("msg", function(e) {
            chatData.MessageAdd(e);
        });
    });

    $("#msgInputArea").on('keydown', function (e) {
        if (e.keyCode == 13)
            if (!e.shiftKey) {
                e.preventDefault();

                chatData.sendMessage({"message":$(this).val(),"messageTypeCode":"1"});
                $(this).val('');
            }
    });
});

chat.on("connect_error", function() {
    alert('채팅방 연결에 실패하였습니다.');
   chat.close();
});