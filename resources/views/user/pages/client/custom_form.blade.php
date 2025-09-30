<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Guestly</title>
    <link rel="icon" type="image/png" href="{{ asset('guestly_favicon.png') }}" />

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Select2 Bootstrap 5 Theme -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />

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



        .form-floating>.form-select {
            padding-top: 1.625rem;
            padding-bottom: .625rem;
        }



        .with-icon {
            position: relative
        }

        .with-icon .form-control,
        .with-icon .form-select {
            padding-left: 2.5rem
        }

        .form-icon {
            position: absolute;
            left: .75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 1rem
        }

        .form-floating .invalid-feedback {
            display: block
        }

        .form-floating .form-text {
            margin-top: .25rem
        }

        /* Better Select2 look with Bootstrap 5 */
        .select2-container--bootstrap-5 .select2-selection {
            min-height: calc(3.5rem + 2px);
            border-radius: .5rem;
            padding: .375rem .75rem;
        }

        .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__choice {
            background-color: #f1f3f5;
            border: 1px solid #dee2e6;
            color: #212529;
            border-radius: 999px;
            padding: .25rem .5rem;
            margin-top: .25rem;
        }

        .select2-container--bootstrap-5 .select2-results__option--selected {
            background-color: #e9f5ef;
            color: #0b3d27;
        }

        .select2-container--bootstrap-5 .select2-search__field {
            margin-top: .25rem;
        }

        /* Field group spacing */
        .form-group {
            margin-bottom: 1rem;
        }

        /* Image uploader */
        .image-dropzone {
            border: 2px dashed #cfd8dc;
            border-radius: 12px;
            background: #fafafa;
            padding: 16px;
            text-align: center;
            transition: border-color .2s, background-color .2s;
            cursor: pointer;
        }

        .image-dropzone.dragover {
            border-color: var(--primary-green);
            background: #f0f8f5;
        }

        .image-previews {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(96px, 1fr));
            gap: 10px;
            margin-top: 12px;
        }

        .image-thumb {
            position: relative;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            overflow: hidden;
            background: #fff;
        }

        .image-thumb img {
            width: 100%;
            height: 90px;
            object-fit: cover;
            display: block;
        }

        .image-thumb .btn-remove {
            position: absolute;
            top: 6px;
            right: 6px;
            border: 0;
            background: rgba(0, 0, 0, .6);
            color: #fff;
            border-radius: 8px;
            padding: .125rem .375rem;
            font-size: .8rem;
        }

        .image-uploader-help {
            color: #6c757d;
            font-size: .875rem;
        }
    </style>
</head>


