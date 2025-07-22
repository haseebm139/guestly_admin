{{-- Chat Message Component --}}
<div>
    <div class="card" id="kt_chat_messenger">
        <div class="card-header" id="kt_chat_messenger_header">
            <div class="card-title">
                @if ($selectedUser)
                    <div class="d-flex justify-content-center flex-column me-3">
                        <a href="#" class="fs-4 fw-bolder text-gray-900 text-hover-primary me-1 mb-2 lh-1">
                            {{ $selectedUser->name }}
                        </a>
                        <div class="mb-0 lh-1">
                            <span class="badge badge-success badge-circle w-10px h-10px me-1"></span>
                            <span class="fs-7 fw-bold text-muted">Active</span>
                        </div>
                    </div>
                @else
                    <div class="d-flex justify-content-center flex-column me-3">
                        <span class="fs-4 fw-bolder text-gray-900">Select a user to chat</span>
                    </div>
                @endif
            </div>
        </div>
        <div class="card-body" id="kt_chat_messenger_body">
            <div class="scroll-y me-n5 pe-5 h-300px h-lg-auto" data-kt-element="messages" data-kt-scroll="true"
                data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_chat_messenger_header, #kt_chat_messenger_footer"
                data-kt-scroll-wrappers="#kt_content, #kt_chat_messenger_body" data-kt-scroll-offset="-2px">

                @foreach ($messages as $msg)
                    @if ($msg['sender_id'] == Auth::id())
                        {{-- Outgoing message --}}
                        <div class="d-flex justify-content-end mb-10">
                            <div class="d-flex flex-column align-items-end">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="me-3">
                                        <span
                                            class="text-muted fs-7 mb-1">{{ \Carbon\Carbon::createFromTimestamp($msg['timestamp'])->diffForHumans() }}</span>
                                        <a href="#"
                                            class="fs-5 fw-bolder text-gray-900 text-hover-primary ms-1">You</a>
                                    </div>
                                    <div class="symbol symbol-35px symbol-circle">
                                        <img alt="Pic" src="assets/media/avatars/150-26.jpg" />
                                    </div>
                                </div>
                                <div class="p-5 rounded bg-light-primary text-dark fw-bold mw-lg-400px text-end"
                                    data-kt-element="message-text">
                                    {{ $msg['message_text'] }}
                                </div>
                            </div>
                        </div>
                    @else
                        {{-- Incoming message --}}
                        <div class="d-flex justify-content-start mb-10">
                            <div class="d-flex flex-column align-items-start">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="symbol symbol-35px symbol-circle">
                                        <img alt="Pic" src="assets/media/avatars/150-15.jpg" />
                                    </div>
                                    <div class="ms-3">
                                        <a href="#"
                                            class="fs-5 fw-bolder text-gray-900 text-hover-primary me-1">{{ $selectedUser->name ?? 'User' }}</a>
                                        <span
                                            class="text-muted fs-7 mb-1">{{ \Carbon\Carbon::createFromTimestamp($msg['timestamp'])->diffForHumans() }}</span>
                                    </div>
                                </div>
                                <div class="p-5 rounded bg-light-info text-dark fw-bold mw-lg-400px text-start"
                                    data-kt-element="message-text">
                                    {{ $msg['message_text'] }}
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        @if ($selectedUser)
            <div class="card-footer pt-4" id="kt_chat_messenger_footer">
                <textarea wire:model.live="message" wire:keydown.enter.prevent="sendMessage"
                    class="form-control form-control-flush mb-3" rows="1" placeholder="Type a message"></textarea>
                <div class="d-flex flex-stack">
                    <div class="d-flex align-items-center me-2">
                        {{-- Add any file upload/emoji buttons here if needed --}}
                    </div>
                    <button wire:click="sendMessage" class="btn btn-primary" type="button"
                        data-kt-element="send-button">Send</button>
                </div>
            </div>
        @endif
    </div>
</div>
