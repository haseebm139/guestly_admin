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
                serverTimestamp,
                getDoc



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

            let unsubscribe; // Stores the unsubscribe function for the Firestore listener

            function scrollToBottom() {
                const messagesContainer = document.querySelector('[data-kt-element="messages"]');
                if (messagesContainer) {
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                }
            }

            Livewire.on('chatOpened', (selectedUserId, currentUserId) => {
                if (unsubscribe) {
                    unsubscribe(); // Unsubscribe from previous chat listener if exists
                    console.log('Previous Firebase listener unsubscribed.');
                }

                const chatId = [currentUserId, selectedUserId].sort().join('_');
                console.log('Calculated chat ID:', chatId);

                const messagesRef = collection(db, 'chats', chatId, 'messages');
                const q = query(messagesRef, orderBy('timestamp'));

                // Set up new listener for the selected chat
                unsubscribe = onSnapshot(q, {
                    includeMetadataChanges: true // Get immediate local updates and server confirmations
                }, (snapshot) => {
                    console.log('Firebase onSnapshot callback triggered. Doc changes count:', snapshot
                        .docChanges().length);

                    const changes = [];
                    snapshot.docChanges().forEach((change) => {
                        const messageData = change.doc.data();
                        messageData.id = change.doc.id; // Get the real Firebase document ID

                        // Convert Firebase Timestamp to Unix timestamp (seconds) for PHP
                        messageData.timestamp = messageData.timestamp ? messageData.timestamp
                            .toMillis() / 1000 : null;

                        changes.push({
                            type: change.type, // 'added', 'modified', 'removed'
                            message: messageData
                        });
                    });

                    // Emit all changes to the Livewire component for reconciliation
                    Livewire.emit('applyMessageChanges', changes);

                }, (error) => {
                    console.error("Firebase onSnapshot error:", error);
                });
            });

            // Handles sending messages to Firebase
            Livewire.on('sendMessageToFirebase', async (senderId, receiverId, messageText, tempId) => {

                const chatId = [senderId, receiverId].sort().join('_');

                try {
                    const messagePayload = {
                        sender_id: senderId,
                        receiver_id: receiverId,
                        message_text: messageText,
                        timestamp: serverTimestamp()
                    };

                    const docRef = await addDoc(collection(db, 'chats', chatId, 'messages'), messagePayload);

                    console.log("Document written with ID: ", docRef.id);

                    const docSnapshot = await getDoc(docRef); // This line now has `getDoc` defined

                    if (docSnapshot.exists()) {
                        const realTimestamp = docSnapshot.data().timestamp ? docSnapshot.data().timestamp
                        .toMillis() / 1000 : null;

                        Livewire.emit('messageSentConfirmation',
                            tempId,
                            docRef.id,
                            realTimestamp
                        );
                    } else {
                        console.warn("Document does not exist after writing. Cannot confirm timestamp.");
                        Livewire.emit('messageSentConfirmation', tempId, docRef.id, Date.now() / 1000);
                    }

                } catch (e) {
                    console.error("Error adding document to Firebase: ", e);
                }
            });

            // Livewire listener to trigger scrolling the chat to the bottom
            Livewire.on('scrollToBottomJs', () => {
                scrollToBottom();
            });
        </script>
    @endpush
</x-default-layout>
