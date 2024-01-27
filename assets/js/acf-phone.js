(function ($) {

  /**
   * Initialize ACF Phone field
   * @param $field
   */
  function initialize_field($field) {
    // ACF phone input fields
    const $error = $field.find('.acf-phone-error');
    const fields = {
      $national: $field.find('input[name*=national]'),
      $country: $field.find('input[name*=country]'),
      $e164: $field.find('input[name*=e164]'),
      $extension: $field.find('input[name*=extension]'),
    }

    // Add extension to national input value
    if (fields.$extension.val() && !/ext/.test(fields.$national.val())) {
      fields.$national.val(`${fields.$national.val()} ext.${fields.$extension.val()}`);
    }

    // Initialize intlTelInput
    const initialCountry = fields.$country.val().toLowerCase() || 'ca';
    const iti = window.intlTelInput(fields.$national[0], {
      ...intlTelInputOptions,
      initialCountry,
      preferredCountries: ['ca', 'us'],
    })

    // Reset hidden fields
    function reset() {
      $error.text('');
      fields.$country.val(initialCountry);
      fields.$e164.val('');
      fields.$extension.val('');
    }

    // Validate phone number with intlTelInput and set hidden fields
    function validate() {
      reset();
      if (fields.$national.val().trim()) {
        if (iti.isValidNumber()) {
          fields.$national.val(iti.getNumber(intlTelInputUtils.numberFormat.NATIONAL))
          fields.$country.val(iti.getSelectedCountryData().iso2.toUpperCase());
          fields.$e164.val(iti.getNumber(intlTelInputUtils.numberFormat.E164));
          fields.$extension.val(iti.getExtension());
        } else {
          $error.text(acf.l10n.phone.errorMap[iti.getValidationError()] || '');
        }
      }
    }

    // Perform validation initially, on blur and enter keyup
    validate();
    fields.$national.on('blur', validate);
    fields.$national.on('keyup', ({ keyCode }) => {
      (keyCode === 13) && validate();
    })
  }

  // Initialization hooks
  if (typeof acf.add_action !== 'undefined') {
    acf.add_action('ready_field/type=phone', initialize_field);
    acf.add_action('append_field/type=phone', initialize_field);
  }

})(jQuery);
