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
      $extension = $field.find('input.extension'),
      $error = $field.find('.acf-phone-error');

    // Dynamically add "ext. #" to national input value
    if ($extension.val() !== '' && !/ext/.test($national.val())) {
      $national.val($national.val() + ' ext.' + $extension.val());
    }

    // Initial options for intl-tel-input
    const intlTelInputOptions = {
      customPlaceholder: function (placeholder, countryData) {
        return placeholder.replace(/[0-9]/g, '#');
      },
      initialCountry: $country.val() || acfPhoneOptions.initialCountry || 'CA',
      preferredCountries: acfPhoneOptions.preferredCountries || ['CA', 'US'],
    };
    $national.intlTelInput(intlTelInputOptions);

    // Reset phone number input
    function reset () {
      $country.val(intlTelInputOptions.initialCountry);
      $e164.val('');
      $extension.val('');
      $error.text('');
    }

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
            extension: $national.intlTelInput('getExtension'),
          };

          // Update field values with normalized phone number
          $national.val(value.national);
          $country.val(value.country);
          $e164.val(value.e164);
          $extension.val(value.extension);
        } else {
          $error.text(acfPhoneOptions.errors[$national.intlTelInput('getValidationError')]);
        }
      }
    }

    validate();
    $national.blur(validate);
    $national.on('keydown', function (e) {
      if (e.which === 13) {
        validate();
      }
    });
  }

  // Initialization hooks
  acf.add_action('ready_field/type=phone', initialize_field);
  acf.add_action('append_field/type=phone', initialize_field);

  // Validation hooks
  acf.add_filter('validation_complete', function (json, $form) {
    $form.find('.acf-input-wrap.acf-phone').each(function () {
      let $national = $(this).find('input[type=tel]'),
        $error = $(this).find('.acf-phone-error');

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
    });

    return json;
  });

})(jQuery);
