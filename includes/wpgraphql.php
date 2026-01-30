<?php

add_action( 'graphql_register_types', 'acf_phone_register_graphql_type' );
function acf_phone_register_graphql_type() {
		register_graphql_object_type(
			'AcfPhone',
			array(
				'description' => "ACF Phone field",
				'fields'      => array(
					'national'  => array(
						'type'        => array( 'non_null' => 'String' ),
						'description' => 'The phone number in national format',
					),
					'e164'      => array(
						'type'        => array( 'non_null' => 'String' ),
						'description' => 'The phone number in E.164 format',
					),
					'country'   => array(
						'type'        => array( 'non_null' => 'String' ),
						'description' => 'The country code associated with the phone number',
					),
					'extension' => array(
						'type'        => 'String',
						'description' => 'The phone number extension, if any',
					),
				),
			)
		);
}

add_action( 'wpgraphql/acf/registry_init', 'acf_phone_register_graphql_field' );
function acf_phone_register_graphql_field() {
	register_graphql_acf_field_type(
		'phone',
		array(
			'graphql_type' => static function () {
				return 'AcfPhone';
			},
			'resolve'      => static function ( $root, $args, $context, $info, $field_type, $field_config ) {
				$value = $field_config->resolve_field( $root, $args, $context, $info );
				if ( empty( $value ) ) {
					return null;
				}
				return $value;
			},
		)
	);
}
