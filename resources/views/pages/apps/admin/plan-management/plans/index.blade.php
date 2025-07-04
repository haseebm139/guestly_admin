<x-default-layout>

    @section('title')
        Plan
    @endsection
    @section('breadcrumbs')
        {{ Breadcrumbs::render('plan-management.plans.index') }}
    @endsection
    <div id="kt_app_content" class="app-content  flex-column-fluid ">

        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                            <span class="path1"></span><span class="path2"></span>
                        </i>
                        <input type="text" id="userSearchInput" class="form-control form-control-solid w-250px ps-13"
                            placeholder="Search Here" />
                    </div>
                    <!--end::Search-->
                </div>


                <!--begin::Separator-->
                <div class="separator border-gray-200"></div>
                <!--end::Separator-->

                <!--begin::Content-->

                <div class="px-7 py-5" data-kt-user-table-filter="form">

                    <!--begin::Add user-->
                    <button type="button" class="btn btn-hover-danger btn-icon" data-bs-toggle="modal"
                        data-bs-target="#kt_modal_add_user">

                        <span class="menu-icon">{!! getIcon('add-item', 'fs-2tx') !!}</span>

                    </button>

                    <!--end::Add user-->
                </div>

                <!--end::Toolbar-->

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
                <div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true">
                    <!--begin::Modal dialog-->
                    <div class="modal-dialog modal-dialog-centered mw-650px">
                        <!--begin::Modal content-->
                        <div class="modal-content">
                            <!--begin::Modal header-->
                            <div class="modal-header" id="kt_modal_add_user_header">
                                <!--begin::Modal title-->
                                <h2 class="fw-bold">Add Plan</h2>
                                <!--end::Modal title-->

                                <!--begin::Close-->
                                <div class="btn btn-icon btn-sm btn-active-icon-primary"
                                    data-kt-users-modal-action="close" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span
                                            class="path2"></span></i>
                                </div>
                                <!--end::Close-->
                            </div>
                            <!--end::Modal header-->

                            <form id="kt_modal_add_user_form" class="form"
                                action="{{ route('plan-management.plans.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <!--begin::Modal body-->
                                <div class="modal-body px-5 my-2">
                                    <!--begin::Form-->

                                    <!--begin::Scroll-->
                                    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll"
                                        data-kt-scroll="true" data-kt-scroll-activate="true"
                                        data-kt-scroll-max-height="auto"
                                        data-kt-scroll-dependencies="#kt_modal_add_user_header"
                                        data-kt-scroll-wrappers="#kt_modal_add_user_scroll"
                                        data-kt-scroll-offset="300px">

                                        <div class="form-group fv-row mb-4">
                                            <label class="required fw-semibold fs-6 mb-2" name="answer">Plan
                                                Name</label>
                                            <input type="text" name="name" class="form-control"
                                                placeholder="Free Trial" />
                                            <span class="form-text text-muted">Enter a unique name for this plan (e.g.
                                                Basic, Premium)</span>
                                        </div>
                                        <div class="form-group fv-row mb-4">

                                            <label class="required fw-semibold fs-6 mb-2" name="answer">Plan
                                                Validity</label>
                                            <div class="input-group input-group-solid">
                                                <!-- Integer input -->
                                                <input type="number" name="validity_value" class="form-control"
                                                    placeholder="Enter number" required />

                                                <!-- Unit select -->
                                                <select name="validity_unit" class="form-select form-control"
                                                    style="max-width: 150px;" required>
                                                    <option value="days">Day(s)</option>
                                                    <option value="weeks">Week(s)</option>
                                                    <option value="months" selected>Month(s)</option>
                                                    <option value="years">Year(s)</option>
                                                </select>
                                            </div>
                                            <span class="form-text text-muted">Enter a number and select the duration
                                                unit (e.g. 3 months)</span>
                                        </div>


                                        <div class="form-group fv-row mb-4">
                                            <label class="required fw-semibold fs-6 mb-2" name="answer">Plan
                                                Price</label>
                                            <input id="price_touchspin_1" type="text" class="form-control"
                                                value="55" name="price" placeholder="Select time" />
                                            <span class="form-text text-muted"> Use the spinner or type directly (e.g.
                                                19.99)</span>

                                        </div>



                                        <!--begin::Permissions-->
                                        <div class="fv-row">
                                            <!--begin::Label-->
                                            <label class="fs-5 fw-bold form-label mb-2">Feature Permissions</label>
                                            <!--end::Label-->
                                            <!--begin::Table wrapper-->
                                            <div class="table-responsive">
                                                <!--begin::Table-->
                                                <table class="table align-middle table-row-dashed fs-6 gy-5">
                                                    <!--begin::Table body-->
                                                    <tbody class="text-gray-600 fw-semibold">
                                                        <!--begin::Table row-->
                                                        <tr>
                                                            <td class="text-gray-800">Feature Access
                                                                <span class="ms-1" data-bs-toggle="tooltip"
                                                                    title="Allows a full access to the system">
                                                                    {!! getIcon('information-5', 'text-gray-500 fs-6') !!}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <!--begin::Checkbox-->
                                                                <label
                                                                    class="form-check form-check-sm form-check-custom form-check-solid me-9">


                                                                    <input class="form-check-input" type="checkbox"
                                                                        id="select_all_features" />
                                                                    <span class="form-check-label"
                                                                        for="select_all_features">Select all</span>
                                                                </label>
                                                                <!--end::Checkbox-->
                                                            </td>
                                                        </tr>
                                                        <!--end::Table row-->
                                                        @if (isset($features))
                                                            @foreach ($features->chunk(2) as $chunk)
                                                                <!--begin::Table row-->
                                                                <tr>
                                                                    <!--begin::Label-->
                                                                    @foreach ($chunk as $feature)
                                                                        <!--end::Label-->
                                                                        <!--begin::Input group-->
                                                                        <td>
                                                                            <!--begin::Wrapper-->
                                                                            <div class="d-flex">
                                                                                <!--begin::Checkbox-->
                                                                                <label
                                                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                                                    <input
                                                                                        class="form-check-input feature-checkbox"
                                                                                        type="checkbox"
                                                                                        name="features[]"
                                                                                        value="{{ $feature->id }}" />
                                                                                    <span
                                                                                        class="form-check-label">{{ ucwords($feature->name) }}</span>
                                                                                </label>
                                                                                <!--end::Checkbox-->
                                                                            </div>
                                                                            <!--end::Wrapper-->
                                                                        </td>
                                                                        <!--end::Input group-->
                                                                    @endforeach
                                                                </tr>
                                                            @endforeach
                                                            <!--end::Table row-->
                                                        @endif
                                                        <!--begin::Table row-->
                                                    </tbody>
                                                    <!--end::Table body-->
                                                </table>
                                                <!--end::Table-->
                                            </div>
                                            <!--end::Table wrapper-->
                                        </div>
                                        <!--end::Permissions-->

                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end::Scroll-->

                                <!--begin::Actions-->
                                <div class="text-center pt-10 mb-5">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="indicator-label">
                                            Add
                                        </span>

                                    </button>
                                </div>
                                <!--end::Actions-->
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Modal body-->
                    </div>
                    <!--end::Modal content-->
                </div>
                <!--end::Modal dialog-->
            </div>
            <!--end::Modal - Add task-->
            <div class="card-body py-4 mx-20">

                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">


                            <th class="min-w-125px">Name</th>
                            <th class="min-w-125px">Price</th>
                            <th class="min-w-125px">Validity</th>
                            <th class="min-w-125px">Status</th>
                            <th class="text-end min-w-70px">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-semibold">
                        @isset($data)
                            @foreach ($data as $item)
                                <tr>

                                    <td>{{ $item->name ?? '' }}</td>
                                    <td>{{ $item->price ?? '' }}</td>
                                    <td>{{ $item->validity_value ?? '' }}/{{ $item->validity_unit ?? '' }}</td>
                                    <td>
                                        <div class="form-group">
                                            <div
                                                class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                <input type="checkbox" class="custom-control-input switch-input"
                                                    id="{{ $item->id }}" {{ $item->status == 1 ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="{{ $item->id }}"></label>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="text-end">

                                        <form action="{{ route('plan-management.plans.destroy', $item->id) }}"
                                            method="post" style="display:inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-hover-danger btn-icon">
                                                <span class="menu-icon">{!! getIcon('trash', 'fs-2tx') !!}</span>
                                            </button>
                                        </form>

                                        <form action="{{ route('plan-management.plans.edit', $item->id) }}"
                                            method="get" style="display:inline">
                                            @csrf

                                            <button type="submit" class="btn btn-hover-danger btn-icon">
                                                <span class="menu-icon">{!! getIcon('notepad-edit', 'fs-2tx') !!}</span>
                                            </button>
                                        </form>

                                    </td>

                                </tr>
                            @endforeach
                        @endisset


                    </tbody>
                </table>
                <!--end::Table-->
            </div>
        </div>


        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-touchspin@4.3.0/dist/jquery.bootstrap-touchspin.min.js"></script>

        <script>
            $(document).ready(function() {
                $("#price_touchspin_1").TouchSpin({
                    buttondown_class: 'btn btn-secondary',
                    buttonup_class: 'btn btn-secondary',

                    min: 0,
                    max: 1000000,
                    step: 0.1,
                    decimals: 2,
                    boostat: 5,
                    maxboostedstep: 10,
                    prefix: '$'
                });
                // Function to filter the table based on the search input
                function filterTable() {
                    var searchText = $('#userSearchInput').val().toLowerCase();

                    $('#kt_table_users tbody tr').each(function() {
                        var titleText = $(this).find('td:eq(2)').text().toLowerCase();

                        if (titleText.includes(searchText)) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    });
                }

                // Trigger the filter function when the search input changes
                $('#userSearchInput').on('input', function() {
                    filterTable();
                });
                $(".switch-input").change(function() {

                    if (this.checked)
                        var status = 1;
                    else
                        var status = 0;
                    $.ajax({
                        url: "{{ route('plan-management.plans.change.status') }}",
                        type: 'GET',
                        /*dataType: 'json',*/
                        data: {
                            'id': this.id,
                            'status': status
                        },
                        success: function(response) {
                            if (response) {
                                toastr.success(response.message);
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function(error) {
                            toastr.error("Some error occured!");
                        }
                    });
                });
            });
        </script>

        @push('scripts')
            <script>
                $(document).ready(function() {
                    // When 'Select All' is toggled
                    $('#select_all_features').on('change', function() {
                        $('.feature-checkbox').prop('checked', $(this).is(':checked'));
                    });

                    // If any individual checkbox is unchecked, uncheck "Select All"
                    $('.feature-checkbox').on('change', function() {
                        if ($('.feature-checkbox:checked').length !== $('.feature-checkbox').length) {
                            $('#select_all_features').prop('checked', false);
                        } else {
                            $('#select_all_features').prop('checked', true);
                        }
                    });
                });
            </script>
        @endpush
</x-default-layout>
