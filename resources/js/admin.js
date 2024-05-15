($ => {
    $(() => {
        const mainChatInbox = $(".chat-content");

        const formatDateTime = dateTimeString => {
            const options = {
                year: 'numeric',
                month: 'short',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit'
            }

            return new Intl.DateTimeFormat('en-Us', options).format(new Date(dateTimeString));
        }

        const scrollToBottom = () => {
            mainChatInbox.scrollTop(mainChatInbox.prop("scrollHeight"));
        }

        let {Echo, USER} = window;

        Echo.private('message.' + USER.id).listen(
            "ChatMessageEvent",
            e => {
                console.log(e);

                const {sender_id, sender_image, message, date_time, unseen_messages} = e;

                if (mainChatInbox.attr("data-inbox").toString() === sender_id.toString()) {
                    const chat = `<div class="chat-item chat-left">
                            <img src="${sender_image}" alt="">
                            <div class="chat-details">
                                <div class="chat-text">${message}</div>
                                <div class="chat-time">${formatDateTime(date_time)}</div>
                            </div>
                        </div>`;

                    mainChatInbox.append(chat);
                    scrollToBottom();
                }

                $(".chat-user-profile").each((index, element) => {
                    const $this = $(element);
                    const profileUserId = $this.data("id");

                    if (profileUserId.toString() === sender_id.toString()) {
                        $this.find(".pending").removeClass("d-none").text(unseen_messages);
                    }
                });
            }
        );
    });
})(jQuery);
