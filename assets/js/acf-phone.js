(function ($) {

  /**
   * Initialize ACF Phone field
   * @param $field
   */
  function initialize_field ($field) {
    $field.find('input[type=tel]').intlTelInput({
      utilsScript: options.utilsScriptUrl,
    });
  }

  if (typeof acf.add_action !== 'undefined') {
    acf.add_action('ready_field/type=phone', initialize_field);
    acf.add_action('append_field/type=phone', initialize_field);
  }

})(jQuery);
