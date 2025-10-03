<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Guestly - Client Form</title>
    <link rel="icon" type="image/png" href="{{ asset('guestly_favicon.png') }}" />

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />

    <style>
        :root {
            --primary-green: #0b3d27;
            --primary-green-light: #0d4d2f;
            --secondary-green: #e8f5e8;
            --accent-green: #2d5a3d;
            --bg-gradient: linear-gradient(135deg, #f0f8f5 0%, #e6f4f0 100%);
            --card-shadow: 0 20px 40px rgba(11, 61, 39, 0.1);
            --border-radius: 20px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-gradient);
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            overflow-x: hidden;
        }

        .form-container {
            max-width: 800px;
            margin: 0 auto;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .main-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: var(--border-radius);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: var(--card-shadow);
            overflow: hidden;
            position: relative;
        }

        .main-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-green), var(--accent-green));
        }

        .header-section {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-light) 100%);
            color: white;
            padding: 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        .header-section h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0;
            position: relative;
            z-index: 1;
        }

        .header-section p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin: 0.5rem 0 0 0;
            position: relative;
            z-index: 1;
        }

        .form-content {
            padding: 2.5rem;
        }

        .form-scroll-area {
            max-height: 60vh;
            overflow-y: auto;
            padding-right: 10px;
            margin-bottom: 2rem;
        }

        .form-scroll-area::-webkit-scrollbar {
            width: 6px;
        }

        .form-scroll-area::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .form-scroll-area::-webkit-scrollbar-thumb {
            background: var(--primary-green);
            border-radius: 10px;
        }

        .form-scroll-area::-webkit-scrollbar-thumb:hover {
            background: var(--primary-green-light);
        }

        .form-floating>.form-control,
        .form-floating>.form-select {
            height: calc(3.5rem + 2px);
            padding: 1rem 0.75rem;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            transition: var(--transition);
            background: rgba(255, 255, 255, 0.8);
        }

        .form-floating>.form-control:focus,
        .form-floating>.form-select:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 0.2rem rgba(11, 61, 39, 0.25);
            background: white;
        }

        .form-floating>label {
            padding: 1rem 0.75rem;
            color: #6c757d;
            font-weight: 500;
        }

        .form-floating>.form-control:focus~label,
        .form-floating>.form-control:not(:placeholder-shown)~label,
        .form-floating>.form-select:focus~label,
        .form-floating>.form-select:not([value=""])~label {
            color: var(--primary-green);
            transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
        }

        .form-label {
            color: var(--primary-green);
            font-weight: 600;
            margin-bottom: 0.75rem;
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-light) 100%);
            border: none;
            color: white;
            padding: 1rem 2rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            min-width: 200px;
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-submit:hover::before {
            left: 100%;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(11, 61, 39, 0.3);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-submit:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .loading-spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 2px solid transparent;
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 10px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Select2 Styling */
        .select2-container--bootstrap-5 .select2-selection {
            min-height: calc(3.5rem + 2px);
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 0.5rem 0.75rem;
            background: rgba(255, 255, 255, 0.8);
            transition: var(--transition);
        }

        .select2-container--bootstrap-5 .select2-selection:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 0.2rem rgba(11, 61, 39, 0.25);
        }

        .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__choice {
            background: var(--secondary-green);
            border: 1px solid var(--primary-green);
            color: var(--primary-green);
            border-radius: 20px;
            padding: 0.25rem 0.75rem;
            margin: 0.25rem 0.25rem 0 0;
            font-weight: 500;
        }

        .select2-container--bootstrap-5 .select2-results__option--selected {
            background-color: var(--secondary-green);
            color: var(--primary-green);
        }

        /* Image Uploader */
        .image-dropzone {
            border: 3px dashed #d1d5db;
            border-radius: 16px;
            background: linear-gradient(135deg, #fafafa 0%, #f5f5f5 100%);
            padding: 2rem;
            text-align: center;
            transition: var(--transition);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .image-dropzone::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(11, 61, 39, 0.05) 50%, transparent 70%);
            transform: translateX(-100%);
            transition: transform 0.6s;
        }

        .image-dropzone:hover::before {
            transform: translateX(100%);
        }

        .image-dropzone:hover {
            border-color: var(--primary-green);
            background: linear-gradient(135deg, #f0f8f5 0%, #e8f5e8 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(11, 61, 39, 0.15);
        }

        .image-dropzone.dragover {
            border-color: var(--primary-green);
            background: linear-gradient(135deg, #e8f5e8 0%, #d4edda 100%);
            transform: scale(1.02);
        }

        .dropzone-content i {
            color: var(--primary-green);
            opacity: 0.7;
        }

        .image-previews {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .image-thumb {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            background: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: var(--transition);
        }

        .image-thumb:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .image-thumb img {
            width: 100%;
            height: 100px;
            object-fit: cover;
            display: block;
        }

        .image-thumb .btn-remove {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 24px;
            height: 24px;
            border: none;
            background: rgba(220, 53, 69, 0.9);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            transition: var(--transition);
        }

        .image-thumb .btn-remove:hover {
            background: #dc3545;
            transform: scale(1.1);
        }

        /* Form validation */
        .form-control.is-invalid,
        .form-select.is-invalid {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }

        .invalid-feedback {
            display: block;
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            font-weight: 500;
        }

        .form-text {
            color: #6c757d;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .form-container {
                margin: 0;
                padding: 0;
            }

            .main-card {
                border-radius: 0;
                min-height: 100vh;
            }

            .header-section {
                padding: 1.5rem;
            }

            .header-section h1 {
                font-size: 2rem;
            }

            .form-content {
                padding: 1.5rem;
            }

            .form-scroll-area {
                max-height: 50vh;
            }
        }

        /* Success message */
        .success-message {
            display: none;
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1rem;
            text-align: center;
        }

        .success-message.show {
            display: block;
            animation: slideDown 0.5s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Progress indicator */
        .progress-indicator {
            display: none;
            background: var(--secondary-green);
            height: 4px;
            border-radius: 2px;
            margin-bottom: 1rem;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--primary-green), var(--accent-green));
            width: 0%;
            transition: width 0.3s ease;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <div class="main-card">
            <!-- Header Section -->
            <div class="header-section">
                <h1><i class="bi bi-calendar-check me-3"></i>Client Form</h1>
                <p>Please fill out your information below</p>
            </div>

            <!-- Form Content -->
            <div class="form-content">
                <!-- Success Message -->
                <div class="success-message" id="successMessage">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    Form submitted successfully! Thank you for your information.
                </div>

                <!-- Progress Indicator -->
                <div class="progress-indicator" id="progressIndicator">
                    <div class="progress-bar" id="progressBar"></div>
                </div>

                <form id="clientForm" action="{{ route('client.booking.submit', $data->shared_code ?? '') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Scrollable Form Area -->
                    <div class="form-scroll-area" id="formScrollArea">
                        <div class="row g-4">
                            @if (isset($data) && isset($data->customForm) && isset($data->customForm->fields) &&
                            count($data->customForm->fields) > 0)
                            @php
                            $bookingDate = isset($data->booking_date) ?
                            \Carbon\Carbon::parse($data->booking_date)->format('Y-m-d') : '';
                            $bookingTime = isset($data->booking_time) ?
                            \Carbon\Carbon::parse($data->booking_time)->format('H:i') : '';
                            @endphp

                            <input type="hidden" name="shared_code" value="{{ $data->shared_code ?? '' }}">

                            <!-- Studio Information -->
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="studio_name"
                                        value="{{ $data->studio->studio_name ?? 'Studio' }}" name="studio_name"
                                        placeholder="Studio Name" readonly>
                                    <label for="studio_name"><i class="bi bi-building me-2"></i>Studio Name</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="booking_date" value="{{ $bookingDate }}"
                                        name="booking_date" placeholder="Booking Date" readonly>
                                    <label for="booking_date"><i class="bi bi-calendar-date me-2"></i>Booking
                                        Date</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="booking_time" value="{{ $bookingTime }}"
                                        name="booking_time" placeholder="Booking Time" readonly>
                                    <label for="booking_time"><i class="bi bi-clock me-2"></i>Booking Time</label>
                                </div>
                            </div>

                            <!-- Dynamic Fields -->
                            @foreach ($data->customForm->fields as $field)
                            @php
                            $value = $data->responses->where('custom_form_field_id', $field->id)->first()->value ??
                            null;
                            @endphp
                            {!! renderField($field, $value) !!}
                            @endforeach
                            @endif
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-submit" id="submitBtn">
                            <div class="loading-spinner" id="loadingSpinner"></div>
                            <span id="submitText">Submit Form</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            // Initialize Select2
            $('.select2').each(function () {
                const $el = $(this);
                $el.select2({
                    theme: 'bootstrap-5',
                    width: '100%',
                    dropdownAutoWidth: true,
                    minimumResultsForSearch: 0,
                    placeholder: $el.data('placeholder') || ($el.prop('multiple') ? 'Select options...' : 'Choose an option...'),
                    allowClear: !$el.prop('required'),
                    closeOnSelect: !$el.prop('multiple')
                }).on('change.select2', function () {
                    if (this.checkValidity()) {
                        $(this).removeClass('is-invalid');
                    }
                });
            });

            // Enhanced image uploader
            document.querySelectorAll('.image-dropzone').forEach((zone) => {
                const inputId = zone.getAttribute('data-target-input');
                const maxFiles = parseInt(zone.getAttribute('data-max-files') || '8', 10);
                const maxSizeMb = parseInt(zone.getAttribute('data-max-size-mb') || '5', 10);
                const inputEl = document.getElementById(inputId);
                const previewsEl = document.getElementById(inputId + '-previews');

                let filesList = [];

                function renderPreviews() {
                    previewsEl.innerHTML = '';
                    filesList.forEach((file, idx) => {
                        const url = URL.createObjectURL(file);
                        const wrapper = document.createElement('div');
                        wrapper.className = 'image-thumb';
                        wrapper.innerHTML = `
                            <img src="${url}" alt="preview">
                            <button type="button" class="btn-remove" data-index="${idx}" aria-label="Remove image">
                                <i class="bi bi-x"></i>
                            </button>
                        `;
                        previewsEl.appendChild(wrapper);
                    });
                }

                function syncInputFiles() {
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
                        showNotification(errs.join('\n'), 'error');
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

            // Form submission with loading state
            $('#clientForm').on('submit', function (e) {
                e.preventDefault();

                const $form = $(this);
                const $submitBtn = $('#submitBtn');
                const $loadingSpinner = $('#loadingSpinner');
                const $submitText = $('#submitText');
                const $progressIndicator = $('#progressIndicator');
                const $progressBar = $('#progressBar');

                // Show loading state
                $submitBtn.prop('disabled', true);
                $loadingSpinner.show();
                $submitText.text('Submitting...');
                $progressIndicator.show();

                // Animate progress bar
                let progress = 0;
                const progressInterval = setInterval(() => {
                    progress += Math.random() * 15;
                    if (progress > 90) progress = 90;
                    $progressBar.css('width', progress + '%');
                }, 200);

                // Submit form
                $.ajax({
                    url: $form.attr('action'),
                    method: 'POST',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        clearInterval(progressInterval);
                        $progressBar.css('width', '100%');

                        setTimeout(() => {
                            $progressIndicator.hide();
                            $('#successMessage').addClass('show');
                            $form.hide();

                            // Reset form state
                            $submitBtn.prop('disabled', false);
                            $loadingSpinner.hide();
                            $submitText.text('Submit Form');
                        }, 500);
                    },
                    error: function (xhr) {
                        clearInterval(progressInterval);
                        $progressIndicator.hide();

                        // Reset form state
                        $submitBtn.prop('disabled', false);
                        $loadingSpinner.hide();
                        $submitText.text('Submit Form');

                        // Show error message
                        let errorMessage = 'An error occurred while submitting the form.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        showNotification(errorMessage, 'error');
                    }
                });
            });

            // Real-time validation
            $('input, textarea, select').on('blur', function () {
                if (this.checkValidity()) {
                    $(this).removeClass('is-invalid');
                } else {
                    $(this).addClass('is-invalid');
                }
            });

            // Notification system
            function showNotification(message, type = 'info') {
                const notification = $(`
                    <div class="alert alert-${type === 'error' ? 'danger' : 'info'} alert-dismissible fade show position-fixed" 
                         style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                        <i class="bi bi-${type === 'error' ? 'exclamation-triangle' : 'info-circle'} me-2"></i>
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `);

                $('body').append(notification);

                setTimeout(() => {
                    notification.alert('close');
                }, 5000);
            }

            // Smooth scrolling for form validation errors
            $('form').on('invalid', function (e) {
                const firstInvalid = $(this).find(':invalid').first();
                if (firstInvalid.length) {
                    $('html, body').animate({
                        scrollTop: firstInvalid.offset().top - 100
                    }, 500);
                    firstInvalid.focus();
                }
            });
        });
    </script>
</body>

</html>