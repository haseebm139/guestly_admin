    <x-default-layout>
        @section('title')
            Supplies
        @endsection
        @section('breadcrumbs')
            {{ Breadcrumbs::render('creative-management.supplies.index') }}
        @endsection

        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div class="card">

                    <livewire:admin.supplies />

            </div>
        </div>

        @push('scripts')
            <script>
            document.addEventListener('livewire:load', () => {


                // SweetAlert confirm dialog
                window.addEventListener('confirming-delete', e => {
                    Swal.fire({
                        text: 'Are you sure you want to remove?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete',
                        cancelButtonText: 'No',
                        buttonsStyling: false,
                        customClass:{confirmButton:'btn btn-danger', cancelButton:'btn btn-secondary'},
                    }).then(r => r.isConfirmed && Livewire.emit('deleteConfirmed', e.detail.id));
                });

                // Show / hide Bootstrap modal
                window.addEventListener('showSupplyModal', () => {
                    bootstrap.Modal.getOrCreateInstance(document.getElementById('supplyModal')).show();
                });
                window.addEventListener('hideSupplyModal', () => {
                    bootstrap.Modal.getOrCreateInstance(document.getElementById('supplyModal')).hide();
                });

                // Toastr
                window.addEventListener('toastr', e =>
                    toastr[e.detail.type ?? 'info'](e.detail.message ?? '')
                );
            });
            </script>
        @endpush
    </x-default-layout>
