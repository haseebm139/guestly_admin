<div>

    {{-- Toolbar --}}
    <div class="d-flex justify-content-between mb-5">
        <input wire:model.debounce.500ms="search" class="form-control w-250px" placeholder="Search supplies…" />
        <button class="btn btn-primary" wire:click="openCreateModal">
            {!! getIcon('add-item', 'fs-2') !!} Add Supply
        </button>
    </div>

    {{-- Table --}}
    <table class="table align-middle table-row-dashed">
        <thead>
            <tr class="text-muted fw-bold">
                <th>Name</th>
                <th>Description</th>
                <th class="text-end">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($supplies as $s)
                <tr>
                    <td>{{ $s->name }}</td>
                    <td>{{ $s->description }}</td>
                    <td class="text-end">
                        <button class="btn btn-icon btn-hover-primary" wire:click="edit({{ $s->id }})">
                            {!! getIcon('notepad-edit', 'fs-2tx') !!}
                        </button>
                        <button class="btn btn-icon btn-hover-danger"
                            wire:click="$emit('deletePrompt', {{ $s->id }})">
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

    {{-- Modal --}}
    <div wire:ignore.self class="modal fade" id="supplyModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ $supplyId ? 'Edit Supply' : 'Add Supply' }}
                    </h5>
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
                    <button class="btn btn-primary" wire:click="save">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
