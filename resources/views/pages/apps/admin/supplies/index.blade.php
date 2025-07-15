<x-default-layout>
    @section('title') Supplies @endsection
    @section('breadcrumbs') {{ Breadcrumbs::render('plan-management.plans.index') }} @endsection

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div class="card">
            <div class="card-body py-4 mx-20">
                <livewire:admin.supplies />
            </div>
        </div>
    </div>

   @push('scripts')
<script>
document.addEventListener('livewire:load', () => {

    /* ── Sweet‑alert confirm delete (already working) ───────────────── */
    window.addEventListener('confirming-delete', e => {
        const id = e.detail.id;

        Swal.fire({
            text: 'Are you sure you want to remove?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete',
            cancelButtonText: 'No',
            buttonsStyling: false,
            customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton:  'btn btn-secondary',
            },
        }).then(r => r.isConfirmed && Livewire.emit('deleteConfirmed', id));
    });

    /* ── Toastr helper (already working) ─────────────────────────────── */
    window.addEventListener('toastr', e =>
        toastr[e.detail.type ?? 'info'](e.detail.message ?? '')
    );

    /* ── NEW: show & hide the Bootstrap modal ───────────────────────── */
    window.addEventListener('showSupplyModal', () => {
        new bootstrap.Modal(document.getElementById('supplyModal')).show();
    });

    window.addEventListener('hideSupplyModal', () => {
        const el    = document.getElementById('supplyModal');
        const modal = bootstrap.Modal.getInstance(el);
        if (modal) modal.hide();
    });

});
</script>
@endpush
</x-default-layout>
