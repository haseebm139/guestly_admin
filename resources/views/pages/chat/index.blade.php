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

        <script type="module">

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

            const firebaseConfig = {
                apiKey: "AIzaSyD534VPIDGenGI2H6N8Ozse0tLjn-V1SYM", // Replace with your Firebase API Key
                authDomain: "guestly-d0d42.firebaseapp.com",
                projectId: "guestly-d0d42",
                storageBucket: "guestly-d0d42.firebasestorage.app",
                messagingSenderId: "901273968733",
                appId: "1:901273968733:web:3d3a7733f4c159d3052db4",
                measurementId: "G-B81B3XET99",
            };




            const app = initializeApp(firebaseConfig);
            const db = getFirestore(app);

            let unsubscribe;


            function scrollToBottom() {
                const messagesContainer = document.querySelector('[data-kt-element="messages"]');

                if (messagesContainer) {
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                }
            }

            Livewire.on('chatOpened', ({
                selectedUserId,
                currentUserId
            }) => {
                if (unsubscribe) {
                    unsubscribe();

                }

                const chatId = [currentUserId, selectedUserId].sort().join('_');


                const messagesRef = collection(db, 'chats', chatId, 'messages');
                const q = query(messagesRef, orderBy('timestamp'));


                unsubscribe = onSnapshot(q, (snapshot) => {


                    let currentMessages = [];
                    snapshot.forEach(doc => { // Iterate over all documents in the snapshot
                        const messageData = doc.data();
                        // Convert Firebase Timestamp to Unix timestamp for PHP
                        messageData.timestamp = messageData.timestamp ? messageData.timestamp
                            .toMillis() / 1000 : null;
                        currentMessages.push(messageData);
                    });




                    scrollToBottom()
                    Livewire.dispatch('setMessages', {
                        messages: currentMessages
                    });

                }, (error) => {
                    console.error("Firebase onSnapshot error:", error);
                });
            });


            Livewire.on('sendMessageToFirebase', async ({
                senderId,
                receiverId,
                messageText,
                timestamp
            }) => {
                const chatId = [senderId, receiverId].sort().join('_');

                try {
                    await addDoc(collection(db, 'chats', chatId, 'messages'), {
                        sender_id: senderId,
                        receiver_id: receiverId,
                        message_text: messageText,
                        timestamp: serverTimestamp()
                    });

                } catch (e) {
                    console.error("Error adding document to Firebase: ", e); // Debugging log
                }
            });

            Livewire.on('scrollToBottom', () => {
                scrollToBottom();
            });


        </script>
    @endpush
    <!--end::Chat-->
</x-default-layout>
{{-- "livewire/livewire": "^2.12", --}}
