@extends('user.layouts.master')

{{-- @push('styles') --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    :root {
        --light-green-bg: #EBF5F0;
        --dark-green: #004D40;
        --text-color: #333;
        --label-color: #868e96;
        --border-color: #ced4da;
    }

    .bio-page-wrapper {
        background-color: var(--light-green-bg);
        padding: 40px 20px;
        width: 100%;
        display: flex;
        justify-content: center;
        font-family: 'Inter', sans-serif;
    }

    .bio-card-container {
        background-color: #fff;
        border-radius: 24px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
        width: 100%;
        max-width: 600px;
        padding: 24px;
        box-sizing: border-box;
    }

    .card-title-heading {
        text-align: center;
        font-size: 20px;
        font-weight: 600;
        color: #014122;
        margin-bottom: 32px;
    }

    .section-title {
        font-size: 16px;
        font-weight: 600;
        margin-top: 32px;
        margin-bottom: 16px;
    }

    /* Bio Box Styles */
    /*.bio-box {*/
    /*    border: 1px solid var(--border-color);*/
    /*    border-radius: 12px;*/
    /*    padding: 10px 16px;*/
    /*}*/
    .bio-box {
        border: 1px solid #d3d3d3;
        border-radius: 12px;
        padding: 10px 16px;
        /* Ismein koi change nahi */
    }

    .bio-box .label {
        /* Ismein koi change nahi */
    }

    .bio-box .value {
        /* Ismein koi change nahi */
    }

    .bio-box .editable-textarea {
        /* Ismein koi change nahi */
    }

    /* Yahan ahem change hai */
    .bio-box-footer {
        display: flex;
        justify-content: flex-end;
        /* Button ko right side par push karega */
        margin-top: 8px;
    }

    .bio-box .action-link {
        /* display: block; aur text-align: right; hata diya gaya hai */
        background: none;
        border: none;
        color: var(--dark-green);
        font-weight: 600;
        font-size: 15px;
        cursor: pointer;
        padding: 0;
        text-decoration: underline;
    }

    /* Style Selection Box */
    .style-option-box {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: 1px solid #d3d3d3;
        border-radius: 12px;
        padding: 12px 16px;
        margin-bottom: 16px;
        cursor: pointer;
    }

    .style-label {
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 500;
    }

    /* --- CUSTOM RADIO BUTTON STYLES --- */
    .custom-checkbox input[type="checkbox"] {
        display: none;
        /* Asal checkbox ko chupao */
    }

    .custom-checkbox label {
        position: relative;
        display: inline-block;
        width: 22px;
        height: 22px;
        border: 2px solid var(--border-color);
        border-radius: 50%;
        /* Goal shape ke liye */
        cursor: pointer;
        transition: border-color 0.2s;
    }

    /* Jab checkbox checked ho, to label ka border change karo */
    .custom-checkbox input[type="checkbox"]:checked+label {
        border-color: #5E8082;
    }

    /* Inner dot ke liye pseudo-element */
    .custom-checkbox label::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0);
        width: 12px;
        height: 12px;
        background-color: #5E8082;
        border-radius: 50%;
        transition: transform 0.2s;
    }

    /* Jab checkbox checked ho, to inner dot ko dikhao */
    .custom-checkbox input[type="checkbox"]:checked+label::after {
        transform: translate(-50%, -50%) scale(1);
    }

    .save-changes-container {
        text-align: center;
        margin-top: 32px;
    }

    .save-changes-btn {
        background-color: #014122;
        color: #fff;
        border: none;
        padding: 14px 40px;
        border-radius: 50px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
    }
</style>
{{-- @endpush --}}

@section('content')
    <div class="bio-page-wrapper">
        <div class="bio-card-container">
            <form>
                {{--                @csrf --}}

                <h2 class="card-title-heading">Bio & Tattoo Styles</h2>

                <!-- Bio Section -->
                <div class="bio-box">
                    <label class="label" style="color:#5E8082; font-size: 12px;">Bio</label>
                    <p class="value" style="margin-top: 20px;">
                        I've been tattooing professionally for 7+ years, specializing in fine line and black & gray realism.
                        Passionate about detail, storytelling through art, and creating a calm, professional experience for
                        every client.
                    </p>
                    <textarea name="bio" class="editable-textarea" style="display: none;">I've been tattooing professionally for 7+ years, specializing in fine line and black & gray realism. Passionate about detail, storytelling through art, and creating a calm, professional experience for every client.</textarea>

                    {{-- Humne button ko aek naye div ke andar daal diya hai --}}
                    <div class="bio-box-footer">
                        <button type="button" class="action-link toggle-bio-edit">Update</button>
                    </div>
                </div>

                <!-- Tattoo Styles Section -->
                <h3 class="section-title">Social Accounts</h3> {{-- Title "Social Accounts" hai image mein, aap isko "Tattoo Styles" kar sakte hain --}}

                <div class="style-list">
                    @php
                        $styles = [
                            ['emoji' => '✍️', 'name' => 'Fine Line', 'checked' => true, 'value' => 'fine_line'],
                            ['emoji' => '🎨', 'name' => 'Watercolor', 'checked' => true, 'value' => 'watercolor'],
                            [
                                'emoji' => '⚫',
                                'name' => 'Black and Grey',
                                'checked' => false,
                                'value' => 'black_and_grey',
                            ],
                            ['emoji' => '🌈', 'name' => 'Color', 'checked' => false, 'value' => 'color'],
                            ['emoji' => '🖼️', 'name' => 'Realism', 'checked' => false, 'value' => 'realism'],
                        ];
                    @endphp

                    @foreach ($styles as $style)
                        <div class="style-option-box">
                            <span class="style-label">{{ $style['emoji'] }} {{ $style['name'] }}</span>
                            {{-- Yahan ab hum checkbox istemal kar rahe hain --}}
                            <div class="custom-checkbox">
                                <input type="checkbox" id="style_{{ $style['value'] }}" name="tattoo_styles[]"
                                    value="{{ $style['value'] }}" {{ $style['checked'] ? 'checked' : '' }}>
                                <label for="style_{{ $style['value'] }}"></label>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Save Button -->
                <div class="save-changes-container">
                    <button type="submit" class="save-changes-btn">Save Changes</button>
                </div>

            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Bio section ke liye edit functionality
            $('.toggle-bio-edit').on('click', function() {
                var $btn = $(this);
                var $bioBox = $btn.closest('.bio-box');
                var $valueP = $bioBox.find('.value');
                var $textarea = $bioBox.find('.editable-textarea');

                if ($textarea.is(':visible')) {
                    $valueP.text($textarea.val());
                    $textarea.hide();
                    $valueP.show();
                    $btn.text('Update');
                } else {
                    $valueP.hide();
                    $textarea.show().focus();
                    $btn.text('Done');
                }
            });

            // Poore box par click karke checkbox ko CHECK/UNCHECK karne ke liye
            $('.style-option-box').on('click', function(e) {
                // Taake label par click karne se event do baar na chale
                if ($(e.target).is('label') || $(e.target).is('input')) {
                    return;
                }

                var $checkbox = $(this).find('input[type="checkbox"]');
                // Checkbox ki state ko toggle karo (agar checked hai to uncheck, warna check)
                $checkbox.prop('checked', !$checkbox.prop('checked'));
            });
        });
    </script>
@endsection
