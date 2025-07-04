<x-default-layout>

    @section('title')
        Edit Plan
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('plan-management.features.show', $data) }}
    @endsection
    {{-- @dd($data) --}}
    <div id="kt_app_content" class="app-content flex-column-fluid">

        <!--begin::Content container-->
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">

            </div>
            <!--end::Card header-->

            <!--begin::Content-->
            <div class="card-body py-4 mx-20">
                <!--begin::Form-->
                <form action="{{ route('plan-management.features.update', $data->id ?? '') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')



                    <div class="form-group fv-row mb-7">
                        <label class="required fw-semibold fs-6 mb-2" name="name">Feature
                            Name</label>
                        <input type="text" name="name" class="form-control"
                            placeholder="Basic Guest Artist Profile" value="{{ $data->name ?? '' }}" />
                        <span class="form-text text-muted">Enter a unique name for this feature
                            (e.g.
                            Basic Guest Artist Profile)</span>
                    </div>

                    <!--begin::Actions-->
                    <div class="text-center pt-10 mb-5">
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">Update</span>
                            <span class="indicator-progress">
                                Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Card-->

        <!--end::Content container-->
    </div>
    <!--end::Content-->
</x-default-layout>
