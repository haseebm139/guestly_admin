<div class="modal fade" id="kt_modal_update_password" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Update Password</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <form id="kt_modal_update_password_form" class="form" method="POST"
                    action="{{ route('user-management.update-password', $user->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="fv-row mb-10">
                        <label class="required form-label fs-6 mb-2">Current Password</label>
                        <input class="form-control form-control-lg form-control-solid" type="password"
                            name="current_password" required />
                    </div>

                    <div class="mb-10 fv-row">
                        <label class="form-label fw-semibold fs-6 mb-2">New Password</label>
                        <input class="form-control form-control-lg form-control-solid" type="password"
                            name="new_password" required />
                    </div>

                    <div class="fv-row mb-10">
                        <label class="form-label fw-semibold fs-6 mb-2">Confirm New Password</label>
                        <input class="form-control form-control-lg form-control-solid" type="password"
                            name="new_password_confirmation" required />
                    </div>

                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3"
                            data-kt-users-modal-action="cancel">Discard</button>
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">Submit</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </form>

            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const modalElement = document.getElementById('kt_modal_update_password');
        const modal = bootstrap.Modal.getOrCreateInstance(modalElement);

        // Close button
        const closeBtn = modalElement.querySelector('[data-kt-users-modal-action="close"]');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => modal.hide());
        }

        // Cancel button
        const cancelBtn = modalElement.querySelector('[data-kt-users-modal-action="cancel"]');
        if (cancelBtn) {
            cancelBtn.addEventListener('click', () => modal.hide());
        }
    });
</script>
