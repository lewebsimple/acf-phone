(function ($) {

  /**
   * Initialize ACF Phone field
   * @param $field
   */
  function initialize_field ($field) {
    let $national = $field.find('input[type=tel]'),
      $country = $field.find('input.country'),
      $e164 = $field.find('input.e164');

    // Initialize intl-tel-input
    $national.intlTelInput({
      utilsScript: options.utilsScriptUrl,
    });

    // Validate phone number
    function validate () {
      if ($national.val()) {
        if ($national.intlTelInput('isValidNumber')) {
          // Update field values with normalized phone number
          $national.val($national.intlTelInput('getNumber', intlTelInputUtils.numberFormat.NATIONAL));
          $country.val($national.intlTelInput('getSelectedCountryData').iso2.toUpperCase());
          $e164.val($national.intlTelInput('getNumber', intlTelInputUtils.numberFormat.E164));
        } else {
          // TODO: Display validation error on the frontend
          console.log(options.errors[$national.intlTelInput('getValidationError')]);
        }
      }
    }

    $national.on('blur', function () {
      validate();
    });
  }

  if (typeof acf.add_action !== 'undefined') {
    acf.add_action('ready_field/type=phone', initialize_field);
    acf.add_action('append_field/type=phone', initialize_field);
  }

})(jQuery);
