<?php

if (!function_exists('slugToWords')) {
function slugToWords(string $slug): string
{
    // Replace - and _ with space
    $words = str_replace(['-', '_'], ' ', $slug);
    
     
    // Lowercase then ucfirst each word
    return ucwords(strtolower($words));
}
}
if (!function_exists('theme')) {
    function theme()
    {
        return app(App\Core\Theme::class);
    }
}


if (!function_exists('getName')) {
    /**
     * Get product name
     *
     * @return void
     */
    function getName()
    {
        return config('settings.KT_THEME');
    }
}


if (!function_exists('addHtmlAttribute')) {
    /**
     * Add HTML attributes by scope
     *
     * @param $scope
     * @param $name
     * @param $value
     *
     * @return void
     */
    function addHtmlAttribute($scope, $name, $value)
    {
        theme()->addHtmlAttribute($scope, $name, $value);
    }
}


if (!function_exists('addHtmlAttributes')) {
    /**
     * Add multiple HTML attributes by scope
     *
     * @param $scope
     * @param $attributes
     *
     * @return void
     */
    function addHtmlAttributes($scope, $attributes)
    {
        theme()->addHtmlAttributes($scope, $attributes);
    }
}


if (!function_exists('addHtmlClass')) {
    /**
     * Add HTML class by scope
     *
     * @param $scope
     * @param $value
     *
     * @return void
     */
    function addHtmlClass($scope, $value)
    {
        theme()->addHtmlClass($scope, $value);
    }
}


if (!function_exists('printHtmlAttributes')) {
    /**
     * Print HTML attributes for the HTML template
     *
     * @param $scope
     *
     * @return string
     */
    function printHtmlAttributes($scope)
    {
        return theme()->printHtmlAttributes($scope);
    }
}


if (!function_exists('printHtmlClasses')) {
    /**
     * Print HTML classes for the HTML template
     *
     * @param $scope
     * @param $full
     *
     * @return string
     */
    function printHtmlClasses($scope, $full = true)
    {
        return theme()->printHtmlClasses($scope, $full);
    }
}


if (!function_exists('getSvgIcon')) {
    /**
     * Get SVG icon content
     *
     * @param $path
     * @param $classNames
     * @param $folder
     *
     * @return string
     */
    function getSvgIcon($path, $classNames = 'svg-icon', $folder = 'assets/media/icons/')
    {
        return theme()->getSvgIcon($path, $classNames, $folder);
    }
}


if (!function_exists('setModeSwitch')) {
    /**
     * Set dark mode enabled status
     *
     * @param $flag
     *
     * @return void
     */
    function setModeSwitch($flag)
    {
        theme()->setModeSwitch($flag);
    }
}


if (!function_exists('isModeSwitchEnabled')) {
    /**
     * Check dark mode status
     *
     * @return void
     */
    function isModeSwitchEnabled()
    {
        return theme()->isModeSwitchEnabled();
    }
}


if (!function_exists('setModeDefault')) {
    /**
     * Set the mode to dark or light
     *
     * @param $mode
     *
     * @return void
     */
    function setModeDefault($mode)
    {
        theme()->setModeDefault($mode);
    }
}


if (!function_exists('getModeDefault')) {
    /**
     * Get current mode
     *
     * @return void
     */
    function getModeDefault()
    {
        return theme()->getModeDefault();
    }
}


if (!function_exists('setDirection')) {
    /**
     * Set style direction
     *
     * @param $direction
     *
     * @return void
     */
    function setDirection($direction)
    {
        theme()->setDirection($direction);
    }
}


if (!function_exists('getDirection')) {
    /**
     * Get style direction
     *
     * @return void
     */
    function getDirection()
    {
        return theme()->getDirection();
    }
}


if (!function_exists('isRtlDirection')) {
    /**
     * Check if style direction is RTL
     *
     * @return void
     */
    function isRtlDirection()
    {
        return theme()->isRtlDirection();
    }
}


