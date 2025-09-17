@extends('user.layouts.master')

@section('title', 'Message')

@section('content')
    <style>
        /* Google Font import - for a closer look to the UI */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

        /* --- VARIABLES FROM IMAGE --- */
        :root {
            --primary-green: #014122;
            --light-green-bg: linear-gradient(180deg, #F0FAF6 0%, #F9FEFC 100%);
            --message-list-column-bg: #e6f4f0;
            --active-list-item-bg: #E8F6F0;
            --recipient-bubble-bg: #D7F5E8;
            --border-color: #E9E9E9;
            --text-dark-primary: #014122;
            --text-dark-secondary: #333333;
            --text-light: #5E8082;
            --white: #FFFFFF;
            --font-primary: 'Poppins', sans-serif;
        }

        /* --- MAIN CHAT LAYOUT --- */
        .chat-container {
            display: flex;
            height: 100%;
            /* Takes full height of its parent (e.g., 100vh - header height) */
            flex-grow: 1;
            overflow: hidden;
            background-color: var(--white);
            font-family: var(--font-primary);
        }

        /* --- COLUMN 1: MESSAGE LIST (UPDATED) --- */
        .message-list-column {
            width: 380px;
            min-width: 320px;
            max-width: 35%;
            /*border-right: 1px solid var(--border-color);*/
            display: flex;
            flex-direction: column;
            background-color: var(--message-list-column-bg);
            padding: 24px;
            gap: 20px;
            /* Space between header and list container */
        }

        .message-list-header {
            flex-shrink: 0;
        }

        .message-title {
            font-weight: 700;
            font-size: 28px;
            color: var(--text-dark-primary);
            margin: 0 0 16px 0;
        }

        .message-tabs {
            display: flex;
            border-bottom: 1px solid #D1E0DA;
        }

        .message-tabs .tab-item {
            flex-basis: 33.33%;
            text-align: center;
            padding-bottom: 14px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            color: var(--text-light);
            border-bottom: 3px solid transparent;
            /* Placeholder for active state */
            position: relative;
            top: 1px;
            /* Aligns the tab's border with the main border */
            transition: all 0.2s ease;
        }

        .message-tabs .tab-item.active {
            color: var(--primary-green);
            border-bottom-color: var(--primary-green);
        }

        /* The white container for the chat list */
        .conversation-list-container {
            background-color: var(--white);
            border-radius: 20px;
            flex-grow: 1;
            overflow: hidden;
            /* Clips the content to the rounded corners */
            display: flex;
            flex-direction: column;
        }

        .conversation-list {
            flex-grow: 1;
            overflow-y: auto;
            padding: 8px 0;
        }

        .conversation-item {
            display: flex;
            align-items: center;
            padding: 16px 14px;
            cursor: pointer;
            gap: 16px;
            border-bottom: 1px solid #e2e6ed;
            /* Separator line */
        }

        .conversation-item:last-child {
            border-bottom: none;
        }

        .conversation-item:hover {
            background-color: #F9F9F9;
        }

        .conversation-item.active {
            background-color: var(--active-list-item-bg);
        }

        .conversation-item .avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
        }

        .conversation-details {
            overflow: hidden;
            width: 100%;
        }

        .conversation-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 4px;
        }

        .conversation-header strong {
            font-weight: 700;
            font-size: 16px;
            color: var(--primary-green);
            /* Green name */
        }

        .conversation-header span {
            font-size: 12px;
            color: var(--text-light);
        }

        .conversation-details p {
            margin: 0;
            font-size: 14px;
            color: var(--text-light);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* --- COLUMN 2: CHAT WINDOW --- */
        .chat-window-column {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: #e6f4f0;
        }

        .chat-header {
            padding: 16px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e2e6ed;
            background-color: #e6f4f0;
            flex-shrink: 0;
            margin-top: 40px;
        }

        .contact-info {
            display: flex;
            align-items: center;
            gap: 15px;
            font-weight: 600;
            font-size: 18px;
            color: var(--text-dark-primary);
        }

        .contact-info .avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
        }

        .delete-chat-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 17px 35px;
            border: 1px solid var(--border-color);
            background-color: #FAFAFA;
            color: var(--text-dark-secondary);
            border-radius: 40px;
            cursor: pointer;
            font-size: 18px;
            font-weight: 500;
        }

        /* Chat Messages Area */
        .chat-messages {
            flex-grow: 1;
            padding: 30px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 20px;
            background-color: #e6f4f0;
        }

        .message-wrapper {
            display: flex;
            gap: 12px;
            max-width: 65%;
        }

        .message-wrapper .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            align-self: flex-end;
            /* Binds avatar to the bottom of the message */
        }

        .message-content {
            display: flex;
            flex-direction: column;
        }

        .message-bubble {
            padding: 14px 20px;
            border-radius: 20px;
            line-height: 1.5;
            font-size: 15px;
        }

        .timestamp {
            font-size: 12px;
            color: var(--text-light);
            margin-top: 8px;
        }

        /* Sender (Left side) */
        .message-wrapper.sender {
            align-self: flex-start;
        }

        .message-wrapper.sender .message-bubble {
            background-color: #e6f4f0;
            border: 1px solid #5e8082;
            border-bottom-left-radius: 5px;
        }

        .message-wrapper.sender .message-content {
            align-items: flex-start;
        }

        /* Recipient (Right side) */
        .message-wrapper.recipient {
            align-self: flex-end;
        }

        .message-wrapper.recipient .message-bubble {
            background-color: var(--recipient-bubble-bg);
            border-bottom-right-radius: 5px;
            color: var(--primary-green);
            font-weight: 500;
            border: 1px solid #5e8082;
        }

        .message-wrapper.recipient .message-content {
            align-items: flex-end;
        }

        .message-wrapper.recipient .timestamp {
            text-align: right;
        }


        /* System Messages (Center) */
        .system-message {
            align-self: center;
            padding: 8px 18px;
            border: 1px solid #5E8082;
            background: #E6F4F0;
            border-radius: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #333333;
            font-size: 14px;
            font-weight: 500;
            margin: 10px 0;
        }

        .system-message.with-icon-circle {
            justify-content: space-between;
            width: 350px;
            padding: 8px 8px 8px 18px;
        }

        .system-message .icon-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: var(--text-light);
        }

        /* Typing Indicator */
        .typing-indicator .message-bubble {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 18px;
            color: var(--text-light);
        }

        .typing-dots span {
            display: inline-block;
            width: 6px;
            height: 6px;
            background-color: var(--text-light);
            border-radius: 50%;
            margin: 0 1px;
            animation: typing-bounce 1.2s infinite ease-in-out;
        }

        .typing-dots span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-dots span:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes typing-bounce {

            0%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-5px);
            }
        }

        /* Chat Input Area */
        .chat-input-container {
            padding: 15px 30px;
            flex-shrink: 0;
            background: #e6f4f0;
            /* Match the chat window bg */
        }

        .chat-input-area {
            background-color: #e6f4f0;
            border: 1px solid #797171;
            display: flex;
            align-items: center;
            gap: 15px;
            border-radius: 100px;
            padding: 8px 8px 8px 20px;
        }

        .chat-input-area .input-icon {
            color: var(--text-light);
            cursor: pointer;
        }

        .chat-input-area input {
            flex-grow: 1;
            border: none;
            background: transparent;
            font-size: 16px;
            outline: none;
            color: var(--text-dark-secondary);
            font-family: var(--font-primary);
        }

        .chat-input-area .send-btn {
            background: var(--primary-green);
            color: var(--white);
            border: none;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: background-color 0.2s;
        }

        .chat-input-area .send-btn:hover {
            background: #025c31;
        }
    </style>

    <div class="chat-container">
        {{-- Column 1: Message List (UPDATED DESIGN) --}}
        <div class="message-list-column">
            <div class="message-list-header">
                <h1 class="message-title"></h1>
                <div class="message-tabs">
                    <a href="#" class="tab-item active">All</a>
                    <a href="#" class="tab-item">Clients</a>
                    <a href="#" class="tab-item">Studios</a>
                </div>
            </div>

            <!-- WHITE CONTAINER FOR THE LIST -->
            <div class="conversation-list-container">
                <div class="conversation-list">
                    <div class="conversation-item">
                        <img src="https://i.pravatar.cc/50?u=lucas_1" alt="Lucas Raymond" class="avatar">
                        <div class="conversation-details">
                            <div class="conversation-header"><strong>Lucas Raymond</strong><span>7 mins ago</span></div>
                            <p>Hey Lucas! Just reviewed your reference. Are you still thinking 5 inches on the forearm?</p>
                        </div>
                    </div>
                    <div class="conversation-item">
                        <img src="https://i.pravatar.cc/50?u=electric_tiger" alt="Electric Tiger Tattoo" class="avatar">
                        <div class="conversation-details">
                            <div class="conversation-header"><strong>Electric Tiger Tattoo</strong><span>7 mins ago</span>
                            </div>
                            <p>Hi Ava, your booth is confirmed for Sept 14-17. Let us know if you need additional setup
                                time.</p>
                        </div>
                    </div>
                    <div class="conversation-item">
                        <img src="https://i.pravatar.cc/50?u=priya" alt="Priya Kaur" class="avatar">
                        <div class="conversation-details">
                            <div class="conversation-header"><strong>Priya Kaur</strong><span>7 mins ago</span></div>
                            <p>Hey Priya! I just got to Rebel Needle - feel free to swing by early if you're around.</p>
                        </div>
                    </div>
                    <div class="conversation-item active">
                        <img src="https://i.pravatar.cc/50?u=lucas_2" alt="Lucas Raymond" class="avatar">
                        <div class="conversation-details">
                            <div class="conversation-header"><strong>Lucas Raymond</strong><span>7 mins ago</span></div>
                            <p>your first client is requesting earlier timing. Can we shift you to 10 AM?</p>
                        </div>
                    </div>
                    <div class="conversation-item">
                        <img src="https://i.pravatar.cc/50?u=hannah" alt="Hannah Lee" class="avatar">
                        <div class="conversation-details">
                            <div class="conversation-header"><strong>Hannah Lee</strong><span>7 mins ago</span></div>
                            <p>Hi Hannah! Could you re-upload the quote design? The file didn't open for me.</p>
                        </div>
                    </div>
                    <div class="conversation-item">
                        <img src="https://i.pravatar.cc/50?u=riley" alt="Riley Storm" class="avatar">
                        <div class="conversation-details">
                            <div class="conversation-header"><strong>Riley Storm</strong><span>7 mins ago</span></div>
                            <p>Hey Priya! I just got to Rebel Needle - feel free to swing by early if you're around.</p>
                        </div>
                    </div>
                    <div class="conversation-item">
                        <img src="https://i.pravatar.cc/50?u=electric_tiger_2" alt="Electric Tiger Tattoo" class="avatar">
                        <div class="conversation-details">
                            <div class="conversation-header"><strong>Electric Tiger Tattoo</strong><span>7 mins ago</span>
                            </div>
                            <p>Hi Ava, your booth is confirmed for Sept 14-17. Let us know if you need additional setup
                                time.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Column 2: Main Chat Window --}}
        <div class="chat-window-column">
            <div class="chat-header">
                <div class="contact-info">
                    <img src="https://i.pravatar.cc/50?u=lucas_2" alt="Lucas Raymond" class="avatar">
                    <span>Lucas Raymond</span>
                </div>
                <button class="delete-chat-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-trash3" viewBox="0 0 16 16">
                        <path
                            d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.528ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Zm2.522.47a.5.5 0 0 1 .528.47l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .47-.528Z" />
                    </svg>
                    Delete Chat
                </button>
            </div>

            <div class="chat-messages">
                {{-- Sender's Message --}}
                <div class="message-wrapper sender">
                    <img src="https://i.pravatar.cc/40?u=lucas_2" alt="Lucas Raymond" class="avatar">
                    <div class="message-content">
                        <div class="message-bubble">
                            Hey! I just sent in a booking request for Sept 14th at The Inkwell Studio. Let me know if you're
                            available and if you need anything else from me.
                        </div>
                        <span class="timestamp">7 mins ago</span>
                    </div>
                </div>

                {{-- System Message --}}
                <div class="system-message">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                        class="bi bi-calendar-check" viewBox="0 0 16 16">
                        <path
                            d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                        <path
                            d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                    </svg>
                    <span>Your Accepted Lucas Raymond Request</span>
                </div>

                {{-- Recipient's Message (Current User) --}}
                <div class="message-wrapper recipient">
                    <div class="message-content">
                        <div class="message-bubble">
                            Hey Lucas, thanks for booking! I just saw your request — Sept 14th works perfectly. Can you
                            please confirm the timing
                        </div>
                        <span class="timestamp">5 mins ago</span>
                    </div>
                    <img src="https://i.pravatar.cc/40?u=chris_johnson" alt="Chris Johnson" class="avatar">
                </div>

                {{-- System Message 2 --}}
                <div class="system-message with-icon-circle">
                    <span>Your Ask Lucas Raymond to find a time</span>
                    <div class="icon-circle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            viewBox="0 0 16 16">
                            <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
                        </svg>
                    </div>
                </div>

                {{-- Typing Indicator --}}
                <div class="message-wrapper sender typing-indicator">
                    <img src="https://i.pravatar.cc/40?u=lucas_2" alt="Lucas Raymond" class="avatar">
                    <div class="message-content">
                        <div class="message-bubble">
                            <span>Typing</span>
                            <div class="typing-dots">
                                <span></span><span></span><span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="chat-input-container">
                <div class="chat-input-area">
                    <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                        fill="currentColor" class="bi bi-paperclip" viewBox="0 0 16 16">
                        <path
                            d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0V3z" />
                    </svg>
                    <input type="text" placeholder="Type your message">
                    <button type="submit" class="send-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="bi bi-send-fill" viewBox="0 0 16 16">
                            <path
                                d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083l4.97-14.244z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
