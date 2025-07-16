    <x-default-layout>
        @section('title')
            Station Amenities
        @endsection
        @section('breadcrumbs')
            {{ Breadcrumbs::render('creative-management.station-amenities.index') }}
        @endsection

        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div class="card">

                <livewire:admin.station-amenities />

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
                            customClass: {
                                confirmButton: 'btn btn-danger',
                                cancelButton: 'btn btn-secondary'
                            },
                        }).then(r => r.isConfirmed && Livewire.emit('deleteConfirmed', e.detail.id));
                    });

                    // Show / hide Bootstrap modal
                    window.addEventListener('modelShow', () => {
                        bootstrap.Modal.getOrCreateInstance(document.getElementById('myModel')).show();
                    });
                    window.addEventListener('modelHide', () => {
                        bootstrap.Modal.getOrCreateInstance(document.getElementById('myModel')).hide();
                    });

                    // Toastr
                    window.addEventListener('toastr', e =>
                        toastr[e.detail.type ?? 'info'](e.detail.message ?? '')
                    );


                    document.querySelectorAll('[data-kt-image-input="true"]').forEach(el => {
                        el.querySelector('[data-kt-image-input-action="remove"]')
                            ?.addEventListener('click', () => {
                                Livewire.find(el.closest('[wire\\:id]').getAttribute('wire:id'))
                                    .set('icon', null); // reset upload
                            });
                    });
                });
            </script>
        @endpush
    </x-default-layout>
