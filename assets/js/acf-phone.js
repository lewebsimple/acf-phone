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
  }

  if (typeof acf.add_action !== 'undefined') {
    acf.add_action('ready_field/type=phone', initialize_field);
    acf.add_action('append_field/type=phone', initialize_field);
  }

})(jQuery);
