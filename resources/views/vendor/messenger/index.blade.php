@extends( 'vendor.layouts.master' )

@section( 'title' )
    {{ $settings->site_name }} || Messages
@endsection

@section( 'content' )
    <section id="wsus__dashboard">
        <div class="container-fluid">
            @include( 'vendor.layouts.sidebar' )
            <div class="row">
                <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
                    <div class="dashboard_content mt-2 mt-md-0">
                        <h3><i class="fas fa-comments-alt" aria-hidden="true"></i> Messages</h3>
                        <div class="wsus__dashboard_review">
                            <div class="row">
                                <div class="col-xl-4 col-md-5">
                                    <div class="wsus__chatlist d-flex align-items-start">
                                        <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist"
                                             aria-orientation="vertical">
                                            <h2>Chat List</h2>
                                            <div class="wsus__chatlist_body">
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
                                                    <button class="nav-link chat-user-profile"
                                                            data-id="{{ $chatUser->senderProfile->id }}"
                                                            data-bs-toggle="pill"
                                                            data-bs-target="#v-pills-home" type="button" role="tab"
                                                            aria-controls="v-pills-home" aria-selected="true">
                                                        <div
                                                            class="wsus_chat_list_img">
                                                            <img src="{{ asset($chatUser->senderProfile->image) }}"
                                                                 alt="user" class="img-fluid">
                                                            <span class="pending {{ $countUnseenMsg > 0
                                                                ? '' : 'd-none' }}" id="pending-6">{{
                                                                $countUnseenMsg }}</span>
                                                        </div>
                                                        <div class="wsus_chat_list_text">
                                                            <h4>{{ $chatUser->senderProfile->name }}</h4>
                                                            <span class="status {{
                                                                    $online !== 'Offline' ? 'active' : ''
                                                                }}">{{ $online }}</span>
                                                        </div>
                                                    </button>
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-8 col-md-7">
                                    <div class="wsus__chat_main_area" style="position: relative;">
                                        <div class="tab-content" id="v-pills-tabContent">
                                            <div class="tab-pane fade show" id="v-pills-home"
                                                 role="tabpanel" aria-labelledby="v-pills-home-tab">
                                                <div class="wsus__chat_area" id="chat_box">

                                                    <div class="wsus__chat_area_header">
                                                        <h2 id="chat-inbox-title"></h2>
                                                    </div>

                                                    <div class="wsus__chat_area_body" data-inbox=""></div>

                                                    <div class="wsus__chat_area_footer"
                                                         style="position: absolute; bottom: 0; width: 100%;">
                                                        <form id="message-form">
                                                            @csrf
                                                            <input type="text" placeholder="Type Message"
                                                                   class="message-box" autocomplete="off"
                                                                   name="message" aria-label="message">
                                                            <input type="hidden" name="receiver_id"
                                                                   id="receiver_id">
                                                            <button type="submit">
                                                                <i class="fas fa-paper-plane send-button"
                                                                   aria-hidden="true"></i></button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push( 'scripts' )
    <script>
        ($ => {
            $(() => {
                const $body = $("body");
                const $mainChatInbox = $(".wsus__chat_area_body");
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
                    $mainChatInbox.scrollTop($mainChatInbox.prop("scrollHeight"));
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

                                $this.find(".status").text(state);

                                if (state !== "Offline") {
                                    $this.find(".status").addClass("active");
                                } else {
                                    $this.find(".status").removeClass("active");
                                }
                            });
                        },
                        error: (xhr, status, error) => {
                            console.error(`Error: ${status}`);
                            console.error(xhr.responseText);
                            console.error(error);
                        }
                    });
                }

                getOnlineStatus();
                setInterval(getOnlineStatus, 33000);

                const viewChat = () => {
                    $body.on("click", ".chat-user-profile", e => {
                        const $this = $(e.currentTarget);

                        const receiverId = $this.data("id");
                        const senderImage = $this.find("img").attr("src");
                        const chatUserName = $this.find("h4").text();

                        $mainChatInbox.attr("data-inbox", receiverId);

                        $("#receiver_id").val(receiverId);
                        $this.find(".pending").addClass("d-none");

                        $.ajax({
                            method: 'GET',
                            url: '{{ route("vendor.get-messages") }}',
                            data: {
                                receiver_id: receiverId
                            },
                            beforeSend: () => {
                                $mainChatInbox.html("");
                                $("#chat-inbox-title").text(`Chat With ${chatUserName}`)
                            },
                            success: response => {
                                $.each(response, (index, value) => {
                                    const {USER} = window;
                                    const {sender_id, message, created_at} = value;

                                    let chat;

                                    if (sender_id.toString() === USER.id.toString()) {
                                        chat = `<div class="wsus__chat_single single_chat_2">
                                                <div class="wsus__chat_single_img">
                                                    <img src="${USER.image}"
                                                        alt="user" class="img-fluid">
                                                </div>
                                                <div class="wsus__chat_single_text">
                                                    <p>${message}</p>
                                                    <span>${formatDateTime(created_at)}</span>
                                                </div>
                                            </div>`;
                                    } else {
                                        chat = `<div class="wsus__chat_single">
                                                <div class="wsus__chat_single_img">
                                                    <img src="${senderImage}"
                                                        alt="user" class="img-fluid">
                                                </div>
                                                <div class="wsus__chat_single_text">
                                                    <p>${message}</p>
                                                    <span>${formatDateTime(created_at)}</span>
                                                </div>
                                            </div>`;
                                    }

                                    $mainChatInbox.append(chat);
                                });

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

                        const message = `<div class="wsus__chat_single single_chat_2">
                                <div class="wsus__chat_single_img mb-2">
                                    <img src="${USER.image}"
                                        alt="user" class="img-fluid">
                                </div>
                                <div class="wsus__chat_single_text">
                                    <p>${messageData}</p>
                                </div>
                            </div>`;

                        $mainChatInbox.append(message);
                        $messageBox.val("");
                        scrollToBottom();

                        $.ajax({
                            method: "POST",
                            url: '{{ route("vendor.send-message") }}',
                            data: formData,
                            beforeSend: () => {
                                $(".send-button").prop("disabled", true);
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