if (!function_exists('extendCssFilename')) {
    /**
     * Extend CSS file name with RTL or dark mode
     *
     * @param $path
     *
     * @return void
     */
    function extendCssFilename($path)
    {
        return theme()->extendCssFilename($path);
    }
}


if (!function_exists('includeFavicon')) {
    /**
     * Include favicon from settings
     *
     * @return string
     */
    function includeFavicon()
    {
        return theme()->includeFavicon();
    }
}


if (!function_exists('includeFonts')) {
    /**
     * Include the fonts from settings
     *
     * @return string
     */
    function includeFonts()
    {
        return theme()->includeFonts();
    }
}


if (!function_exists('getGlobalAssets')) {
    /**
     * Get the global assets
     *
     * @param $type
     *
     * @return array
     */
    function getGlobalAssets($type = 'js')
    {
        return theme()->getGlobalAssets($type);
    }
}


if (!function_exists('addVendors')) {
    /**
     * Add multiple vendors to the page by name. Refer to settings KT_THEME_VENDORS
     *
     * @param $vendors
     *
     * @return void
     */
    function addVendors($vendors)
    {
        theme()->addVendors($vendors);
    }
}


if (!function_exists('addVendor')) {
    /**
     * Add single vendor to the page by name. Refer to settings KT_THEME_VENDORS
     *
     * @param $vendor
     *
     * @return void
     */
    function addVendor($vendor)
    {
        theme()->addVendor($vendor);
    }
}


if (!function_exists('addJavascriptFile')) {
    /**
     * Add custom javascript file to the page
     *
     * @param $file
     *
     * @return void
     */
    function addJavascriptFile($file)
    {
        theme()->addJavascriptFile($file);
    }
}


if (!function_exists('addCssFile')) {
    /**
     * Add custom CSS file to the page
     *
     * @param $file
     *
     * @return void
     */
    function addCssFile($file)
    {
        theme()->addCssFile($file);
    }
}


if (!function_exists('getVendors')) {
    /**
     * Get vendor files from settings. Refer to settings KT_THEME_VENDORS
     *
     * @param $type
     *
     * @return array
     */
    function getVendors($type)
    {
        return theme()->getVendors($type);
    }
}


if (!function_exists('getCustomJs')) {
    /**
     * Get custom js files from the settings
     *
     * @return array
     */
    function getCustomJs()
    {
        return theme()->getCustomJs();
    }
}


if (!function_exists('getCustomCss')) {
    /**
     * Get custom css files from the settings
     *
     * @return array
     */
    function getCustomCss()
    {
        return theme()->getCustomCss();
    }
}


if (!function_exists('getHtmlAttribute')) {
    /**
     * Get HTML attribute based on the scope
     *
     * @param $scope
     * @param $attribute
     *
     * @return array
     */
    function getHtmlAttribute($scope, $attribute)
    {
        return theme()->getHtmlAttribute($scope, $attribute);
    }
}


if (!function_exists('isUrl')) {
    /**
     * Get HTML attribute based on the scope
     *
     * @param $url
     *
     * @return mixed
     */
    function isUrl($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL);
    }
}


if (!function_exists('image')) {
    /**
     * Get image url by path
     *
     * @param $path
     *
     * @return string
     */
    function image($path)
    {
        return asset('assets/media/'.$path);
    }
}


if (!function_exists('getIcon')) {
    /**
     * Get icon
     *
     * @param $path
     *
     * @return string
     */
    function getIcon($name, $class = '', $type = '', $tag = 'span')
    {
        return theme()->getIcon($name, $class, $type, $tag);
    }
}

if (!function_exists('sendVerificationMail')) {
    function sendVerificationMail($otp,$email)
    {
        // Send Email
            Illuminate\Support\Facades\Mail::send('emails.reset-password-email', ['otp' => $otp], function($message) use($email){
                $message->to($email, 'Verification Code From Guestly');
                $message->subject('You have received Verification Code');
            });
        // Send Email
    }
}


