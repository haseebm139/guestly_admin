@extends('user.layouts.master')

@section('title', $pageTitle ?? 'Messages')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');
        :root { --primary-green: #014122; --light-green-bg: linear-gradient(180deg, #F0FAF6 0%, #F9FEFC 100%); --message-list-column-bg: #e6f4f0; --active-list-item-bg: #E8F6F0; --recipient-bubble-bg: #D7F5E8; --border-color: #E9E9E9; --text-dark-primary: #014122; --text-dark-secondary: #333333; --text-light: #5E8082; --white: #FFFFFF; --font-primary: 'Poppins', sans-serif; }

        .chat-container {
            display: flex;
            height: calc(100vh - 120px);
            flex-grow: 1;
            overflow: hidden;
            background-color: var(--white);
            font-family: var(--font-primary);
        }
        .message-list-column { width: 380px; min-width: 320px; max-width: 35%; display: flex; flex-direction: column; background-color: var(--message-list-column-bg); padding: 24px; gap: 20px; }
        .message-list-header { flex-shrink: 0; }
        .message-title { font-weight: 700; font-size: 28px; color: var(--text-dark-primary); margin: 0 0 16px 0; }
        .message-tabs { display: flex; border-bottom: 1px solid #D1E0DA; }
        .message-tabs .tab-item { flex-basis: 33.33%; text-align: center; padding-bottom: 14px; text-decoration: none; font-weight: 600; font-size: 16px; color: var(--text-light); border-bottom: 3px solid transparent; position: relative; top: 1px; transition: all 0.2s ease; }
        .message-tabs .tab-item.active { color: var(--primary-green); border-bottom-color: var(--primary-green); }
        .conversation-list-container { background-color: var(--white); border-radius: 20px; flex-grow: 1; overflow: hidden; display: flex; flex-direction: column; }
        .conversation-list { flex-grow: 1; overflow-y: auto; padding: 8px 0; }
        .conversation-item { display: flex; align-items: center; padding: 16px 14px; cursor: pointer; gap: 16px; border-bottom: 1px solid #e2e6ed; }
        .conversation-item:last-child { border-bottom: none; }
        .conversation-item:hover { background-color: #F9F9F9; }
        .conversation-item.active { background-color: var(--active-list-item-bg); }
        .conversation-item .avatar { width: 50px; height: 50px; border-radius: 50%; object-fit: cover; flex-shrink: 0; }
        .conversation-details { overflow: hidden; width: 100%; }
        .conversation-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px; }
        .conversation-header strong { font-weight: 700; font-size: 16px; color: var(--primary-green); }
        .conversation-header span { font-size: 12px; color: var(--text-light); }
        .conversation-details p { margin: 0; font-size: 14px; color: var(--text-light); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

        .chat-window-column {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: #e6f4f0;
            height: 100%;
            overflow: hidden;
        }
        .chat-header { padding: 16px 30px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e2e6ed; background-color: #e6f4f0; flex-shrink: 0; margin-top: 40px; }
        .contact-info { display: flex; align-items: center; gap: 15px; font-weight: 600; font-size: 18px; color: var(--text-dark-primary); }
        .contact-info .avatar { width: 45px; height: 45px; border-radius: 50%; }
        .delete-chat-btn { display: flex; align-items: center; gap: 10px; padding: 17px 35px; border: 1px solid var(--border-color); background-color: #FAFAFA; color: var(--text-dark-secondary); border-radius: 40px; cursor: pointer; font-size: 18px; font-weight: 500; }

        .chat-messages {
            flex-grow: 1;
            padding: 30px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 20px;
            background-color: #e6f4f0;
            min-height: 0;
        }


        .chat-messages::-webkit-scrollbar {
            width: 8px;
        }
        .chat-messages::-webkit-scrollbar-track {
            background: #e6f4f0;
        }
        .chat-messages::-webkit-scrollbar-thumb {
            background-color: var(--primary-green);
            border-radius: 20px;
            border: 2px solid #e6f4f0;
        }
        .chat-messages::-webkit-scrollbar-thumb:hover {
            background-color: #025c31;
        }
        .chat-messages {
            scrollbar-width: thin;
            scrollbar-color: var(--primary-green) #e6f4f0;
        }

        .message-wrapper { display: flex; gap: 12px; max-width: 65%; }
        .message-wrapper .avatar { width: 40px; height: 40px; border-radius: 50%; align-self: flex-end; }
        .message-content { display: flex; flex-direction: column; }
        .message-bubble { padding: 14px 20px; border-radius: 20px; line-height: 1.5; font-size: 15px; }
        .timestamp { font-size: 12px; color: var(--text-light); margin-top: 8px; }
        .message-wrapper.sender { align-self: flex-start; }
        .message-wrapper.sender .message-bubble { background-color: #e6f4f0; border: 1px solid #5e8082; border-bottom-left-radius: 5px; }
        .message-wrapper.sender .message-content { align-items: flex-start; }
        .message-wrapper.recipient { align-self: flex-end; }
        .message-wrapper.recipient .message-bubble { background-color: var(--recipient-bubble-bg); border-bottom-right-radius: 5px; color: var(--primary-green); font-weight: 500; border: 1px solid #5e8082; }
        .message-wrapper.recipient .message-content { align-items: flex-end; }
        .message-wrapper.recipient .timestamp { text-align: right; }
        .chat-input-container { padding: 15px 30px; flex-shrink: 0; background: #e6f4f0; }
        .chat-input-area { background-color: #e6f4f0; border: 1px solid #797171; display: flex; align-items: center; gap: 15px; border-radius: 100px; padding: 8px 8px 8px 20px; }
        .chat-input-area .input-icon { color: var(--text-light); cursor: pointer; }
        .chat-input-area input { flex-grow: 1; border: none; background: transparent; font-size: 16px; outline: none; color: var(--text-dark-secondary); font-family: var(--font-primary); }
        .chat-input-area .send-btn { background: var(--primary-green); color: var(--white); border: none; width: 42px; height: 42px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; flex-shrink: 0; transition: background-color 0.2s; }
        .chat-input-area .send-btn:hover { background: #025c31; }
        .no-chat-message { display: flex; align-items: center; justify-content: center; height: 100%; width: 100%; color: var(--text-light); font-size: 18px; text-align: center; padding: 20px;}
    </style>
    {{--    <div style="background: #fff3cd; border: 1px solid #ffeeba; padding: 15px; margin: 20px; border-radius: 5px;">--}}
    {{--        <h3>Testing Area</h3>--}}
    {{--        <p>Click this button to create a test chat between Artist ID 33 and Studio ID 101. (Make sure these users exist in your local database and Firebase Auth).</p>--}}

    {{--        --}}{{-- PURANI LINE KI JAGAH YEH NAYI LINE LIKHEIN --}}
    {{--        <a href="{{ route('dashboard.test.chat.create', ['artistId' => 33, 'studioId' => 34]) }}"--}}
    {{--           style="background: #007bff; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px;">--}}
    {{--            Create Test Chat (Artist 33 & Studio 101)--}}
    {{--        </a>--}}
    {{--    </div>--}}
    <div class="chat-container">
        @if($firebaseToken && $currentFirebaseUid)
            <div class="message-list-column">
                <div class="message-list-header">
                    <div class="message-tabs">
                        <a href="#" class="tab-item active" data-filter="all">All</a>

                        @if(strtolower(auth()->user()->role_id) === 'artist')
                            <a href="#" class="tab-item" data-filter="client">Clients</a>
                            <a href="#" class="tab-item" data-filter="studio">Studios</a>
                        @else
                            <a href="#" class="tab-item" data-filter="artist">Artists</a>
                        @endif

                    </div>
                </div>
                <div class="conversation-list-container">
                    <div class="conversation-list">
                    </div>
                </div>
            </div>
            <div class="chat-window-column">
                <div id="chat-header" class="chat-header" style="display: none;">
                    <div class="contact-info"></div>
                    <button class="delete-chat-btn">Delete Chat</button>
                </div>
                <div id="chat-messages" class="chat-messages">
                    <div class="no-chat-message">Select a conversation to start chatting.</div>
                </div>
                <div id="chat-input-container" class="chat-input-container" style="display: none;">
                    <div class="chat-input-area">
                        <input type="text" id="message-input" placeholder="Type your message" disabled>
                        <button type="button" id="send-button" class="send-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-send-fill" viewBox="0 0 16 16"><path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083l4.97-14.244z" /></svg>
                        </button>
                    </div>
                </div>
            </div>
        @else
            <div class="no-chat-message">
                <div>
                    <h2>Chat Not Available</h2>
                    <p>Once you book a studio, your chats will appear here.</p>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    @if($firebaseToken && $currentFirebaseUid)
        <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
        <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-auth.js"></script>
        <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-database.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const firebaseConfig = {
                    apiKey: "AIzaSyDVM3otRXbuWFPvpfmIPMVoTuTUtLYK2zs",
                    authDomain: "guestly-8aa9a.firebaseapp.com",
                    databaseURL: "https://guestly-8aa9a-default-rtdb.firebaseio.com",
                    projectId: "guestly-8aa9a",
                    storageBucket: "guestly-8aa9a.appspot.com",
                    messagingSenderId: "548981851052",
                    appId: "1:548981851052:web:fd64445a7cac155889b009')"
                };

                firebase.initializeApp(firebaseConfig);
                const db = firebase.database();
                const auth = firebase.auth();
                const firebaseToken = '{{ $firebaseToken }}';
                const currentFirebaseUid = '{{ $currentFirebaseUid }}';
                const laravelUser = @json($currentUser);

                let activeRoomId = null;
                let messagesListener = null;
                let allConversations = [];
                let activeFilter = 'all';
                let pendingMessages = [];

                auth.signInWithCustomToken(firebaseToken).then(() => {
                    console.log('%cSUCCESS: Firebase Auth OK. Starting chat app...', 'color: green; font-weight: bold;');
                    runChatApp();
                }).catch((e) => {
                    console.error('%cERROR: Firebase Auth Failed!', 'color: red; font-weight: bold;', e.message);
                    document.querySelector('.chat-container').innerHTML = `<div class="no-chat-message" style="width:100%;"><h2>Chat Authentication Failed</h2><p>Could not log in to the chat service. The token from the server is invalid. Please check the console for details.</p></div>`;
                });

                function runChatApp() {
                    const conversationListDiv = document.querySelector('.conversation-list');
                    if (!conversationListDiv) return;

                    const messageTabs = document.querySelector('.message-tabs');
                    const chatMessagesDiv = document.getElementById('chat-messages');
                    const chatHeader = document.getElementById('chat-header');
                    const chatInputContainer = document.getElementById('chat-input-container');
                    const contactInfoDiv = chatHeader.querySelector('.contact-info');
                    const messageInput = document.getElementById('message-input');
                    const sendButton = document.getElementById('send-button');

                    function renderConversations() {
                        conversationListDiv.innerHTML = '';
                        const filteredConversations = allConversations.filter(convo => {
                            if (activeFilter === 'all') return true;
                            return convo.peerUserType === activeFilter;
                        });

                        if (filteredConversations.length === 0) {
                            conversationListDiv.innerHTML = `<p style="padding: 20px; text-align: center;">No conversations in this category.</p>`;
                            return;
                        }

                        filteredConversations.forEach(convo => {
                            const item = document.createElement('div');
                            item.className = 'conversation-item';
                            item.dataset.roomId = convo.roomId; item.dataset.peerName = convo.peerName; item.dataset.peerAvatar = convo.peerAvatar; item.dataset.peerUserType = convo.peerUserType;
                            const time = new Date(convo.lastTimestamp).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                            const peerInitial = convo.peerName ? convo.peerName.charAt(0).toUpperCase() : 'G';
                            item.innerHTML = `<img src="${convo.peerAvatar || `https://ui-avatars.com/api/?name=${peerInitial}&background=d7f5e8&color=014122`}" alt="${convo.peerName}" class="avatar"><div class="conversation-details"><div class="conversation-header"><strong>${convo.peerName}</strong><span>${time}</span></div><p>${convo.lastMessage}</p></div>`;
                            conversationListDiv.appendChild(item);
                        });
                    }

                    function loadConversationsFromFirebase() {
                        const conversationsRef = db.ref(`conversations/${currentFirebaseUid}`).orderByChild('lastTimestamp');
                        conversationsRef.on('value', (snapshot) => {
                            allConversations = [];
                            if (snapshot.exists()) {
                                snapshot.forEach(child => { allConversations.push({ key: child.key, ...child.val() }); });
                                allConversations.reverse();
                            }
                            renderConversations();
                        });
                    }

                    function loadMessagesForRoom(roomId) {
                        if (messagesListener && activeRoomId) { db.ref(getMessagePath(activeRoomId)).off('child_added', messagesListener); }
                        activeRoomId = roomId; const messagesPath = getMessagePath(roomId); const messagesRef = db.ref(messagesPath).orderByChild('timestamp');
                        chatMessagesDiv.innerHTML = '';

                        messagesListener = messagesRef.on('child_added', (snapshot) => {
                            const message = snapshot.val();

                            const pendingIndex = pendingMessages.findIndex(p => p.text === message.text && (Date.now() - new Date(message.timestamp).getTime()) < 5000);
                            if (message.senderId === currentFirebaseUid && pendingIndex !== -1) {
                                const tempId = pendingMessages[pendingIndex].id;
                                const optimisticDiv = document.querySelector(`[data-temp-id="${tempId}"]`);
                                if (optimisticDiv) {
                                    optimisticDiv.remove();
                                    pendingMessages.splice(pendingIndex, 1);
                                }
                            }

                            chatMessagesDiv.innerHTML += createMessageHTML(message, message.senderId === currentFirebaseUid);
                            chatMessagesDiv.scrollTop = chatMessagesDiv.scrollHeight;
                        });
                    }

                    function createMessageHTML(message, isSender) {
                        const wrapperClass = isSender ? 'recipient' : 'sender';
                        const time = new Date(message.timestamp).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                        const activeConvoItem = document.querySelector(`.conversation-item[data-room-id="${activeRoomId}"]`);
                        const peerName = activeConvoItem ? activeConvoItem.dataset.peerName : '?';
                        const peerInitial = peerName.charAt(0).toUpperCase();
                        const myName = laravelUser.name || 'Me';
                        const myInitial = myName.charAt(0).toUpperCase();
                        const peerAvatar = activeConvoItem ? (activeConvoItem.dataset.peerAvatar || `https://ui-avatars.com/api/?name=${peerInitial}&background=e6f4f0&color=5e8082`) : `https://ui-avatars.com/api/?name=${peerInitial}&background=e6f4f0&color=5e8082`;
                        const myAvatar = laravelUser.avatar || `https://ui-avatars.com/api/?name=${myInitial}&background=d7f5e8&color=014122`;
                        return `<div class="message-wrapper ${wrapperClass}">${!isSender ? `<img src="${peerAvatar}" alt="" class="avatar">` : ''}<div class="message-content"><div class="message-bubble">${message.text}</div><span class="timestamp">${time}</span></div>${isSender ? `<img src="${myAvatar}" alt="You" class="avatar">` : ''}</div>`;
                    }

                    function sendMessage() {
                        const text = messageInput.value.trim();
                        if (text === '' || !activeRoomId) return;

                        sendButton.disabled = true;
                        messageInput.disabled = true;

                        const originalMessageText = messageInput.value;
                        const tempId = Date.now() + '_' + Math.random();
                        pendingMessages.push({ id: tempId, text: originalMessageText });

                        const optimisticMessage = { senderId: currentFirebaseUid, text: originalMessageText, timestamp: Date.now() };
                        const optimisticHTML = createMessageHTML(optimisticMessage, true);
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = optimisticHTML;
                        if (tempDiv.firstChild) {
                            tempDiv.firstChild.setAttribute('data-temp-id', tempId);
                            chatMessagesDiv.appendChild(tempDiv.firstChild);
                        }

                        chatMessagesDiv.scrollTop = chatMessagesDiv.scrollHeight;
                        messageInput.value = '';

                        const activeConvo = document.querySelector(`.conversation-item[data-room-id="${activeRoomId}"]`);
                        const ids = activeRoomId.replace('studio_', '').replace('artist_', '').split('__');
                        const payload = {
                            text: originalMessageText, artistId: ids[1], studioId: ids[0], meUid: currentFirebaseUid,
                            myBusinessId: laravelUser.id.toString(), myUserType: laravelUser.role_id, myName: laravelUser.name,
                            myAvatar: laravelUser.avatar || `https://ui-avatars.com/api/?name=${(laravelUser.name || 'M').charAt(0).toUpperCase()}&background=d7f5e8&color=014122`,
                            peerUserType: activeConvo.dataset.peerUserType, peerName: activeConvo.dataset.peerName, peerAvatar: activeConvo.dataset.peerAvatar, peerBusinessId: 'peer_business_id_here'
                        };

                        fetch("{{ route('chat.send') }}", { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify(payload) })
                            .catch(e => {
                                console.error('Send error:', e);
                                messageInput.value = originalMessageText;
                            })
                            .finally(() => {
                                sendButton.disabled = false;
                                messageInput.disabled = false;
                                messageInput.focus();
                            });
                    }

                    function getMessagePath(roomId) { const ids = roomId.replace('studio_', '').replace('artist_', '').split('__'); return `pair-room-messages/${ids[1]}/${ids[0]}`; }

                    messageTabs.addEventListener('click', (e) => {
                        e.preventDefault();
                        const clickedTab = e.target.closest('.tab-item');
                        if (!clickedTab || clickedTab.classList.contains('active')) return;
                        activeFilter = clickedTab.dataset.filter;
                        messageTabs.querySelector('.active').classList.remove('active');
                        clickedTab.classList.add('active');
                        renderConversations();
                    });

                    conversationListDiv.addEventListener('click', (e) => {
                        const item = e.target.closest('.conversation-item'); if (!item) return;
                        document.querySelectorAll('.conversation-item').forEach(i => i.classList.remove('active')); item.classList.add('active');
                        chatHeader.style.display = 'flex'; chatInputContainer.style.display = 'block'; messageInput.disabled = false;
                        contactInfoDiv.innerHTML = `<img src="${item.dataset.peerAvatar || 'https://ui-avatars.com/api/?name=P&background=e6f4f0&color=5e8082'}" alt="${item.dataset.peerName}" class="avatar"><span>${item.dataset.peerName}</span>`;
                        loadMessagesForRoom(item.dataset.roomId);
                    });

                    sendButton.addEventListener('click', sendMessage);

                    messageInput.addEventListener('keypress', (e) => {
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            sendMessage();
                        }
                    });

                    loadConversationsFromFirebase();
                }
            });
        </script>
    @endif
@endsection