<body class="d-flex align-items-center justify-content-center min-vh-100 p-3">

    <div class="card custom-card shadow-lg">
        <div class="card-body p-4 p-md-5">

            <div class="text-center mb-4">
                <h2 class="font-arial-rounded" style="color: var(--primary-green);">Client Form</h2>
                <p class="text-muted">Fill Out Your Information</p>
            </div>


            <form action="{{ route('client.booking.submit', $data->shared_code ?? '') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <!-- THIS NEW DIV MAKES THE CONTENT SCROLLABLE -->
                <div class="form-scroll-area">
                    <!-- Using Bootstrap Grid for a responsive 2-column layout -->
                    <div class="row g-3">

                        @if (isset($data) &&
                                isset($data->customForm) &&
                                isset($data->customForm->fields) &&
                                count($data->customForm->fields) > 0)
                            @php
                                $bookingDate = isset($data->booking_date)
                                    ? \Carbon\Carbon::parse($data->booking_date)->format('Y-m-d')
                                    : '';
                                $bookingTime = isset($data->booking_time)
                                    ? \Carbon\Carbon::parse($data->booking_time)->format('H:i')
                                    : '';
                            @endphp
                            <input type="hidden" name="shared_code" value="{{ $data->shared_code ?? '' }}">
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="studio_name"
                                        value="{{ $data->studio->studio_name ?? 'Studio' }}" name="studio_name"
                                        placeholder="Studio Name" readonly>
                                    <label for="studio_name">Studio Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="booking_date"
                                        value="{{ $bookingDate }}" name="booking_date" placeholder="Booking Date"
                                        readonly>
                                    <label for="booking_date">Booking Date</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="booking_time"
                                        value="{{ $bookingTime }}" name="booking_time" placeholder="Booking Date"
                                        readonly>
                                    <label for="booking_time">Booking Time</label>
                                </div>
                            </div>
                            @foreach ($data->customForm->fields as $field)
                                @php
                                    $value =
                                        $data->responses->where('custom_form_field_id', $field->id)->first()->value ??
                                        null;
                                @endphp
                                {!! renderField($field, $value) !!}
                            @endforeach
                        @endif
                    </div>

                </div>

                <!-- Submit Button Area -->
                <div class="mt-4 pt-4 border-top">
                    <button type="submit" class="btn btn-primary-green w-100 rounded-pill py-3 font-arial-rounded">
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
        $(function() {
            // Select2: consistent theme, placeholder, clear, keep error states
            $('.select2').each(function() {
                const $el = $(this);
                $el.select2({
                    theme: 'bootstrap-5',
                    width: '100%',
                    dropdownAutoWidth: true,
                    minimumResultsForSearch: 0,
                    placeholder: $el.data('placeholder') || ($el.prop('multiple') ?
                        'Select options' : 'Select an option'),
                    allowClear: !$el.prop('required'),
                    closeOnSelect: !$el.prop('multiple')
                }).on('change.select2', function() {
                    if (this.checkValidity()) $(this).removeClass('is-invalid');
                });
            });

            // Multi image uploader (drag & drop + preview + delete)
            document.querySelectorAll('.image-dropzone').forEach((zone) => {
                const inputId = zone.getAttribute('data-target-input');
                const maxFiles = parseInt(zone.getAttribute('data-max-files') || '8', 10);
                const maxSizeMb = parseInt(zone.getAttribute('data-max-size-mb') || '5', 10);
                const inputEl = document.getElementById(inputId);
                const previewsEl = document.getElementById(inputId + '-previews');

                let filesList = []; // tracked files

                function renderPreviews() {
                    previewsEl.innerHTML = '';
                    filesList.forEach((file, idx) => {
                        const url = URL.createObjectURL(file);
                        const wrapper = document.createElement('div');
                        wrapper.className = 'image-thumb';
                        wrapper.innerHTML = `
                    <img src="${url}" alt="preview">
                    <button type="button" class="btn-remove" data-index="${idx}" aria-label="Remove image">&times;</button>
                `;
                        previewsEl.appendChild(wrapper);
                    });
                }

                function syncInputFiles() {
                    // Create a DataTransfer to assign back to input.files
                    const dt = new DataTransfer();
                    filesList.forEach(f => dt.items.add(f));
                    inputEl.files = dt.files;
                }

                function validateAdd(newFiles) {
                    const errors = [];
                    const total = filesList.length + newFiles.length;
                    if (total > maxFiles) {
                        errors.push(`You can upload up to ${maxFiles} images.`);
                    }
                    newFiles.forEach(f => {
                        const mb = f.size / (1024 * 1024);
                        if (!f.type.startsWith('image/')) {
                            errors.push(`${f.name}: not an image file.`);
                        } else if (mb > maxSizeMb) {
                            errors.push(`${f.name}: exceeds ${maxSizeMb}MB.`);
                        }
                    });
                    return errors;
                }

                function addFiles(fileList) {
                    const filesArr = Array.from(fileList);
                    const errs = validateAdd(filesArr);
                    if (errs.length) {
                        alert(errs.join('\n'));
                        return;
                    }
                    filesArr.forEach(f => filesList.push(f));
                    renderPreviews();
                    syncInputFiles();
                }

                zone.addEventListener('click', () => inputEl.click());
                zone.addEventListener('dragover', (e) => {
                    e.preventDefault();
                    zone.classList.add('dragover');
                });
                zone.addEventListener('dragleave', () => zone.classList.remove('dragover'));
                zone.addEventListener('drop', (e) => {
                    e.preventDefault();
                    zone.classList.remove('dragover');
                    if (e.dataTransfer?.files?.length) addFiles(e.dataTransfer.files);
                });

                inputEl.addEventListener('change', (e) => {
                    if (e.target.files?.length) addFiles(e.target.files);
                });

                previewsEl.addEventListener('click', (e) => {
                    const btn = e.target.closest('.btn-remove');
                    if (!btn) return;
                    const idx = parseInt(btn.getAttribute('data-index'), 10);
                    filesList.splice(idx, 1);
                    renderPreviews();
                    syncInputFiles();
                });
            });
        });
    </script>
</body>

</html>
