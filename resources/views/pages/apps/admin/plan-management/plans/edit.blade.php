<x-default-layout>

    @section('title')
        Edit FAQ
    @endsection

    @section('breadcrumbs')
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">App Management</li>
                <li class="breadcrumb-item"><a href="{{ route('app-management.faq.index') }}">FAQ</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit FAQ</li>
            </ol>
        </nav>
    @endsection
    {{-- @dd($data) --}}
    <div id="kt_app_content" class="app-content flex-column-fluid">

        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">

            <!--begin::Card-->
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2 class="fw-bold">Edit FAQ</h2>
                    </div>
                </div>
                <!--end::Card header-->

                <!--begin::Content-->
                <div class="card-body py-4 mx-20">
                    <!--begin::Form-->
                    <form action="{{ route('app-management.faq.update', $data->id ?? '') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')



                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2" name="question">
                                Question</label>
                            <!--end::Label-->

                            <!--begin::solid autosize textarea-->
                            <div class="rounded border d-flex flex-column p-10">

                                <textarea name="question" class="form-control form-control form-control-solid" data-kt-autosize="true">{{ $data->question ?? '' }}</textarea>
                            </div>
                            <!--end::solid autosize textarea-->

                        </div>

                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2" name="answer">Answer</label>
                            <!--end::Label-->

                            <!--begin::solid autosize textarea-->
                            <div class="rounded border d-flex flex-column p-10">

                                <textarea name="answer" class="form-control form-control form-control-solid" data-kt-autosize="true">{{ $data->answer ?? '' }}</textarea>
                            </div>
                            <!--end::solid autosize textarea-->

                        </div>
                        <!--end::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Language</label>
                            <!--end::Label-->

                            <!--begin::Dropdown-->
                            <select name="lang" class="form-select form-select-solid mb-3 mb-lg-0">
                                <option value="en" {{ $data->lang == 'en' ? 'selected' : '' }}>English
                                </option>
                                <option value="ru" {{ $data->lang == 'ru' ? 'selected' : '' }}>Russian
                                </option>
                            </select>
                            <!--end::Dropdown-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Actions-->
                        <div class="text-center pt-10 mb-5">
                            <button type="submit" class="btn btn-primary">
                                <span class="indicator-label">Update</span>
                                <span class="indicator-progress">
                                    Please wait... <span
                                        class="spinner-border spinner-border-sm align-middle ms-2"></span>
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
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
</x-default-layout>
