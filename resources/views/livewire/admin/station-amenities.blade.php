<div>
    <div class="card-header border-0 pt-6">
        <!--begin::Card title-->
        <div class="card-title">
            <!--begin::Search-->
            <div class="d-flex align-items-center position-relative my-1">
                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                    <span class="path1"></span><span class="path2"></span>
                </i>
                <input wire:model.debounce.500ms="search" type="text" id="userSearchInput"
                    class="form-control form-control-solid w-250px ps-13" placeholder="Search Station Amenities…" />
            </div>
            <!--end::Search-->
        </div>
        <!--end::Card title-->
        <!--begin::Separator-->
        <div class="separator border-gray-200"></div>
        <!--end::Separator-->
        <div class="px-7 py-5" data-kt-user-table-filter="form">

            <!--begin::Add user-->
            <button type="button" class="btn btn-hover-danger btn-icon" wire:click="openCreate">

                <span class="menu-icon">{!! getIcon('add-item', 'fs-2tx') !!}</span>

            </button>

            <!--end::Add user-->
        </div>
        <!--begin::Group actions-->
        <div class="d-flex justify-content-end align-items-center d-none" data-kt-user-table-toolbar="selected">
            <div class="fw-bold me-5">
                <span class="me-2" data-kt-user-table-select="selected_count"></span> Selected
            </div>

            <button type="button" class="btn btn-danger" data-kt-user-table-select="delete_selected">
                Delete Selected
            </button>
        </div>
        <!--end::Group actions-->


        <!--begin::Modal - Add task-->
        <div wire:ignore.self class="modal fade" id="myModel" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $amenityId ? 'Edit Station Amenities' : 'Add Station Amenities' }}</h5>
                    </div>
                    <div class="modal-body  px-5 my-7">
                        <div class="mb-3">
                            <label class="required form-label">Icon</label>
                            <!--begin::Image input placeholder-->
                            <style>
                                .image-input-placeholder {
                                    background-image: url('svg/avatars/blank.svg');
                                }

                                [data-bs-theme="dark"] .image-input-placeholder {
                                    background-image: url('svg/avatars/blank-dark.svg');
                                }
                            </style>
                            <!--end::Image input placeholder-->

                            <!--begin::Image input-->
                            <div class="image-input image-input-outline" data-kt-image-input="true"
                                style="background-image: url(/assets/media/svg/avatars/blank.svg)">
                                <!--begin::Image preview wrapper-->
                                <div class="image-input-wrapper w-125px h-125px"
                                    style="background-image: url('{{ $icon
                                        ?  $icon->temporaryUrl()                             /* newly‑chosen */
                                        : ($oldIcon ? asset($oldIcon)                        /* DB value     */
                                                    : asset('assets/media/svg/avatars/blank.svg')) }}');">
                                </div>
                                <!--end::Image preview wrapper-->

                                <!--begin::Edit button-->
                                <label
                                    class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click"
                                    title="Change avatar">
                                    <i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span
                                            class="path2"></span></i>

                                    <!--begin::Inputs-->
                                    <input type="file" name="icon" wire:model.defer="icon" accept=".png, .jpg, .jpeg" />
                                    <input type="hidden" name="avatar_remove" />
                                    <!--end::Inputs-->
                                </label>
                                <!--end::Edit button-->

                                <!--begin::Cancel button-->
                                <span
                                    class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-bs-dismiss="click"
                                    title="Cancel avatar">
                                    <i class="ki-outline ki-cross fs-3"></i>
                                </span>
                                <!--end::Cancel button-->

                                <!--begin::Remove button-->
                                <span
                                    class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-bs-dismiss="click"
                                    title="Remove avatar">
                                    <i class="ki-outline ki-cross fs-3"></i>
                                </span>
                                <!--end::Remove button-->
                            </div>
                            <!--end::Image input-->

                        </div>
                        <div class="mb-3">
                            <label class="required form-label">Name</label>
                            <input wire:model.defer="name" type="text" class="form-control">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea wire:model.defer="description" rows="3" class="form-control"></textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        @if ($amenityId)
                            <button class="btn btn-primary" wire:click="update">Update</button>
                        @else
                            <button class="btn btn-primary" wire:click="create">Save</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!--end::Modal dialog-->
    </div>

    <div class="card-body ">

        <table class="table align-middle table-row-dashed fs-6 gy-5">
            <thead>
                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                    <th></th>
                    <th>Icon</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>

            <tbody class="text-gray-600 fw-semibold">
                @forelse($data as $key => $item)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>
                            <div class="symbol symbol-50px symbol-circle mb-9">
                                @if ($item->icon)
                                    <img src="{{ $item->icon }}" alt="image" />
                                @else
                                    <div
                                        class="symbol-label fs-3 {{ app(\App\Actions\GetThemeType::class)->handle('bg-light-? text-?', $item->name) }}">
                                        {{ substr($item->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->description }}</td>
                        <td class="text-end">
                            <button class="btn btn-hover-danger btn-icon" wire:click="edit({{ $item->id }})">
                                {!! getIcon('notepad-edit', 'fs-2tx') !!}
                            </button>
                            <button class="btn btn-hover-danger btn-icon"
                                wire:click="$emit('deletePrompt', {{ $item->id }})">

                                {!! getIcon('trash', 'fs-2tx') !!}
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-10">No Station Amenities found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $data->links() }}
    </div>
    {{-- table --}}


</div>
