@extends ( 'admin.layouts.master' )

@section ( 'content' )
    <section class="section">
        <div class="section-header">
            <h1>Messages</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Components</a></div>
                <div class="breadcrumb-item">Chat Box</div>
            </div>
        </div>

        <div class="section-body">

            <div class="row align-items-center justify-content-center">
                <div class="col-md-4">
                    <div class="card" style="height: 70vh;">
                        <div class="card-header">
                            <h4>Chat List</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled list-unstyled-border">
                                @foreach ( $chatUsers as $chatUser )
                                    @php
                                        $unseenMessages = \App\Models\Chat::query()
                                            ->where([
                                                'sender_id' => $chatUser->senderProfile->id,
                                                'receiver_id' => auth()->user()->id,
                                                'seen' => 0
                                            ])->get();

                                        $countUnseenMsg = count($unseenMessages);

                                        $online = \Illuminate\Support\Facades\Cache::has(
                                                'user-is-online-' . $chatUser->senderProfile->id)
                                                && !is_null($chatUser->senderProfile->last_seen)
                                                ? 'Online ' . \Illuminate\Support\Carbon::parse(
                                                        $chatUser->senderProfile->last_seen
                                                        )->diffForHumans() : 'Offline';
                                    @endphp
                                    <li class="media chat-user-profile" data-id="{{ $chatUser->senderProfile->id }}"
                                        style="cursor: pointer">
                                        <img alt="image"
                                             class="mr-3 rounded-circle avatar-chat"
                                             width="50" src="{{ asset($chatUser->senderProfile->image) }}">
                                        <span class="pending {{ $countUnseenMsg > 0
                                            ? '' : 'd-none' }}">{{ $countUnseenMsg }}</span>
                                        <div class="media-body">
                                            <div
                                                class="mt-0 mb-1 font-weight-bold chat-user-name">{{
                                                    $chatUser->senderProfile->name }}</div>
                                            <div class="status text-{{ $online !== 'Offline' ? 'success' : 'muted'
                                                }} text-small font-600-bold">
                                                <i class="fas fa-circle"></i> {{ $online }}
                                            </div>
                                        </div>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card chat-box d-none" id="mychatbox" style="height: 70vh;">
                        <div class="card-header">
                            <h4 id="chat-inbox-title"></h4>
                        </div>
                        <div class="card-body chat-content" data-inbox="">

                        </div>
                        <div class="card-footer chat-form">
                            <form id="message-form">
                                @csrf
                                <input type="text" class="form-control message-box" placeholder="Type a message"
                                       name="message" aria-label="message">
                                <input type="hidden" name="receiver_id" value="" id="receiver_id">
                                <button type="submit" class="btn btn-primary">
                                    <i class="far fa-paper-plane"></i></button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection

