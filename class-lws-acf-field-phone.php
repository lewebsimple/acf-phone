<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class lws_acf_field_phone extends \acf_field {
	/**
	 * Controls field type visibilty in REST requests.
	 *
	 * @var bool
	 */
	public $show_in_rest = true;

	/**
	 * Environment values relating to the theme or plugin.
	 *
	 * @var array $env Plugin or theme context such as 'url' and 'version'.
	 */
	private $env;

	private $countries = array(
		'AF' => 'Afghanistan',
		'AX' => 'Aland Islands',
		'AL' => 'Albania',
		'DZ' => 'Algeria',
		'AS' => 'American Samoa',
		'AD' => 'Andorra',
		'AO' => 'Angola',
		'AI' => 'Anguilla',
		'AQ' => 'Antarctica',
		'AG' => 'Antigua And Barbuda',
		'AR' => 'Argentina',
		'AM' => 'Armenia',
		'AW' => 'Aruba',
		'AU' => 'Australia',
		'AT' => 'Austria',
		'AZ' => 'Azerbaijan',
		'BS' => 'Bahamas',
		'BH' => 'Bahrain',
		'BD' => 'Bangladesh',
		'BB' => 'Barbados',
		'BY' => 'Belarus',
		'BE' => 'Belgium',
		'BZ' => 'Belize',
		'BJ' => 'Benin',
		'BM' => 'Bermuda',
		'BT' => 'Bhutan',
		'BO' => 'Bolivia',
		'BA' => 'Bosnia And Herzegovina',
		'BW' => 'Botswana',
		'BV' => 'Bouvet Island',
		'BR' => 'Brazil',
		'IO' => 'British Indian Ocean Territory',
		'BN' => 'Brunei Darussalam',
		'BG' => 'Bulgaria',
		'BF' => 'Burkina Faso',
		'BI' => 'Burundi',
		'KH' => 'Cambodia',
		'CM' => 'Cameroon',
		'CA' => 'Canada',
		'CV' => 'Cape Verde',
		'KY' => 'Cayman Islands',
		'CF' => 'Central African Republic',
		'TD' => 'Chad',
		'CL' => 'Chile',
		'CN' => 'China',
		'CX' => 'Christmas Island',
		'CC' => 'Cocos (Keeling) Islands',
		'CO' => 'Colombia',
		'KM' => 'Comoros',
		'CG' => 'Congo',
		'CD' => 'Congo, Democratic Republic',
		'CK' => 'Cook Islands',
		'CR' => 'Costa Rica',
		'CI' => 'Cote D\'Ivoire',
		'HR' => 'Croatia',
		'CU' => 'Cuba',
		'CY' => 'Cyprus',
		'CZ' => 'Czech Republic',
		'DK' => 'Denmark',
		'DJ' => 'Djibouti',
		'DM' => 'Dominica',
		'DO' => 'Dominican Republic',
		'EC' => 'Ecuador',
		'EG' => 'Egypt',
		'SV' => 'El Salvador',
		'GQ' => 'Equatorial Guinea',
		'ER' => 'Eritrea',
		'EE' => 'Estonia',
		'ET' => 'Ethiopia',
		'FK' => 'Falkland Islands (Malvinas)',
		'FO' => 'Faroe Islands',
		'FJ' => 'Fiji',
		'FI' => 'Finland',
		'FR' => 'France',
		'GF' => 'French Guiana',
		'PF' => 'French Polynesia',
		'TF' => 'French Southern Territories',
		'GA' => 'Gabon',
		'GM' => 'Gambia',
		'GE' => 'Georgia',
		'DE' => 'Germany',
		'GH' => 'Ghana',
		'GI' => 'Gibraltar',
		'GR' => 'Greece',
		'GL' => 'Greenland',
		'GD' => 'Grenada',
		'GP' => 'Guadeloupe',
		'GU' => 'Guam',
		'GT' => 'Guatemala',
		'GG' => 'Guernsey',
		'GN' => 'Guinea',
		'GW' => 'Guinea-Bissau',
		'GY' => 'Guyana',
		'HT' => 'Haiti',
		'HM' => 'Heard Island & Mcdonald Islands',
		'VA' => 'Holy See (Vatican City State)',
		'HN' => 'Honduras',
		'HK' => 'Hong Kong',
		'HU' => 'Hungary',
		'IS' => 'Iceland',
		'IN' => 'India',
		'ID' => 'Indonesia',
		'IR' => 'Iran, Islamic Republic Of',
		'IQ' => 'Iraq',
		'IE' => 'Ireland',
		'IM' => 'Isle Of Man',
		'IL' => 'Israel',
		'IT' => 'Italy',
		'JM' => 'Jamaica',
		'JP' => 'Japan',
		'JE' => 'Jersey',
		'JO' => 'Jordan',
		'KZ' => 'Kazakhstan',
		'KE' => 'Kenya',
		'KI' => 'Kiribati',
		'KR' => 'Korea',
		'KW' => 'Kuwait',
		'KG' => 'Kyrgyzstan',
		'LA' => 'Lao People\'s Democratic Republic',
		'LV' => 'Latvia',
		'LB' => 'Lebanon',
		'LS' => 'Lesotho',
		'LR' => 'Liberia',
		'LY' => 'Libyan Arab Jamahiriya',
		'LI' => 'Liechtenstein',
		'LT' => 'Lithuania',
		'LU' => 'Luxembourg',
		'MO' => 'Macao',
		'MK' => 'Macedonia',
		'MG' => 'Madagascar',
		'MW' => 'Malawi',
		'MY' => 'Malaysia',
		'MV' => 'Maldives',
		'ML' => 'Mali',
		'MT' => 'Malta',
		'MH' => 'Marshall Islands',
		'MQ' => 'Martinique',
		'MR' => 'Mauritania',
		'MU' => 'Mauritius',
		'YT' => 'Mayotte',
		'MX' => 'Mexico',
		'FM' => 'Micronesia, Federated States Of',
		'MD' => 'Moldova',
		'MC' => 'Monaco',
		'MN' => 'Mongolia',
		'ME' => 'Montenegro',
		'MS' => 'Montserrat',
		'MA' => 'Morocco',
		'MZ' => 'Mozambique',
		'MM' => 'Myanmar',
		'NA' => 'Namibia',
		'NR' => 'Nauru',
		'NP' => 'Nepal',
		'NL' => 'Netherlands',
		'AN' => 'Netherlands Antilles',
		'NC' => 'New Caledonia',
		'NZ' => 'New Zealand',
		'NI' => 'Nicaragua',
		'NE' => 'Niger',
		'NG' => 'Nigeria',
		'NU' => 'Niue',
		'NF' => 'Norfolk Island',
		'MP' => 'Northern Mariana Islands',
		'NO' => 'Norway',
		'OM' => 'Oman',
		'PK' => 'Pakistan',
		'PW' => 'Palau',
		'PS' => 'Palestinian Territory, Occupied',
		'PA' => 'Panama',
		'PG' => 'Papua New Guinea',
		'PY' => 'Paraguay',
		'PE' => 'Peru',
		'PH' => 'Philippines',
		'PN' => 'Pitcairn',
		'PL' => 'Poland',
		'PT' => 'Portugal',
		'PR' => 'Puerto Rico',
		'QA' => 'Qatar',
		'RE' => 'Reunion',
		'RO' => 'Romania',
		'RU' => 'Russian Federation',
		'RW' => 'Rwanda',
		'BL' => 'Saint Barthelemy',
		'SH' => 'Saint Helena',
		'KN' => 'Saint Kitts And Nevis',
		'LC' => 'Saint Lucia',
		'MF' => 'Saint Martin',
		'PM' => 'Saint Pierre And Miquelon',
		'VC' => 'Saint Vincent And Grenadines',
		'WS' => 'Samoa',
		'SM' => 'San Marino',
		'ST' => 'Sao Tome And Principe',
		'SA' => 'Saudi Arabia',
		'SN' => 'Senegal',
		'RS' => 'Serbia',
		'SC' => 'Seychelles',
		'SL' => 'Sierra Leone',
		'SG' => 'Singapore',
		'SK' => 'Slovakia',
		'SI' => 'Slovenia',
		'SB' => 'Solomon Islands',
		'SO' => 'Somalia',
		'ZA' => 'South Africa',
		'GS' => 'South Georgia And Sandwich Isl.',
		'ES' => 'Spain',
		'LK' => 'Sri Lanka',
		'SD' => 'Sudan',
		'SR' => 'Suriname',
		'SJ' => 'Svalbard And Jan Mayen',
		'SZ' => 'Swaziland',
		'SE' => 'Sweden',
		'CH' => 'Switzerland',
		'SY' => 'Syrian Arab Republic',
		'TW' => 'Taiwan',
		'TJ' => 'Tajikistan',
		'TZ' => 'Tanzania',
		'TH' => 'Thailand',
		'TL' => 'Timor-Leste',
		'TG' => 'Togo',
		'TK' => 'Tokelau',
		'TO' => 'Tonga',
		'TT' => 'Trinidad And Tobago',
		'TN' => 'Tunisia',
		'TR' => 'Turkey',
		'TM' => 'Turkmenistan',
		'TC' => 'Turks And Caicos Islands',
		'TV' => 'Tuvalu',
		'UG' => 'Uganda',
		'UA' => 'Ukraine',
		'AE' => 'United Arab Emirates',
		'GB' => 'United Kingdom',
		'US' => 'United States',
		'UM' => 'United States Outlying Islands',
		'UY' => 'Uruguay',
		'UZ' => 'Uzbekistan',
		'VU' => 'Vanuatu',
		'VE' => 'Venezuela',
		'VN' => 'Viet Nam',
		'VG' => 'Virgin Islands, British',
		'VI' => 'Virgin Islands, U.S.',
		'WF' => 'Wallis And Futuna',
		'EH' => 'Western Sahara',
		'YE' => 'Yemen',
		'ZM' => 'Zambia',
		'ZW' => 'Zimbabwe',
	);

	/**
	 * Constructor.
	 */
	public function __construct() {
		/**
		 * Field type reference used in PHP and JS code.
		 * No spaces. Underscores allowed.
		 */
		$this->name = 'phone';

		/**
		 * Field type label.
		 */
		$this->label = __( 'Phone', 'acf-phone' );

		/**
		 * The category the field appears within in the field type picker.
		 */
		$this->category = 'basic'; // basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME

		/**
		 * Field type Description.
		 */
		$this->description = __( 'Phone field for ACF', 'acf-phone' );

		/**
		 * Field type Doc URL.
		 *
		 * For linking to a documentation page. Displayed in the field picker modal.
		 */
		$this->doc_url = '';

		/**
		 * Field type Tutorial URL.
		 *
		 * For linking to a tutorial resource. Displayed in the field picker modal.
		 */
		$this->tutorial_url = '';

		/**
		 * Defaults for your custom user-facing settings for this field type.
		 */
		$this->defaults = array(
			'initial_country' => 'CA',
			'return_format'   => 'national',
		);

		/**
		 * Strings used in JavaScript code.
		 *
		 * Allows JS strings to be translated in PHP and loaded in JS via:
		 *
		 * ```js
		 * const errorMessage = acf._e("phone", "error");
		 * ```
		 */
		$this->l10n = array(
			'errorMap' => array(
				0 => __( "Invalid phone number", 'acf-phone' ),
				1 => __( "Invalid country code", 'acf-phone' ),
				2 => __( "Phone number too short", 'acf-phone' ),
				3 => __( "Phone number too long", 'acf-phone' ),
				4 => __( "Missing region code", 'acf-phone' ),
				5 => __( "Invalid phone number length", 'acf-phone' ),
			),
		);

		$this->env = array(
			'url'     => site_url( str_replace( ABSPATH, '', __DIR__ ) ),
			'version' => '2.0.4',
		);

		parent::__construct();
	}

	/**
	 * Settings to display when users configure a field of this type.
	 *
	 * These settings appear on the ACF “Edit Field Group” admin page when
	 * setting up the field.
	 *
	 * @param array $field
	 * @return void
	 */
	public function render_field_settings( $field ) {
		// Default country
		acf_render_field_setting(
			$field,
			array(
				'label'        => __( 'Initial country', 'acf-phone' ),
				'instructions' => __( 'Specify the initial country selected by default', 'acf-phone' ),
				'type'         => 'select',
				'name'         => 'initial_country',
				'choices'      => $this->countries,
			)
		);
		// Return format
		acf_render_field_setting(
			$field,
			array(
				'label'        => __( 'Return format', 'acf-phone' ),
				'instructions' => __( 'Specify the return format used in the templates', 'acf-phone' ),
				'type'         => 'select',
				'name'         => 'return_format',
				'choices'      => array(
					'national'    => __( "National format", 'acf-phone' ),
					'e164'        => __( "International format (E.164)", 'acf-phone' ),
					'clicktocall' => __( "Click to Call", 'acf-phone' ),
					'array'       => __( "Values (array)", 'acf-phone' ),
				),
			)
		);
	}

	/**
	 * HTML content to show when a publisher edits the field on the edit screen.
	 *
	 * @param array $field The field settings and values.
	 * @return void
	 */
	public function render_field( $field ) {
		$value = wp_parse_args(
			$field['value'],
			array(
				'national'  => '',
				'country'   => $field['initial_country'] ?? 'CA',
				'e164'      => '',
				'extension' => '',
			)
		);
		?>
		<div class="acf-input-wrap acf-phone">
			<input type="tel" name="<?= $field['name'] ?>[national]" value="<?= $value['national']; ?>"/>
			<input type="hidden" name="<?= $field['name'] ?>[country]" value="<?= $value['country']; ?>"/>
			<input type="hidden" name="<?= $field['name'] ?>[e164]" value="<?= $value['e164']; ?>"/>
			<input type="hidden" name="<?= $field['name'] ?>[extension]" value="<?= $value['extension']; ?>"/>
			<div class="acf-phone-error"></div>
		</div>
		<?php
	}

	/**
	 * Enqueues CSS and JavaScript needed by HTML in the render_field() method.
	 *
	 * Callback for admin_enqueue_script.
	 *
	 * @return void
	 */
	public function input_admin_enqueue_scripts() {
		$url     = trailingslashit( $this->env['url'] );
		$version = $this->env['version'];

		wp_register_style( 'intl-tel-input', "{$url}assets/css/intlTelInput.min.css", array(), $version );
		wp_register_style( 'acf-phone', "{$url}assets/css/acf-phone.css", array( 'intl-tel-input' ), $version );
		wp_enqueue_style( 'acf-phone' );

		wp_register_script( 'intl-tel-input', "{$url}assets/js/intlTelInput.min.js", array( 'jquery' ), $version );
		wp_register_script( 'acf-phone', "{$url}assets/js/acf-phone.js", array( 'acf-input', 'intl-tel-input' ), $version );
		wp_enqueue_script( 'acf-phone' );
		$intl_tel_input_options = apply_filters(
			'acf-phone/intl-tel-input-options',
			array(
				'utilsScript' => "{$url}assets/js/utils.js",
			)
		);
		wp_localize_script( 'acf-phone', 'intlTelInputOptions', $intl_tel_input_options );
	}

	/**
	 * Validate phone value
	 *
	 * @param $valid (boolean) validation status based on the value and the field's required setting
	 * @param value (mixed) the                                                                     $_POST value
	 * @param $field (array) the field array holding all the field options
	 * @param input (string) the corresponding input name for                                       $_POST value
	 *
	 * @return mixed
	 */
	function validate_value( $valid, $value, $field, $input ) {
		if ( empty( $value['national'] ) ) {
			if ( $field['required'] ) {
				$valid = __( 'This field is required', 'acf-phone' );
			}
		} elseif ( empty( $value['e164'] ) ) {
			return __( "Invalid phone number", 'acf-phone' );
		}
		return $valid;
	}

	/**
	 * Update value to database
	 *
	 * @param  $value (mixed) the value found in the database
	 * @param  post_id (mixed) the                                         $post_id from which the value was loaded
	 * @param  $field (array) the field array holding all the field options
	 *
	 * @return $value
	 */
	function update_value( $value, $post_id, $field ) {
		// Strip extension from national number
		$value['national'] = preg_replace( '/(.*) ext.*/i', '${1}', $value['national'] ?? '' );
		// Remove parentheses for CA / US numbers
		if ( in_array( $value['country'] ?? '', array( 'CA', 'US' ) ) ) {
			$value['national'] = preg_replace( '/\(|\)/', '', $value['national'] );
		}
		return $value;
	}

	/**
	 * Format full name value according to field settings
	 *
	 * @param  $value (mixed) the value which was loaded from the database
	 * @param  post_id (mixed) the                                         $post_id from which the value was loaded
	 * @param  $field (array) the field array holding all the field options
	 *
	 * @return $value (mixed) the formatted value
	 */
	function format_value( $value, $post_id, $field ) {
		return acf_phone_plugin::format_value( $value, $field['return_format'] ?? 'national' );
	}
}
