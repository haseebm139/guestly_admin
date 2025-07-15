<x-default-layout>
    @section('title')
        Supplies
    @endsection
    @section('breadcrumbs')
        {{ Breadcrumbs::render('plan-management.plans.index') }}
    @endsection

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div class="card">
            <div class="card-body py-4 mx-20">
                <livewire:admin.supplies />
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            window.addEventListener('toastr', event => {
                const type = event.detail.type || 'info';
                const message = event.detail.message || '';

                switch (type) {
                    case 'info':
                        toastr.info(message);
                        break;
                    case 'success':
                        toastr.success(message);
                        break;
                    case 'warning':
                        toastr.warning(message);
                        break;
                    case 'error':
                        toastr.error(message);
                        break;
                }
            });
            window.addEventListener('showSupplyModal', () =>
                new bootstrap.Modal(document.getElementById('supplyModal')).show());
            window.addEventListener('hideSupplyModal', () =>
                bootstrap.Modal.getInstance(document.getElementById('supplyModal')).hide());

            /* SweetAlert confirm on deletePrompt */
            Livewire.on('deletePrompt', id => {
                Swal.fire({
                    text: 'Are you sure you want to remove this supply?',
                    icon: 'warning',
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete',
                    cancelButtonText: 'No',
                    customClass: {
                        confirmButton: 'btn btn-danger',
                        cancelButton: 'btn btn-secondary',
                    }
                }).then(result => {
                    if (result.isConfirmed) {
                        Livewire.emit('deleteConfirmed', id);
                    }
                });
            });

            /* Toastr listener (already added earlier) */
            window.addEventListener('toastr', e => {
                toastr[e.detail.type ?? 'info'](e.detail.message ?? '');
            });
        </script>
    @endpush
</x-default-layout>
