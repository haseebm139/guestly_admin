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


            Livewire.listen('chatOpened', (selectedUserId, currentUserId) => { // Arguments received directly
                // Unsubscribe from previous chat listener if any
                if (unsubscribe) {
                    unsubscribe();
                }

                // Construct a unique chat ID for the conversation between two users
                const chatId = [currentUserId, selectedUserId].sort().join('_');

                const messagesRef = collection(db, 'chats', chatId, 'messages');
                const q = query(messagesRef, orderBy('timestamp'));

                unsubscribe = onSnapshot(q, (snapshot) => {
                    snapshot.docChanges().forEach((change) => {
                        if (change.type === 'added') {
                            const messageData = change.doc.data();
                            // Dispatch message to Livewire component
                            // CORRECTED: Livewire.emit() for Livewire v2 (from JS to PHP)
                            Livewire.emit('addMessage', { // Pass object with data
                                sender_id: messageData.sender_id,
                                receiver_id: messageData.receiver_id,
                                message_text: messageData.message_text,
                                timestamp: messageData.timestamp ? messageData.timestamp.toMillis() / 1000 : null // Convert Firebase Timestamp to Unix timestamp
                            });
                        }
                    });
                    scrollToBottom();
                });
            });

            // Listen for 'sendMessageToFirebase' event from Livewire to send messages
            // CORRECTED: Livewire.listen() for Livewire v2
            Livewire.listen('sendMessageToFirebase', async (senderId, receiverId, messageText, timestamp) => { // Arguments received directly
                const chatId = [senderId, receiverId].sort().join('_');

                try {
                    await addDoc(collection(db, 'chats', chatId, 'messages'), {
                        sender_id: senderId,
                        receiver_id: receiverId,
                        message_text: messageText,
                        timestamp: serverTimestamp() // Use serverTimestamp for accurate time
                    });
                } catch (e) {
                    console.error("Error adding document: ", e);
                }
            });

            // CORRECTED: Livewire.listen() for Livewire v2
            Livewire.listen('scrollToBottom', () => {
                scrollToBottom();
            });

            // Initial scroll to bottom when the component is loaded
            document.addEventListener('livewire:load', () => { // CORRECTED: livewire:load for v2
                scrollToBottom();
            });
        </script>
    @endpush
    <!--end::Chat-->
</x-default-layout>