@push ( 'scripts' )
    <script>
        ($ => {
            $(() => {
                const $body = $("body");
                const mainChatInbox = $(".chat-content");
                const $messageBox = $(".message-box");

                const formatDateTime = dateTimeString => {
                    const options = {
                        year: 'numeric',
                        month: 'short',
                        day: '2-digit',
                        hour: '2-digit',
                        minute: '2-digit'
                    }

                    return new Intl.DateTimeFormat('en-Us', options)
                        .format(new Date(dateTimeString));
                }

                const scrollToBottom = () => {
                    mainChatInbox.scrollTop(mainChatInbox.prop("scrollHeight"));
                }

                const getOnlineStatus = () => {
                    let userIds = [];

                    $(".chat-user-profile").each((index, element) => {
                        const $this = $(element);
                        userIds.push($this.data("id"));
                    });

                    $.ajax({
                        url: "{{ route('user.get-online-status') }}",
                        method: 'GET',
                        data: {userIds: userIds},
                        success: response => {
                            $(".chat-user-profile").each((index, element) => {
                                const $this = $(element);
                                const profileUserId = $this.data("id");
                                const state = response[profileUserId] || "Offline"; // Handle missing status

                                $this.find(".status").html('<i class="fas fa-circle"></i>' + ' ' + state);

                                if (state !== "Offline") {
                                    $this.find(".status").removeClass("text-muted");
                                    $this.find(".status").addClass("text-success");
                                } else {
                                    $this.find(".status").removeClass("text-success");
                                    $this.find(".status").addClass("text-muted");
                                }
                            });
                        },
                        error: (xhr, status, error) => {
                            console.log(error);
                            console.error(`Error: ${status}`);
                            console.error(xhr.responseText);
                        }
                    });
                }

                getOnlineStatus();
                setInterval(getOnlineStatus, 33000);

                const viewChat = () => {
                    $body.on("click", ".chat-user-profile", e => {
                        const $this = $(e.currentTarget);

                        const receiverId = $this.data("id");
                        const receiverImage = $this.find("img").attr("src")
                        const chatUserName = $this.find(".chat-user-name").text();

                        $this.find(".pending").addClass("d-none");
                        $(".chat-box").removeClass("d-none");
                        mainChatInbox.attr("data-inbox", receiverId);
                        $("#receiver_id").val(receiverId);

                        $.ajax({
                            method: 'GET',
                            url: '{{ route("admin.get-messages") }}',
                            data: {
                                receiver_id: receiverId
                            },
                            beforeSend: () => {
                                mainChatInbox.html("");
                                // set chat inbox title
                                $("#chat-inbox-title").text(`Chat With ${chatUserName}`)
                            },
                            success: response => {
                                const {USER} = window;

                                $.each(response, (index, value) => {
                                    let chat;

                                    const {sender_id, message, created_at} = value;

                                    if (sender_id.toString() === USER.id.toString()) {
                                        chat = `<div class="chat-item chat-right">
                                            <img style="height: 50px; object-fit: cover;"
                                                class="avatar-chat" src="${USER.image}" alt="">
                                            <div class="chat-details">
                                                <div class="chat-text">${message}</div>
                                                <div class="chat-time">${formatDateTime(created_at)}</div>
                                            </div>
                                        </div>`;
                                    } else {
                                        chat = `<div class="chat-item chat-left">
                                            <img src="${receiverImage}" class="avatar-chat" alt="">
                                            <div class="chat-details">
                                                <div class="chat-text">${message}</div>
                                                <div class="chat-time">${formatDateTime(created_at)}</div>
                                            </div>
                                        </div>`;
                                    }

                                    mainChatInbox.append(chat);
                                });

                                // scroll to bottom
                                scrollToBottom();
                            },
                            error: (xhr, status, error) => {
                                console.log(xhr, status, error);
                            },
                            complete: () => {

                            }
                        });
                    });
                }

                const sendChat = () => {
                    $body.on("submit", "#message-form", e => {
                        e.preventDefault();

                        const $this = $(e.currentTarget);
                        const formData = $this.serialize();
                        const messageData = $messageBox.val();

                        let formSubmitting = false;

                        if (formSubmitting || messageData === "") {
                            return;
                        }

                        const {USER} = window;

                        // set message in inbox
                        let message = `<div class="chat-item chat-right" style="">
                            <img style="height: 50px; object-fit: cover;" src="${USER.image}" alt="">
                            <div class="chat-details">
                                <div class="chat-text">${messageData}</div>
                                <div class="chat-time"></div>
                            </div>
                        </div>`;

                        mainChatInbox.append(message);
                        $messageBox.val("");
                        scrollToBottom()

                        $.ajax({
                            method: "POST",
                            url: '{{ route("admin.send-message") }}',
                            data: formData,
                            beforeSend: () => {
                                $('.send-button').prop('disabled', true);
                                formSubmitting = true;
                            },
                            success: () => {
                            },
                            error: (xhr, status, error) => {
                                console.log(xhr, status, error);
                                toastr.error(error);
                                $(".send-button").prop("disabled", false);
                                formSubmitting = false;
                            },
                            complete: () => {
                                $(".send-button").prop("disabled", false);
                                formSubmitting = false;
                            }
                        });
                    });
                }

                viewChat();
                sendChat();
            });
        })(jQuery);
    </script>
@endpush
