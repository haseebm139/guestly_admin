<?php
if (!function_exists('renderField')) {
    function renderField($field, $value = null)
    {
        $html = '';

        $type = $field->type ?? 'text';
        $label = e($field->label ?? 'Field');
        $isRequired = !empty($field->is_required);

        // Stable id/name
        $fieldBase = \Illuminate\Support\Str::snake($field->label ?? 'field');
        $baseName = $fieldBase . '|' . ($field->id ?? \Illuminate\Support\Str::random(6)).'|'.$type;
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
        $helpText = property_exists($field, 'help_text') && $field->help_text ? '<div id="' . $helpId . '" class="form-text small text-muted">' . e($field->help_text) . '</div>' : '';

        switch ($type) {
            case 'email':
            case 'text':
                $html .= '
                <div class="col-md-6">
                    <div class="form-floating mb-4">
                        <input type="' . $type . '" class="form-control form-control-lg' . $invalidClass . '"
                               id="' . $inputId . '" name="' . $baseName . '"'
                               . $placeholderAttr . $requiredAttr . $minLength . $maxLength . $ariaInvalid . $ariaDescribedBy . '
                               value="' . e(is_array($oldValue) ? json_encode($oldValue) : (string)($oldValue ?? '')) . '">
                        <label for="' . $inputId . '">' . $label . $requiredMark . '</label>
                        ' . ($hasError ? '<div id="' . $errorId . '" class="invalid-feedback">' . e(is_array($firstError) ? json_encode($firstError) : (string)($firstError ?? '')) . '</div>' : $helpText) . '
                    </div>
                </div>';
                break;

            case 'date':
                $formatted = $oldValue ? \Carbon\Carbon::parse($oldValue)->format('Y-m-d') : '';
                $html .= '
                <div class="col-md-6">
                    <div class="form-floating mb-4">
                        <input type="date" class="form-control form-control-lg' . $invalidClass . '"
                               id="' . $inputId . '" name="' . $baseName . '"'
                               . $requiredAttr . $ariaInvalid . $ariaDescribedBy . '
                               value="' . e($formatted) . '">
                        <label for="' . $inputId . '">' . $label . $requiredMark . '</label>
                        ' . ($hasError ? '<div id="' . $errorId . '" class="invalid-feedback">' . e(is_array($firstError) ? json_encode($firstError) : (string)($firstError ?? '')) . '</div>' : $helpText) . '
                    </div>
                </div>';
                break;

            case 'datetime':
            case 'datetime_local':
                $formatted = $oldValue ? \Carbon\Carbon::parse($oldValue)->format('Y-m-d\TH:i') : '';
                $html .= '
                <div class="col-md-6">
                    <div class="form-floating mb-4">
                        <input type="datetime-local" class="form-control form-control-lg' . $invalidClass . '"
                               id="' . $inputId . '" name="' . $baseName . '"'
                               . $requiredAttr . $ariaInvalid . $ariaDescribedBy . '
                               value="' . e($formatted) . '">
                        <label for="' . $inputId . '">' . $label . $requiredMark . '</label>
                        ' . ($hasError ? '<div id="' . $errorId . '" class="invalid-feedback">' . e(is_array($firstError) ? json_encode($firstError) : (string)($firstError ?? '')) . '</div>' : $helpText) . '
                    </div>
                </div>';
                break;

            case 'textarea':
                $html .= '
                <div class="col-12">
                    <div class="form-floating mb-4">
                        <textarea class="form-control form-control-lg' . $invalidClass . '"
                                  id="' . $inputId . '" name="' . $baseName . '" style="height: 140px"'
                                  . $placeholderAttr . $requiredAttr . $minLength . $maxLength . $ariaInvalid . $ariaDescribedBy . '>'
                                  . e(is_array($oldValue) ? json_encode($oldValue) : (string)($oldValue ?? '')) . '</textarea>
                        <label for="' . $inputId . '">' . $label . $requiredMark . '</label>
                        ' . ($hasError ? '<div id="' . $errorId . '" class="invalid-feedback">' . e(is_array($firstError) ? json_encode($firstError) : (string)($firstError ?? '')) . '</div>' : $helpText) . '
                    </div>
                </div>';
                break;

            case 'dropdown':
            case 'multi_select':
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
                $selectClasses = 'form-select form-select-lg select2' . ($invalidClass ? ' is-invalid' : '');
                $placeholderText = $label;

                $html .= '
                <div class="col-12">
                    <div class="form-group mb-4">
                        <label class="form-label fw-semibold mb-2" for="' . $inputId . '">' . $label . $requiredMark . '</label>
                        <select class="' . $selectClasses . '" id="' . $inputId . '" name="' . $nameAttr . '"'
                            . $multipleAttr . $requiredAttr . $ariaInvalid . $ariaDescribedBy . ' data-placeholder="' . e($placeholderText) . '">';

                if (!$isMulti) {
                    $isSelected = empty($selectedValues[0]) ? ' selected' : '';
                    $html .= '<option value="" disabled ' . $isSelected . '>Choose an option...</option>';
                }

                foreach ($normalized as $opt) {
                    $isSelected = in_array((string)$opt['value'], $selectedValues, true) ? ' selected' : '';
                    $html .= '<option value="' . e($opt['value']) . '"' . $isSelected . '>' . e($opt['label']) . '</option>';
                }

                $html .= '</select>'
                        . ($hasError ? '<div id="' . $errorId . '" class="invalid-feedback d-block">' . e(is_array($firstError) ? json_encode($firstError) : (string)($firstError ?? '')) . '</div>' : $helpText) . '
                    </div>
                </div>';
                break;

            case 'image':
                $maxFiles = (int)($field->max_files ?? 8);
                $maxSizeMb = (int)($field->max_size_mb ?? 5);
                $accept = 'image/*';
                $nameAttr = $baseName . '[]';

                $html .= '
                <div class="col-12">
                    <div class="form-group mb-4">
                        <label class="form-label fw-semibold mb-2" for="' . $inputId . '">' . $label . $requiredMark . '</label>
                        <div class="image-dropzone" data-target-input="' . $inputId . '" data-max-files="' . $maxFiles . '" data-max-size-mb="' . $maxSizeMb . '">
                            <div class="dropzone-content">
                                <i class="bi bi-cloud-upload fs-1 text-muted mb-3"></i>
                                <h5 class="mb-2">Drag & drop images here</h5>
                                <p class="text-muted mb-3">or <span class="text-primary fw-semibold">click to browse</span></p>
                                <div class="upload-info">
                                    <small class="text-muted">Up to ' . $maxFiles . ' images, ' . $maxSizeMb . 'MB each</small>
                                </div>
                            </div>
                        </div>
                        <input type="file" class="d-none"
                               id="' . $inputId . '" name="' . $nameAttr . '" accept="' . $accept . '" multiple' . $requiredAttr . '>
                        <div class="image-previews mt-3" id="' . $inputId . '-previews"></div>
                        ' . ($hasError ? '<div id="' . $errorId . '" class="invalid-feedback d-block">' . e(is_array($firstError) ? json_encode($firstError) : (string)($firstError ?? '')) . '</div>' : $helpText) . '
                    </div>
                </div>';
                break;
        }

        return $html;
    }
}
