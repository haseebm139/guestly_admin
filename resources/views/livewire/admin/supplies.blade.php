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
                    class="form-control form-control-solid w-250px ps-13" placeholder="Search Supplies…" />
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
        <div wire:ignore.self class="modal fade" id="supplyModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $supplyId ? 'Edit Supply' : 'Add Supply' }}</h5>
                    </div>
                    <div class="modal-body">
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
                        </div>
                    </div>
                    <div class="modal-footer">
                        @if ($supplyId)
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
                    <th>Name</th>
                    <th>Description</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 fw-semibold">
                @forelse($supplies as $s)
                    <tr>
                        <td>{{ $s->name }}</td>
                        <td>{{ $s->description }}</td>
                        <td class="text-end">
                            <button class="btn btn-hover-danger btn-icon" wire:click="edit({{ $s->id }})">
                                {!! getIcon('notepad-edit', 'fs-2tx') !!}
                            </button>
                            <button class="btn btn-hover-danger btn-icon"
                                wire:click="$emit('deletePrompt',{{ $s->id }})">
                                {!! getIcon('trash', 'fs-2tx') !!}
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-10">No supplies found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $supplies->links() }}
    </div>
    {{-- table --}}


</div>
