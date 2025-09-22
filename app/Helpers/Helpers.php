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

if (!function_exists('renderField')) {
    function renderField($field, $value = null,  )
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


