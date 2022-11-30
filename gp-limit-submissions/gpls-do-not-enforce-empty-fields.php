<?php
/**
 * Gravity Perks // Limit Submissions // Do Not Enforce Empty Fields
 * https://gravitywiz.com/documentation/gravity-forms-limit-submissions/
 *
 * By default, Limit Submissions will attempt to enforce field-based limits even if the field is empty. This snippet
 * modifies that behavior to ensure that field-based limits are not enforced on render if all fields in the failed
 * ruleset do not have a value.
 *
 * Note: This may not work with multi-page forms.
 */
// Update "123" to your form ID or remove "_123" to apply this functionality to all forms.
add_filter( 'gpls_should_enforce_on_render_123', function( $should_enforce, $form, $field_values, $gpls_enforce ) {

	$failed_rule_group = $gpls_enforce->get_test_result()->failed_rule_group;
	if ( ! $failed_rule_group ) {
		return $should_enforce;
	}

	foreach ( $failed_rule_group->get_rulesets() as $ruleset ) {
		foreach ( $ruleset as $rule ) {
			$field       = GFAPI::get_field( $form, $rule->get_field() );
			$field_value = GFFormsModel::get_field_value( $field, $field_values );
			if ( rgblank( $field_value ) ) {
				return false;
			}
		}
	}

	return $should_enforce;
}, 10, 4 );
