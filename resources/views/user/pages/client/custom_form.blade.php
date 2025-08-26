<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    />
    <title>Guestly</title>
    <link
        rel="icon"
        type="image/png"
        href="{{ asset('guestly_favicon.png') }}"
    />

    <!-- Bootstrap 5 CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Select2 CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
        rel="stylesheet"
    />
    <!-- Select2 Bootstrap 5 Theme -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
    />

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    />

    <style>
        :root {
            --primary-green: #0b3d27;
            --bg-color: #e6f4f0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-color);
            overflow-y: hidden
        }

        .font-arial-rounded {
            font-family: 'Arial Rounded MT Bold', sans-serif;
        }

        .custom-card {
            border-radius: 35px;
            border: none;
            max-width: 650px;
            width: 100%;
        }

        .btn-primary-green {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
            color: white;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .btn-primary-green:hover {
            background-color: #062a1a;
            border-color: #062a1a;
            color: white;
        }

        .form-scroll-area {
            max-height: 45vh;
            overflow-y: auto;
            padding-right: 15px;
        }

        .form-control:focus,
        .form-select:focus,
        .select2-container--bootstrap-5 .select2-selection {
            border-color: var(--primary-green) !important;
            box-shadow: 0 0 0 0.25rem rgba(11, 61, 39, 0.25) !important;
        }

        .form-floating>.form-select {
            padding-top: 1.625rem;
            padding-bottom: .625rem;
        }

        .form-label-select2 {
            color: #6c757d;
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }
    </style>
</head>


<body class="d-flex align-items-center justify-content-center min-vh-100 p-3">

    <div class="card custom-card shadow-lg">
        <div class="card-body p-4 p-md-5">

            <div class="text-center mb-4">
                <h2
                    class="font-arial-rounded"
                    style="color: var(--primary-green);"
                >Client Form</h2>
                <p class="text-muted">Fill Out Your Information</p>
            </div>

            <form>
                <!-- THIS NEW DIV MAKES THE CONTENT SCROLLABLE -->
                <div class="form-scroll-area">
                    <!-- Using Bootstrap Grid for a responsive 2-column layout -->
                    <div class="row g-3">
                        @if (isset($clientForm) && isset($clientForm->fields) && count($clientForm->fields) > 0)
                            @foreach ($clientForm->fields as $field)
                                {!! renderField($field) !!}
                            @endforeach
                        @endif
                    </div>
                    {{-- <div class="row g-3">
                        <!-- First Name Field -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="firstName"
                                    name="first_name"
                                    placeholder="First Name"
                                    required
                                >
                                <label for="firstName">First Name</label>
                            </div>
                        </div>

                        <!-- Last Name Field -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="lastName"
                                    name="last_name"
                                    placeholder="Last Name"
                                    required
                                >
                                <label for="lastName">Last Name</label>
                            </div>
                        </div>

                        <!-- Email Field -->
                        <div class="col-6">
                            <div class="form-floating">
                                <input
                                    type="email"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    placeholder="Email"
                                    required
                                >
                                <label for="email">Email</label>
                            </div>
                        </div>

                        <!-- Date Field -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input
                                    type="date"
                                    class="form-control"
                                    id="date"
                                    name="date"
                                    placeholder="Enter Date"
                                    required
                                >
                                <label for="email">Date</label>
                            </div>
                        </div>

                        <!-- Dropdown Field -->
                        <div class="form-floating">
                            <select
                                class="form-select"
                                id="field_1"
                                name="field_1"
                            >
                                <option
                                    value=""
                                    disabled
                                    selected
                                >Select an option</option>
                                <option value="Option 1">Option 1</option>
                                <option value="Option 2">Option 2</option>
                                <option value="Option 3">Option 3</option>
                            </select>
                            <label for="field_1">Dropdown</label>
                        </div>

                        <!-- MultiSelect Field -->
                        <div class="form-group">
                            <label
                                for="multi_select"
                                class="form-label"
                            >Multi Select</label>
                            <select
                                class="form-select select2"
                                id="multi_select"
                                name="multi_select[]"
                                multiple
                            >
                                <option value="Option 1">Option 1</option>
                                <option value="Option 2">Option 2</option>
                                <option value="Option 3">Option 3</option>
                            </select>
                        </div>

                        <!-- Textarea Field -->
                        <div class="form-floating">
                            <textarea
                                class="form-control"
                                placeholder="Enter your message"
                                id="message"
                                name="message"
                                style="height: 120px"
                                required
                            ></textarea>
                            <label for="field_1">Message</label>
                        </div>

                    </div> --}}
                </div>

                <!-- Submit Button Area -->
                <div class="mt-4 pt-4 border-top">
                    <button
                        type="submit"
                        class="btn btn-primary-green w-100 rounded-pill py-3 font-arial-rounded"
                    >
                        Submit
                    </button>
                </div>
            </form>

        </div>
    </div>

    <!-- jQuery, Bootstrap & Select2 JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap-5',
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                    'style',
                placeholder: $(this).data('placeholder'),
            });
        });
    </script>

</body>

</html>
