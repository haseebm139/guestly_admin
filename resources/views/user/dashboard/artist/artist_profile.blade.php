@extends('user.layouts.master')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --light-green-bg: #EBF5F0;
            --card-header-bg: #E6F4F0;
            --dark-green: #004D40;
            --text-color: #333;
            --label-color: #868e96;
            --border-color: #ced4da;
        }
        .profile-page-wrapper {
            background-color: var(--light-green-bg);
            padding: 40px 20px;
            width: 100%;
            display: flex;
            justify-content: center;
            font-family: 'Inter', sans-serif;
        }
        .profile-card-container {
            background-color: #fff;
            border-radius: 24px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 600px;
            padding: 24px;
            box-sizing: border-box;
        }
        .profile-header {
            background-color: var(--card-header-bg);
            border-radius: 16px;
            padding: 24px;
            text-align: center;
            margin-bottom: 24px;
        }
        /*.profile-picture {*/
        /*    width: 90px;*/
        /*    height: 90px;*/
        /*    border-radius: 50%;*/
        /*    object-fit: cover;*/
        /*    margin-bottom: 12px;*/
        /*}*/
        .profile-name {
            font-size: 22px;
            font-weight: 600;
            color: #014122;
            margin: 0;
        }
        .profile-role {
            font-size: 14px;
            color: #555;
            margin: 4px 0 0;
        }
        .verification-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #5E8082;
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 24px;
        }
        .verification-section h3 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
            color: var(--dark-green);
        }
        .verified-status {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--dark-green);
            font-weight: 600;
            font-size: 16px;
        }
        .verified-status svg {
            width: 20px;
            height: 20px;
            fill: var(--dark-green);
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .info-field-full {
            grid-column: 1 / -1;
        }
        .info-field {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #5E8082;
            border-radius: 12px;
            padding: 8px 16px;
        }
        .field-data {
            flex-grow: 1;
        }
        .field-label {
            display: block;
            font-size: 12px;
            color: #5E8082;
            margin-bottom: 2px;
        }
        .value {
            font-size: 15px;
            font-weight: 500;
            color: var(--text-color);
        }
        .editable-input {
            display: block;
            width: 100%;
            border: none;
            background-color: transparent;
            padding: 0;
            font-size: 15px;
            font-weight: 500;
            color: var(--text-color);
        }
        .editable-input:focus {
            outline: none;
            box-shadow: none;
        }
        .action-btn {
            background: none;
            border: none;
            color: #014122;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            padding: 0 0 0 10px;
            text-decoration: underline;
        }
        .save-changes-container {
            text-align: center;
            margin-top: 32px;
        }
        .save-changes-btn {
            background-color: #014122;
            color: #fff;
            border: none;
            padding: 18px 40px;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
        }
        .profile-picture-container {
            position: relative;
            display: inline-block;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background-color: #f0f2f5;
            border: 2px solid var(--card-header-bg);
        }

        .profile-placeholder-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 30px;
            color: #aab0b9;
            z-index: 1;
        }

        .profile-picture {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            display: block;
            position: relative;
            z-index: 2;
        }

        .profile-picture-container .upload-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background-color: rgba(1, 65, 34, 0.7);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            cursor: pointer;
            z-index: 3;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .profile-picture-container:hover .upload-overlay {
            opacity: 1;
        }
        @media (max-width: 640px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>



{{-- CONTENT SECTION --}}
@section('content')
    <div class="profile-page-wrapper">
        <div class="profile-card-container">

            <div class="profile-header">
                <!-- Profile Image Upload (Updated Structure) -->
                <div class="profile-picture-container">

                    @if (!$user->avatar)
                        <i class="fa fa-camera profile-placeholder-icon"></i>
                    @endif

                        <img id="profilePreview"
                             src="{{ ($user->avatar && !str_contains($user->avatar, 'avatar/001-boy.svg')) ? asset('storage/' . $user->avatar) : asset('avatar/001-boy.svg') }}"
                             alt="Profile Picture"
                             class="profile-picture"
                             style="{{ ($user->avatar && !str_contains($user->avatar, 'avatar/001-boy.svg')) ? '' : 'background-color: transparent;' }}">


                        <label for="avatarInput" class="upload-overlay">
                        <i class="fa fa-camera"></i>
                    </label>

                </div>

                <h2 class="profile-name">{{ ucfirst($user->name) }}</h2>
                <p class="profile-role">{{ ucfirst($user->user_type) }}</p>
            </div>
            @if (session('success'))
                <div class="alert alert-success" style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align:center;">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger" style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- FORM START --}}
            <form method="POST" action="{{ route('dashboard.artist_profile_update') }} " enctype="multipart/form-data">
                @csrf
                <input type="file" id="avatarInput" name="avatar" accept="image/*" style="display: none;">

                <div class="verification-section">
                    <h3>Identification Verification</h3>
                    <span class="verified-status">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.9502 12.7L9.5002 11.275C9.31686 11.0917 9.08786 11 8.8132 11C8.53853 11 8.30086 11.1 8.1002 11.3C7.91686 11.4834 7.8252 11.7167 7.8252 12C7.8252 12.2834 7.91686 12.5167 8.1002 12.7L10.2502 14.85C10.4502 15.05 10.6835 15.15 10.9502 15.15C11.2169 15.15 11.4502 15.05 11.6502 14.85L15.9002 10.6C16.1002 10.4 16.1959 10.1667 16.1872 9.90004C16.1785 9.63337 16.0829 9.40004 15.9002 9.20004C15.7002 9.00004 15.4629 8.89604 15.1882 8.88804C14.9135 8.88004 14.6759 8.97571 14.4752 9.17504L10.9502 12.7ZM8.1502 21.75L6.7002 19.3L3.9502 18.7C3.7002 18.65 3.5002 18.521 3.3502 18.313C3.2002 18.105 3.14186 17.8757 3.1752 17.625L3.4502 14.8L1.5752 12.65C1.40853 12.4667 1.3252 12.25 1.3252 12C1.3252 11.75 1.40853 11.5334 1.5752 11.35L3.4502 9.20004L3.1752 6.37504C3.14186 6.12504 3.2002 5.89571 3.3502 5.68704C3.5002 5.47837 3.7002 5.34937 3.9502 5.30004L6.7002 4.70004L8.1502 2.25004C8.28353 2.03337 8.46686 1.88737 8.7002 1.81204C8.93353 1.73671 9.16686 1.74937 9.4002 1.85004L12.0002 2.95004L14.6002 1.85004C14.8335 1.75004 15.0669 1.73737 15.3002 1.81204C15.5335 1.88671 15.7169 2.03271 15.8502 2.25004L17.3002 4.70004L20.0502 5.30004C20.3002 5.35004 20.5002 5.47937 20.6502 5.68804C20.8002 5.89671 20.8585 6.12571 20.8252 6.37504L20.5502 9.20004L22.4252 11.35C22.5919 11.5334 22.6752 11.75 22.6752 12C22.6752 12.25 22.5919 12.4667 22.4252 12.65L20.5502 14.8L20.8252 17.625C20.8585 17.875 20.8002 18.1044 20.6502 18.313C20.5002 18.5217 20.3002 18.6507 20.0502 18.7L17.3002 19.3L15.8502 21.75C15.7169 21.9667 15.5335 22.1127 15.3002 22.188C15.0669 22.2634 14.8335 22.2507 14.6002 22.15L12.0002 21.05L9.4002 22.15C9.16686 22.25 8.93353 22.2627 8.7002 22.188C8.46686 22.1134 8.28353 21.9674 8.1502 21.75Z" fill="#014122" />
                        </svg>
                        Verified
                    </span>
                </div>

                <div class="info-grid mt-4">

                    <!-- Legal Name -->
                    <div class="info-field">
                        <div class="field-data">
                            <label class="field-label">Legal Name</label>
                            <span class="value">{{ $user->name }}</span>
                            <input type="text" name="name" class="editable-input" value="{{ old('name', $user->name) }}" style="display: none;">
                        </div>
                        <button type="button" class="action-btn toggle-edit-btn" data-original-text="Edit">Edit</button>
                    </div>

                    <!-- Email Address (Not Editable) -->
                    <div class="info-field">
                        <div class="field-data">
                            <label class="field-label">Email Address</label>
                            <span class="value">{{ $user->email }}</span>
                        </div>
                    </div>

                    <!-- Country/Region -->
                    <div class="info-field">
                        <div class="field-data">
                            <label class="field-label">Country/Region</label>
                            <span class="value">{{ $user->country ?? 'Not Provided' }}</span>
                            <input type="text" name="country" class="editable-input" value="{{ old('country', $user->country) }}" style="display: none;">
                        </div>
                        <button type="button" class="action-btn toggle-edit-btn" data-original-text="{{ $user->country ? 'Edit' : 'Add' }}">{{ $user->country ? 'Edit' : 'Add' }}</button>
                    </div>

                    <!-- Phone number -->
                    <div class="info-field">
                        <div class="field-data">
                            <label class="field-label">Phone number</label>
                            <span class="value">{{ $user->phone ?? 'Not Provided' }}</span>
                            <input type="tel" name="phone" class="editable-input" value="{{ old('phone', $user->phone) }}" style="display: none;">
                        </div>
{{--                        <button type="button" class="action-btn toggle-edit-btn" data-original-text="{{ $user->phone ? 'Edit' : 'Add' }}">{{ $user->phone ? 'Edit' : 'Add' }}</button>--}}
                    </div>

                    <!-- Address -->
                    <div class="info-field info-field-full">
                        <div class="field-data">
                            <label class="field-label">Address</label>
                            <span class="value">{{ $user->address ?? 'Not Provided' }}</span>
                            <input type="text" name="address" class="editable-input" value="{{ old('address', $user->address) }}" placeholder="Enter your address" style="display: none;">
                        </div>
                        <button type="button" class="action-btn toggle-edit-btn" data-original-text="{{ $user->address ? 'Edit' : 'Add' }}">{{ $user->address ? 'Edit' : 'Add' }}</button>
                    </div>

                    <!-- Emergency Contact -->
                    <div class="info-field info-field-full">
                        <div class="field-data">
                            <label class="field-label">Emergency Contact</label>
                            <span class="value">{{ $user->emergency_phone ?? 'Not Provided' }}</span>
                            <input type="tel" name="emergency_phone"
                                   class="editable-input"
                                   value="{{ old('emergency_phone', $user->emergency_phone) }}"
                                   placeholder="Enter emergency contact"
                                   style="display: none;">
                        </div>
                        <button type="button"
                                class="action-btn toggle-edit-btn"
                                data-original-text="{{ $user->emergency_phone ? 'Edit' : 'Add' }}">
                            {{ $user->emergency_phone ? 'Edit' : 'Add' }}
                        </button>
                    </div>
                </div>

                <div class="save-changes-container">
                    <button type="submit" class="save-changes-btn">Save Changes</button>
                </div>

            </form>
            {{-- FORM END --}}

        </div>
    </div>
@endsection
{{-- END CONTENT SECTION --}}


{{-- SCRIPTS SECTION --}}
@section('scripts')
    <script>
        $(document).ready(function() {
            $('.toggle-edit-btn').on('click', function() {
                var $btn = $(this);
                var $fieldWrapper = $btn.closest('.info-field');
                var $valueSpan = $fieldWrapper.find('.value');
                var $inputField = $fieldWrapper.find('.editable-input');
                var $label = $fieldWrapper.find('.field-label');

                if ($inputField.is(':visible')) {
                    var newValue = $inputField.val();

                    if (newValue.trim() === '' && $btn.data('original-text') === 'Add') {
                        $valueSpan.text('Not Provided');
                    } else {
                        $valueSpan.text(newValue);
                    }

                    $inputField.hide();
                    $label.show();
                    $valueSpan.show();

                    $btn.text($btn.data('original-text'));

                } else {
                    $valueSpan.hide();
                    $inputField.show().focus();
                    $label.show();
                    $btn.text('Done');
                }
            });
        });
    </script>
    <script>
        document.getElementById('avatarInput').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                document.getElementById('profilePreview').src = URL.createObjectURL(file);
            }
        });
    </script>
@endsection
{{-- END SCRIPTS SECTION --}}