if (!function_exists('sendBookingMail')) {
    function sendBookingMail($name, $lastName, $email, $profileLink)     
    {

         
        $fullName = trim(($name ?? '') . ' ' . ($lastName ?? ''));
        if (empty($fullName)) {
            $fullName = 'Guest'; // fallback if no name available
        }
        // Send Email
            Illuminate\Support\Facades\Mail::send('emails.client_profile_link', 
            [
                'full_name'    => $fullName,
                'profile_link' => $profileLink,
            ],
            function ($message) use ($email, $fullName) {
                $message->to($email, $fullName)
                        ->subject('Your Guestly Profile Link');
            });
        // Send Email
    }
}

if (!function_exists('stringUpperCase')) {
    function stringUpperCase($value)
    {
        $text = Illuminate\Support\Str::upper($value);
       return $text;
    }
}

if (!function_exists('stringLowerCase')) {
    function stringLowerCase($value)
    {
        $text = Illuminate\Support\Str::lower($value);
       return $text;
    }
}

if (!function_exists('stringIntoArray')) {
    function stringIntoArray($value)
    {
        $clean_string = trim($value, '[]');
        $interest_list = explode(',', $clean_string);
        $interest_list = array_map('trim', $interest_list);
        return $interest_list;
    }
}

if (!function_exists('calculate_duration_days')) {
    function calculate_duration_days($value, $unit) {
        return match ($unit) {
            'days' => $value,
            'weeks' => $value * 7,
            'months' => $value * 30,
            'years' => $value * 365,
            default => throw new \InvalidArgumentException("Invalid unit"),
        };
    }
}

if (!function_exists('renderField1')) {
    function renderField1($field, $value = null,  )
    {
        $html = '';
        $field_name = \Illuminate\Support\Str::snake($field->label);
        $name = $field_name.'|'.$field->id;
        switch ($field->type) {
            case 'email':
            case 'text':
                $html .= '<div class="col-md-6">
                    <div class="form-floating">
                        <input type="'.$field->type.'" class="form-control"
                               id="'.$name.'" name="'.$name.'"
                               placeholder="'.$field->label.'"
                               value="'.($value ?? '').'" '.($field->is_required ? 'required' : '').'>
                        <label for="'.$name.'">'.$field->label.'</label>
                    </div>
                </div>';
                break;

            case 'date':
                $html .= '<div class="col-md-6">
                    <div class="form-floating">
                        <input type="date" class="form-control"
                               id="'.$name.'" name="'.$name.'"
                               value="'.($value ? \Carbon\Carbon::parse($value)->format('Y-m-d') : '').'"
                               placeholder="'.$field->label.'" '.($field->is_required ? 'required' : '').'>
                        <label for="'.$name.'">'.$field->label.'</label>
                    </div>
                </div>';
                break;

            case 'datetime':
                $html .= '<div class="col-md-6">
                    <div class="form-floating">
                        <input type="datetime-local" class="form-control"
                               id="'.$name.'" name="'.$name.'"
                               value="'.($value ? \Carbon\Carbon::parse($value)->format('Y-m-d\TH:i') : '').'"
                               placeholder="'.$field->label.'" '.($field->is_required ? 'required' : '').'>
                        <label for="'.$name.'">'.$field->label.'</label>
                    </div>
                </div>';
                break;

            case 'textarea':
                $html .= '<div class="form-floating">
                    <textarea class="form-control" id="'.$name.'" name="'.$name.'"
                              placeholder="'.$field->label.'" style="height:120px" '.($field->is_required ? 'required' : '').'>'.($value ?? '').'</textarea>
                    <label for="'.$name.'">'.$field->label.'</label>
                </div>';
                break;

            case 'dropdown':
            case 'multi_select':
                $options = is_string($field->options)
                    ? (json_decode($field->options, true) ?? [])
                    : ($field->options ?? []);

                $isMulti = $field->type === 'multi_select';

                // Use snake_case for name/id
                $fieldBaseName = \Illuminate\Support\Str::snake($field->label);
                $baseName = $fieldBaseName.'|'.$field->id;
                $nameAttr = $isMulti ? $baseName.'[]' : $baseName;
                $idAttr = $baseName;

                $html .= '<div class="form-floating mb-3">
                            <select class="form-select'.($isMulti?' select2':'').'"
                                    id="'.$idAttr.'" name="'.$nameAttr.'" '.($field->is_required ? 'required' : '').($isMulti?' multiple':'').'>';

                if (!$isMulti) {
                    $html .= '<option value="" disabled selected>Select an option</option>';
                }

                foreach ($options as $option) {
                    $selected = '';
                    if ($value) {
                        if ($isMulti && is_array($value) && in_array($option, $value)) {
                            $selected = 'selected';
                        } elseif (!$isMulti && $option == $value) {
                            $selected = 'selected';
                        }
                    }
                    $html .= '<option value="'.$option.'" '.$selected.'>'.$option.'</option>';
                }

                $html .= '</select>
                        <label for="'.$idAttr.'">'.$field->label.'</label>
                        </div>';
                break;
            }

        return $html;
    }
}

