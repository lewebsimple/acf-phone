<?php

/**
 * ACF Phone public API
 */
class AcfPhone {

	/**
	 * Helper for displaying acf-phone field value in different formats
	 *
	 * @param array  $value the raw phone value.
	 * @param string $format the desired format.
	 *
	 * @return mixed the formatted value
	 */
	public static function format_value( $value, $format ) {
		if ( ! is_array( $value ) || empty( $value['national'] ) || empty( $value['e164'] ) ) {
			return '';
		}
		$national = $value['national'] . ( $value['extension'] ? ' ext. ' . $value['extension'] : '' );
		switch ( $format ) {
			case 'national':
				return $national;

			case 'e164':
				return $value['e164'];

			case 'clicktocall':
				return '<a href="tel:' . $value['e164'] . '">' . $national . '</a>';

			case 'array':
			default:
				return $value;
		}
	}

	/**
	 * Helper for encoding acf-phone field value from string.
	 *
	 * @param string $value the raw phone value.
	 *
	 * @return array|bool
	 */
	public static function encode_value( $value ) {
		if ( empty( $value ) ) {
			return false;
		}
		$value = preg_replace( '/[^0-9]/', '', $value );
		if ( strlen( $value ) !== 10 ) {
			return false;
		}
		$number = array(
			substr( $value, 0, 3 ),
			substr( $value, 3, 3 ),
			substr( $value, 6, 4 ),
		);
		return array(
			'national'  => "({$number[0]}) {$number[1]}-{$number[2]}",
			'country'   => 'CA',
			'e164'      => "+1{$value}",
			'extension' => '',
		);
	}
}
