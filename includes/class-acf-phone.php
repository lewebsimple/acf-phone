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
	public static function format_value( array $value, string $format ) {
		if ( ! is_array( $value ) || empty( $value['national'] ) || empty( $value['e164'] ) ) {
			return '';
		}
		$ext      = $value['extension'] ?? '';
		$national = $value['national'] . ( $ext ? " ext. $ext" : '' );
		switch ( $format ) {
			case 'national':
				return $national;

			case 'e164':
				return $value['e164'];

			case 'clicktocall':
				return sprintf( '<a href="tel:%s">%s</a>', esc_attr( $value['e164'] ), esc_html( $national ) );

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
	public static function encode_value( string $value ) {
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