if (!function_exists('renderField')) {
    function renderField($field, $value = null)
    {
        $html = '';

        $type = $field->type ?? 'text';
        $label = e($field->label ?? 'Field');
        $isRequired = !empty($field->is_required);

        // Stable id/name
        $fieldBase = \Illuminate\Support\Str::snake($field->label ?? 'field');
        $baseName = $fieldBase . '|' . ($field->id ?? \Illuminate\Support\Str::random(6)) . '|' . $type;
        $inputId = $baseName;

        // Laravel errors
        $errorsBag = session('errors');
        $hasError = $errorsBag ? ($errorsBag->has($baseName) || $errorsBag->has($baseName . '.*')) : false;
        $firstError = $errorsBag ? ($errorsBag->first($baseName) ?: $errorsBag->first($baseName . '.*')) : null;

        // old() overrides value
        $oldValue = old($baseName, $value);

        $requiredAttr = $isRequired ? ' required' : '';
        $requiredMark = $isRequired ? ' *' : '';
        $invalidClass = $hasError ? ' is-invalid' : '';
        $errorId = $inputId . '-error';
        $helpId = $inputId . '-help';
        $ariaInvalid = $hasError ? ' aria-invalid="true"' : '';
        $ariaDescribedBy = ' aria-describedby="' . ($hasError ? $errorId : $helpId) . '"';

        // Optional constraints
        $maxLength = property_exists($field, 'max_length') && $field->max_length ? ' maxlength="' . (int) $field->max_length . '"' : '';
        $minLength = property_exists($field, 'min_length') && $field->min_length ? ' minlength="' . (int) $field->min_length . '"' : '';
        $placeholderAttr = property_exists($field, 'placeholder') && $field->placeholder ? ' placeholder="' . e($field->placeholder) . '"' : '';
        $helpText = property_exists($field, 'help_text') && $field->help_text ? '<div id="' . $helpId . '" class="form-text small">' . e($field->help_text) . '</div>' : '<div id="' . $helpId . '" class="form-text small"></div>';

        switch ($type) {
            case 'email':
            case 'text':
                $html .= '
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="' . $type . '" class="form-control' . $invalidClass . '"
                               id="' . $inputId . '" name="' . $baseName . '"'
                               . $placeholderAttr . $requiredAttr . $minLength . $maxLength . $ariaInvalid . $ariaDescribedBy . '
                               value="' . e((string)($oldValue ?? '')) . '">
                        <label for="' . $inputId . '">' . $label . $requiredMark . '</label>
                        ' . ($hasError ? '<div id="' . $errorId . '" class="invalid-feedback">' . e($firstError) . '</div>' : $helpText) . '
                    </div>
                </div>';
                break;

            case 'date':
                $formatted = $oldValue ? \Carbon\Carbon::parse($oldValue)->format('Y-m-d') : '';
                $html .= '
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="date" class="form-control' . $invalidClass . '"
                               id="' . $inputId . '" name="' . $baseName . '"'
                               . $requiredAttr . $ariaInvalid . $ariaDescribedBy . '
                               value="' . e($formatted) . '">
                        <label for="' . $inputId . '">' . $label . $requiredMark . '</label>
                        ' . ($hasError ? '<div id="' . $errorId . '" class="invalid-feedback">' . e($firstError) . '</div>' : $helpText) . '
                    </div>
                </div>';
                break;

            case 'datetime':
            case 'datetime_local':
                $formatted = $oldValue ? \Carbon\Carbon::parse($oldValue)->format('Y-m-d\TH:i') : '';
                $html .= '
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="datetime-local" class="form-control' . $invalidClass . '"
                               id="' . $inputId . '" name="' . $baseName . '"'
                               . $requiredAttr . $ariaInvalid . $ariaDescribedBy . '
                               value="' . e($formatted) . '">
                        <label for="' . $inputId . '">' . $label . $requiredMark . '</label>
                        ' . ($hasError ? '<div id="' . $errorId . '" class="invalid-feedback">' . e($firstError) . '</div>' : $helpText) . '
                    </div>
                </div>';
                break;

            case 'textarea':
                $html .= '
                <div class="col-12">
                    <div class="form-floating mb-3">
                        <textarea class="form-control' . $invalidClass . '"
                                  id="' . $inputId . '" name="' . $baseName . '" style="height: 140px"'
                                  . $placeholderAttr . $requiredAttr . $minLength . $maxLength . $ariaInvalid . $ariaDescribedBy . '>'
                                  . e((string)($oldValue ?? '')) . '</textarea>
                        <label for="' . $inputId . '">' . $label . $requiredMark . '</label>
                        ' . ($hasError ? '<div id="' . $errorId . '" class="invalid-feedback">' . e($firstError) . '</div>' : $helpText) . '
                    </div>
                </div>';
                break;

            case 'dropdown':
            case 'multi_select':
                // Use standard label + Select2 (floating label is poor with Select2)
                $rawOptions = is_string($field->options ?? null)
                    ? (json_decode($field->options, true) ?? [])
                    : ($field->options ?? []);

                $normalized = [];
                foreach ($rawOptions as $opt) {
                    if (is_array($opt)) {
                        $val = (string)($opt['value'] ?? $opt['label'] ?? '');
                        $lab = (string)($opt['label'] ?? $opt['value'] ?? '');
                    } else {
                        $val = (string)$opt;
                        $lab = (string)$opt;
                    }
                    if ($val === '' && $lab === '') continue;
                    $normalized[] = ['value' => $val, 'label' => $lab];
                }

                $isMulti = ($type === 'multi_select');

                // Selected values (respect old())
                if ($isMulti) {
                    $oldArray = old($baseName);
                    if (is_array($oldArray)) {
                        $selectedValues = array_map('strval', $oldArray);
                    } else {
                        if (is_string($oldValue) && $oldValue !== '') {
                            $decoded = json_decode($oldValue, true);
                            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                $selectedValues = array_map('strval', $decoded);
                            } else {
                                $selectedValues = array_map('strval', array_filter(array_map('trim', explode(',', $oldValue))));
                            }
                        } elseif (is_array($oldValue)) {
                            $selectedValues = array_map('strval', $oldValue);
                        } else {
                            $selectedValues = [];
                        }
                    }
                } else {
                    $selectedValues = [(string)($oldValue ?? '')];
                }

                $nameAttr = $isMulti ? ($baseName . '[]') : $baseName;
                $multipleAttr = $isMulti ? ' multiple' : '';
                $selectClasses = 'form-select select2' . ($invalidClass ? ' is-invalid' : '');
                $placeholderText = $label;

                $html .= '
                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label" for="' . $inputId . '">' . $label . $requiredMark . '</label>
                        <select class="' . $selectClasses . '" id="' . $inputId . '" name="' . $nameAttr . '"'
                            . $multipleAttr . $requiredAttr . $ariaInvalid . $ariaDescribedBy . ' data-placeholder="' . e($placeholderText) . '">';

                if (!$isMulti) {
                    $isSelected = empty($selectedValues[0]) ? ' selected' : '';
                    $html .= '<option value="" disabled ' . $isSelected . '>Select an option</option>';
                }

                foreach ($normalized as $opt) {
                    $isSelected = in_array((string)$opt['value'], $selectedValues, true) ? ' selected' : '';
                    $html .= '<option value="' . e($opt['value']) . '"' . $isSelected . '>' . e($opt['label']) . '</option>';
                }

                $html .= '</select>'
                        . ($hasError ? '<div id="' . $errorId . '" class="invalid-feedback d-block">' . e($firstError) . '</div>' : $helpText) . '
                    </div>
                </div>';
                break;

            case 'image':
                // Multi image uploader (UI only). Controller must accept an array input name.
                $maxFiles = (int)($field->max_files ?? 8);
                $maxSizeMb = (int)($field->max_size_mb ?? 5); // each
                $accept = 'image/*';
                // Name must be array to hold multiple files
                $nameAttr = $baseName . '[]';

                $html .= '
                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label" for="' . $inputId . '">' . $label . $requiredMark . '</label>
                        <div class="image-dropzone" data-target-input="' . $inputId . '" data-max-files="' . $maxFiles . '" data-max-size-mb="' . $maxSizeMb . '">
                            <div class="text-muted">
                                <i class="bi bi-cloud-arrow-up-fill"></i>
                                <div><strong>Drag & drop</strong> images here, or click to browse</div>
                                <div class="image-uploader-help">Up to ' . $maxFiles . ' images, ' . $maxSizeMb . 'MB each</div>
                            </div>
                        </div>
                        <input type="file" class="d-none"
                               id="' . $inputId . '" name="' . $nameAttr . '" accept="' . $accept . '" multiple' . $requiredAttr . '>
                        <div class="image-previews" id="' . $inputId . '-previews"></div>
                        ' . ($hasError ? '<div id="' . $errorId . '" class="invalid-feedback d-block">' . e($firstError) . '</div>' : $helpText) . '
                    </div>
                </div>';
                break;
        }

        return $html;
    }
}
if (!function_exists('renderTableField')) {
    function renderTableField($field, $value = null)
    {
        $html = '';

        $label = e($field->label ?? '');
        $type = $field->type ?? 'text';
        $idSuffix = (string) ($field->id ?? \Illuminate\Support\Str::random(6));

        // Choose an icon by field type
        $icon = match ($type) {
            'email'       => 'envelope',
            'date'        => 'calendar-event',
            'datetime'    => 'clock',
            'textarea'    => 'chat-left-text',
            'dropdown'    => 'chevron-double-down',
            'multi_select'=> 'list-check',
            default       => 'type',
        };

        // Helper: pretty placeholder
        $placeholder = '<span class="text-muted">—</span>';

        switch ($type) {
            case 'email':
            case 'text':
            case 'date':
            case 'datetime':
                $formattedValue = $value;

                if ($type === 'date' && $value) {
                    $formattedValue = \Carbon\Carbon::parse($value)->format('Y-m-d');
                } elseif ($type === 'datetime' && $value) {
                    $formattedValue = \Carbon\Carbon::parse($value)->format('Y-m-d H:i');
                }

                // If email, make it clickable
                $displayValue = trim((string) $formattedValue) !== ''
                    ? ($type === 'email'
                        ? '<a href="mailto:' . e($formattedValue) . '" class="text-decoration-none">'
                            . e($formattedValue) . '</a>'
                        : '<span class="badge rounded-pill bg-light text-dark border px-3 py-2">'
                            . e($formattedValue) . '</span>')
                    : $placeholder;

                $html .= '
                <li class="detail-item d-flex align-items-start justify-content-between gap-3 py-3">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-' . $icon . ' text-muted"></i>
                        <span class="detail-label">' . $label . '</span>
                    </div>
                    <div class="detail-value text-end">' . $displayValue . '</div>
                </li>';
                break;

            case 'textarea':
                $content = nl2br(e((string)($value ?? '')));
                $hasContent = trim((string) $value) !== '';
                $collapseId = 'field-textarea-' . $idSuffix;

                $html .= '
                <li class="detail-item py-3">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="bi bi-' . $icon . ' text-muted"></i>
                        <span class="detail-label">' . $label . '</span>
                    </div>
                    ' . ($hasContent
                        ? '
                        <div class="small">
                            <a class="text-decoration-none" data-bs-toggle="collapse" href="#' . $collapseId . '" role="button" aria-expanded="false" aria-controls="' . $collapseId . '">
                                Show details
                            </a>
                        </div>
                        <div class="collapse mt-2" id="' . $collapseId . '">
                            <div class="p-3 bg-light border rounded">' . $content . '</div>
                        </div>'
                        : '<div class="text-muted">—</div>') . '
                </li>';
                break;

            case 'dropdown':
                $display = trim((string) $value) !== ''
                    ? '<span class="badge rounded-pill bg-light text-dark border px-3 py-2">' . e($value) . '</span>'
                    : $placeholder;

                $html .= '
                <li class="detail-item d-flex align-items-start justify-content-between gap-3 py-3">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-' . $icon . ' text-muted"></i>
                        <span class="detail-label">' . $label . '</span>
                    </div>
                    <div class="detail-value text-end">' . $display . '</div>
                </li>';
                break;

            case 'multi_select':
                // Normalize to array
                if (is_string($value)) {
                    $decoded = json_decode($value, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        $value = $decoded;
                    } else {
                        $value = array_filter(array_map('trim', explode(',', $value)));
                    }
                } elseif (!is_array($value)) {
                    $value = $value ? [$value] : [];
                }

                $chips = '';
                foreach ($value as $v) {
                    $chips .= '<span class="badge rounded-pill bg-light text-dark border me-1 mb-1 px-3 py-2">' . e($v) . '</span>';
                }
                if ($chips === '') {
                    $chips = $placeholder;
                }

                $html .= '
                <li class="detail-item py-3">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="bi bi-' . $icon . ' text-muted"></i>
                        <span class="detail-label">' . $label . '</span>
                    </div>
                    <div class="detail-value d-flex flex-wrap">' . $chips . '</div>
                </li>';
                break;

            case 'image':
                // Handle different data formats
                $images = [];
                
                if (is_string($value)) {
                    // Try to decode JSON string
                    $decoded = json_decode($value, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        $images = $decoded;
                    }
                } elseif (is_array($value)) {
                    // Value is already an array
                    $images = $value;
                }
                
                if (!empty($images) && is_array($images)) {
                    $imageHtml = '<div class="image-gallery row g-2">';
                    foreach ($images as $image) {
                        // Handle both old format (string) and new format (array with metadata)
                        if (is_array($image)) {
                            $imagePath = $image['path'] ?? $image['url'] ?? '';
                            $originalName = $image['original_name'] ?? 'Image';
                        } else {
                            $imagePath = (string) $image;
                            $originalName = 'Image';
                        }
                        
                        // Ensure we have a valid path
                        if (!empty($imagePath) && is_string($imagePath)) {
                            $imageHtml .= '<div class="col-md-3 col-sm-4 col-6">
                                <div class="position-relative">
                                    <img src="' . asset($imagePath) . '" 
                                         class="img-thumbnail w-100" 
                                         style=" object-fit: cover; cursor: pointer;"
                                         onclick="window.open(\'' . asset($imagePath) . '\', \'_blank\')"
                                         title="Click to view full size">
                                    <div class="position-absolute top-0 end-0 p-1">
                                        <span class="badge bg-dark bg-opacity-75 small">' . 
                                        e(substr($originalName, 0, 10)) . '...' . 
                                        '</span>
                                    </div>
                                </div>
                            </div>';
                        }
                    }
                    $imageHtml .= '</div>';
                    $displayValue = $imageHtml;
                } else {
                    $displayValue = $placeholder;
                }

                $html .= '
                <li class="detail-item py-3">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="bi bi-images text-muted"></i>
                        <span class="detail-label">' . $label . '</span>
                    </div>
                    <div class="detail-value">' . $displayValue . '</div>
                </li>';
                break;
        }

        return $html;
    }
}

