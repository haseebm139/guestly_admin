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
                    class="form-control form-control-solid w-250px ps-13" placeholder="Search Tattoo Style…" />
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
                        <h5 class="modal-title">{{ $styleId ? 'Edit Tattoo Style' : 'Add Tattoo Style' }}</h5>
                    </div>
                    <div class="modal-body  px-5 my-7">

                        <div class="mb-3">
                            <label class="required form-label">Name</label>
                            <input wire:model.defer="name" type="text" class="form-control">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="required form-label">Emoji</label>

                            <input wire:model.defer="icon" type="text" class="form-control">
                            @error('icon')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <small class="form-text text-muted">
                                Need help? <a href="https://emojipedia.org/smileys" target="_blank">Click here for more
                                    emojis</a>.
                            </small>
                        </div>

                    </div>
                    <div class="modal-footer">
                        @if ($styleId)
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
                    <th>Status</th>

                    <th class="text-end">Action</th>
                </tr>
            </thead>

            <tbody class="text-gray-600 fw-semibold">
                @forelse($data as $key => $item)
                    <tr>
                        <td>{{ ++$key }}</td>

                        <td>{{ $item->icon }}</td>
                        <td>{{ $item->name }}</td>
                        <td class="text-end">
                            <div class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input h-30px w-50px" type="checkbox"
                                    wire:change="toggleStatus({{ $item->id }})" id="flexSwitch{{ $item->id }}"
                                    @if ($item->status) checked @endif>
                                <label class="form-check-label" for="flexSwitch{{ $item->id }}">
                                    <span class="badge badge-{{ $item->status ? 'success' : 'danger' }}">{{ $item->status ? 'Active' : 'Inactive' }}</span>
                                </label>
                            </div>
                        </td>
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
                        <td colspan="7" class="text-center py-10">No Tattoo Style found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $data->links() }}
    </div>
    {{-- table --}}


</div>
