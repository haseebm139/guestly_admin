<div>
    <!--begin::Sidebar-->
    <div class="flex-column flex-lg-row-auto w-100 w-lg-300px w-xl-400px mb-10 mb-lg-0">
        <!--begin::Contacts-->

        <div class="card card-flush">
            <div class="card-header pt-7" id="kt_chat_contacts_header">
                <form class="w-100 position-relative" autocomplete="off">
                    <div class="d-flex align-items-center position-relative my-1">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                            <span class="path1"></span><span class="path2"></span>
                        </i>
                        <input wire:model.live.debounce.300ms="search" type="text"
                            class="form-control form-control-solid px-15"
                            placeholder="Search by username or email..." />
                    </div>
                </form>
            </div>
            <div class="card-body pt-5" id="kt_chat_contacts_body">
                <div class="scroll-y me-n5 pe-5 h-200px h-lg-auto" data-kt-scroll="true"
                    data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                    data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_chat_contacts_header"
                    data-kt-scroll-wrappers="#kt_content, #kt_chat_contacts_body" data-kt-scroll-offset="0px">
                    @foreach ($users as $user)
                        <div wire:click="selectUser({{ $user->id }})"
                            class="d-flex flex-stack py-4 cursor-pointer @if ($selectedUser && $selectedUser->id == $user->id) bg-light-primary rounded @endif">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-45px symbol-circle">
                                    <span
                                        class="symbol-label bg-light-info text-info fs-6 fw-bolder">{{ substr($user->name, 0, 1) }}</span>
                                    {{-- You can dynamically set online status here if you track it --}}
                                    <div
                                        class="symbol-badge bg-success start-100 top-100 border-4 h-15px w-15px ms-n2 mt-n2">
                                    </div>
                                </div>
                                <div class="ms-5">
                                    <a href="#"
                                        class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">{{ $user->name }}</a>
                                    <div class="fw-bold text-muted">{{ $user->email }}</div>
                                </div>
                            </div>
                            {{-- You might display unread message count here --}}
                            {{-- <div class="d-flex flex-column align-items-end ms-2">
                            <span class="text-muted fs-7 mb-1">3 hrs</span>
                            <span class="badge badge-sm badge-circle badge-light-success">6</span>
                        </div> --}}
                        </div>
                        <div class="separator separator-dashed d-none"></div>
                    @endforeach

                    @if ($users->isEmpty())
                        <p class="text-muted text-center py-5">No users found.</p>
                    @endif
                </div>
            </div>

        </div>
        <!--end::Contacts-->
    </div>
    <!--end::Sidebar-->
</div>
