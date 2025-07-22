{{-- Index --}}
<x-default-layout>

    @section('title')
        Chat
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('creative-management.station-amenities.index') }}
    @endsection





    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Layout-->
            <div class="d-flex flex-column flex-lg-row">
                <livewire:chat.chat-list />
                <!--begin::Content-->
                <div class="flex-lg-row-fluid ms-lg-7 ms-xl-10">
                    {{-- Livewire ChatMessages Component --}}
                    <livewire:chat.chat-messages />

                </div>
                <!--end::Content-->
            </div>
            <!--end::Layout-->


        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
    @push('scripts')
        {{-- Initialize Livewire after Firebase SDK --}}
        <script type="module">
            // Import the functions you need from the SDKs you need
            import {
                initializeApp
            } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
            import {
                getFirestore,
                collection,
                query,
                orderBy,
                onSnapshot,
                addDoc,
                serverTimestamp
            } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-firestore.js";
            // TODO: Add SDKs for Firebase products that you want to use
            // https://firebase.google.com/docs/web/setup#available-libraries

            // Your web app's Firebase configuration
            const firebaseConfig = {
                apiKey: "AIzaSyD534VPIDGenGI2H6N8Ozse0tLjn-V1SYM", // Replace with your Firebase API Key
                authDomain: "guestly-d0d42.firebaseapp.com",
                projectId: "guestly-d0d42",
                storageBucket: "guestly-d0d42.firebasestorage.app",
                messagingSenderId: "901273968733",
                appId: "1:901273968733:web:3d3a7733f4c159d3052db4",
                measurementId: "G-B81B3XET99",
            };



            // Initialize Firebase
            const app = initializeApp(firebaseConfig);
            const db = getFirestore(app);

            let unsubscribe; // To store the unsubscribe function for snapshot listener

            // Function to scroll chat to bottom
            function scrollToBottom() {
                const messagesContainer = document.querySelector('[data-kt-element="messages"]');
                if (messagesContainer) {
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                }
            }

            Livewire.on('chatOpened', ({ selectedUserId, currentUserId }) => {
                console.log();

                if (unsubscribe) {
                    unsubscribe();
                    console.log('Previous Firebase listener unsubscribed.'); // Debugging log
                }

                const chatId = [currentUserId, selectedUserId].sort().join('_');
                console.log('Calculated chat ID:', chatId); // Debugging log

                const messagesRef = collection(db, 'chats', chatId, 'messages');
                const q = query(messagesRef, orderBy('timestamp'));

                unsubscribe = onSnapshot(q, (snapshot) => {
                    console.log('Firebase onSnapshot callback triggered. Doc changes count:', snapshot.docChanges().length); // Debugging log

                    // Array to hold messages from the current snapshot
                    let currentMessages = [];

                    snapshot.docChanges().forEach((change) => {
                        const messageData = change.doc.data();
                        messageData.timestamp = messageData.timestamp ? messageData.timestamp.toMillis() / 1000 : null;

                        if (change.type === 'added') {
                            // On initial load, all existing documents are 'added'
                            // For subsequent updates, only truly new messages are 'added'
                            currentMessages.push(messageData);
                            console.log('Message ADDED from Firebase:', messageData); // Debugging log
                        }
                        // You might also handle 'modified' or 'removed' if your chat requires it
                        // else if (change.type === 'modified') {
                        //     // Find and update the message in your local list
                        // } else if (change.type === 'removed') {
                        //     // Remove the message from your local list
                        // }
                    });

                    // Livewire 3: Use Livewire.dispatch() to emit events from JS to Livewire PHP component
                    // Dispatch all messages from the current snapshot (initial load + new additions)
                    Livewire.dispatch('setMessages', { messages: currentMessages }); // Dispatch an array of messages
                    scrollToBottom();
                }, (error) => {
                    console.error("Firebase onSnapshot error:", error); // Log Firebase errors
                });
            });

            Livewire.on('sendMessageToFirebase', async ({ senderId, receiverId, messageText, timestamp }) => {
                const chatId = [senderId, receiverId].sort().join('_');
                console.log('Sending message to Firebase for chat ID:', chatId); // Debugging log
                try {
                    await addDoc(collection(db, 'chats', chatId, 'messages'), {
                        sender_id: senderId,
                        receiver_id: receiverId,
                        message_text: messageText,
                        timestamp: serverTimestamp()
                    });
                    console.log('Message successfully sent to Firebase.'); // Debugging log
                } catch (e) {
                    console.error("Error adding document to Firebase: ", e); // Debugging log
                }
            });

            Livewire.on('scrollToBottom', () => {
                scrollToBottom();
            });

            document.addEventListener('livewire:initialized', () => {
                scrollToBottom();
            });
        </script>
    @endpush
    <!--end::Chat-->
</x-default-layout>
{{-- "livewire/livewire": "^2.12", --}}
