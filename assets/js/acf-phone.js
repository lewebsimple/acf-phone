(function ($) {

  /**
   * Initialize ACF Phone field
   * @param $field
   */
  function initialize_field ($field) {
    // Input fields and error div
    let $national = $field.find('input[type=tel]'),
      $country = $field.find('input.country'),
      $e164 = $field.find('input.e164'),
      $ext = $field.find('input.ext'),
      $error = $field.find('.acf-phone-error');

    // Dynamically add "ext. #" to national input value
    if ($ext.val() !== '') {
      $national.val($national.val() + ` ext. ${$ext.val()}`);
    }

    // Initialize intl-tel-input
    const intlTelInputArgs = {
      customPlaceholder: function (placeholder, countryData) {
        return placeholder.replace(/[0-9]/g, '#');
      },
      initialCountry: $country.val() || options.initialCountry || 'CA',
      preferredCountries: options.preferredCountries || ['CA', 'US'],
      utilsScript: options.utilsScriptUrl,
    };
    $national.intlTelInput(intlTelInputArgs);

    // Reset phone number input
    function reset () {
      $country.val(intlTelInputArgs.initialCountry);
      $e164.val('');
      $ext.val('');
      $error.text('');
    }

    $national.on('keyup change', reset);

    // Validate phone number from national input value
    function validate () {
      reset();
      if ($national.val()) {
        if ($national.intlTelInput('isValidNumber')) {
          // Determine ACF field value from intl-tel-input
          const value = {
            national: $national.intlTelInput('getNumber', intlTelInputUtils.numberFormat.NATIONAL),
            country: $national.intlTelInput('getSelectedCountryData').iso2.toUpperCase(),
            e164: $national.intlTelInput('getNumber', intlTelInputUtils.numberFormat.E164),
            ext: $national.intlTelInput('getExtension'),
          };

          // Update field values with normalized phone number
          $national.val(value.national);
          $country.val(value.country);
          $e164.val(value.e164);
          $ext.val(value.ext);
        } else {
          $error.text(options.errors[$national.intlTelInput('getValidationError')]);
        }
      }
    }

    validate();
    $national.blur(validate);
  }

  // Initialization hooks
  acf.add_action('ready_field/type=phone', initialize_field);
  acf.add_action('append_field/type=phone', initialize_field);

  // Validation hooks
  acf.add_filter('validation_complete', function (json, $form) {
    let $national = $form.find('input[type=tel]'),
      $error = $form.find('.acf-phone-error');

    if ($error.text() !== '') {
      // Inject intl-tel-input validation errors in ACF json
      const phoneError = {
        input: $national.attr('name'),
        message: $error.text(),
      };
      if (json.valid) {
        json.errors = [phoneError];
        json.valid = false;
      } else {
        json.errors.push(phoneError);
      }
    }

    return json;
  });

})
(jQuery);
