<x-default-layout>

    @section('title')
        Edit Plan
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('plan-management.plans.show', $data) }}
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
                <form action="{{ route('plan-management.plans.update', $data->id ?? '') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')



                    <div class="form-group fv-row mb-7">
                        <label class="required fw-semibold fs-6 mb-2" name="answer">Plan
                            Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Free Trial"
                            value="{{ $data->name ?? '' }}" />
                        <span class="form-text text-muted">Enter a unique name for this plan (e.g.
                            Basic, Premium)</span>
                    </div>
                    {{-- <div class="form-group fv-row mb-7">

                        <label class="required fw-semibold fs-6 mb-2" name="answer">Plan
                            Validity</label>
                        <div class="input-group input-group-solid">
                            <!-- Integer input -->
                            <input type="number" name="validity_value" class="form-control" placeholder="Enter number"
                                required value="{{ $data->validity_value ?? '' }}" />

                            <!-- Unit select -->
                            <select name="validity_unit" class="form-select form-control" style="max-width: 150px;"
                                required>
                                <option value="days"
                                    {{ isset($data) && $data->validity_unit === 'days' ? 'selected' : '' }}>Day(s)
                                </option>
                                <option value="weeks"
                                    {{ isset($data) && $data->validity_unit === 'weeks' ? 'selected' : '' }}>
                                    Week(s)</option>
                                <option value="months"
                                    {{ isset($data) && $data->validity_unit === 'months' ? 'selected' : '' }}>
                                    Month(s)</option>
                                <option value="years"
                                    {{ isset($data) && $data->validity_unit === 'years' ? 'selected' : '' }}>
                                    Year(s)</option>
                            </select>
                        </div>
                        <span class="form-text text-muted">Enter a number and select the duration
                            unit (e.g. 3 months)</span>
                    </div> --}}


                    <div class="form-group fv-row mb-7">
                        <label class="required fw-semibold fs-6 mb-2" name="answer">Plan Monthly
                            Price</label>
                        <input id="price_touchspin_1" type="text" class="form-control" name="m_price"
                            placeholder="Select time" value="{{ $data->m_price ?? '' }}" />
                        <span class="form-text text-muted"> Use the spinner or type directly (e.g.
                            19.99)</span>

                    </div>

                    <div class="form-group fv-row mb-7">
                        <label class="required fw-semibold fs-6 mb-2" name="answer">Plan Yearly
                            Price</label>
                        <input id="price_touchspin_2" type="text" class="form-control" name="m_price"
                            placeholder="Select time" value="{{ $data->y_price ?? '' }}" />
                        <span class="form-text text-muted"> Use the spinner or type directly (e.g.
                            190.99)</span>

                    </div>
                    <!--begin::Feature Permissions-->
                    <div class="form-group fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">Feature Permissions</label>



                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-3">
                                <tbody class="text-gray-600 fw-semibold">
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
                                                <span class="form-check-label" for="select_all_features">Select
                                                    all</span>
                                            </label>
                                            <!--end::Checkbox-->
                                        </td>
                                    </tr>
                                    @foreach ($features->chunk(2) as $chunk)
                                        <tr>
                                            @foreach ($chunk as $feature)
                                                <td>
                                                    <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                        <input class="form-check-input feature-checkbox" type="checkbox"
                                                            name="features[]" value="{{ $feature->id }}"
                                                            {{ isset($data) && $data->features->contains('id', $feature->id) ? 'checked' : '' }} />
                                                        <span
                                                            class="form-check-label">{{ ucwords($feature->name) }}</span>
                                                    </label>
                                                </td>
                                            @endforeach

                                            @if ($chunk->count() < 2)
                                                <td></td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--end::Feature Permissions-->
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
    @push('scripts')
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

                $("#price_touchspin_2").TouchSpin({
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

            });
        </script>
        <script>
            $(document).ready(function() {
                $('#select_all_features').on('change', function() {
                    $('.feature-checkbox').prop('checked', $(this).is(':checked'));
                });

                $('.feature-checkbox').on('change', function() {
                    if ($('.feature-checkbox:checked').length !== $('.feature-checkbox').length) {
                        $('#select_all_features').prop('checked', false);
                    } else {
                        $('#select_all_features').prop('checked', true);
                    }
                });

                // Set initial state of select_all
                $('#select_all_features').prop('checked',
                    $('.feature-checkbox:checked').length === $('.feature-checkbox').length
                );
            });
        </script>
    @endpush
</x-default-layout>
