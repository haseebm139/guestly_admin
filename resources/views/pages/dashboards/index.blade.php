<x-default-layout>

    @section('title')
        Dashboard
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('dashboard') }}
    @endsection

    <!--begin::Row-->
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <!--begin::Col-->
        <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-md-5 mb-xl-10">
            @include('partials/widgets/cards/_widget-20')

            @include('partials/widgets/cards/_widget-7')
            @include('partials/widgets/cards/_widget-17')
        </div>
        <!--end::Col-->

        <!--begin::Col-->

        <!--end::Col-->
    </div>
    <!--end::Row-->

    <!--begin::Row-->




</x-default-layout>
