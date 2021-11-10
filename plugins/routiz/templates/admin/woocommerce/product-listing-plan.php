<?php global $post; ?>

<div class="options_group show_if_listing_plan">

	<?php

		woocommerce_wp_text_input([
			'id' => '_rz_plan_duration',
			'label' => __( 'Duration', 'routiz' ),
			'description' => __( 'The number of days of the listing to be active. Leave empty for unlimited duration.', 'routiz' ),
			'placeholder' => __( 'Never expires', 'routiz' ),
			'value' => get_post_meta( $post->ID, '_rz_plan_duration', true ),
			'desc_tip' => true,
			'type' => 'number',
			'custom_attributes' => [
				'min' => '',
				'step' => '1',
			],
		]);

        woocommerce_wp_text_input([
    		'id' => '_rz_plan_limit',
    		'label' => __( 'Limit', 'routiz' ),
    		'description' => __( 'The number of listings that a customer can submit with this plan. Leave empty for unlimited.', 'routiz' ),
    		'placeholder' => __( 'Unlimited', 'routiz' ),
    		'value' => ( $limit = (int) get_post_meta( $post->ID, '_rz_plan_limit', true ) ) ? $limit : '',
    		'type' => 'number',
    		'desc_tip' => true,
    		'custom_attributes' => [
        		'min' => 0,
        		'step' => 1,
            ],
    	]);

    	woocommerce_wp_text_input([
    		'id' => '_rz_plan_priority',
    		'label' => __( 'Priority?', 'routiz' ),
    		'description' => __( 'Add additional priority ( boost visibility ) on the listings submitted with this plan. Higher value means higher priority in search results. Normal = 0, Featured = 1, Promoted = 2 and so on.', 'routiz' ),
			'placeholder' => __( 'Normal', 'routiz' ),
			'value' => ( $priority = (int) get_post_meta( $post->ID, '_rz_plan_priority', true ) ) ? $priority : '',
			'type' => 'number',
			'desc_tip' => true,
			'custom_attributes' => [
        		'min' => 0,
        		'step' => 1,
            ],
    	]);

    	woocommerce_wp_checkbox([
    		'id' => '_rz_plan_disable_repeat_purchase',
    		'label' => __( 'One time obtainable?', 'routiz' ),
    		'description' => __( 'Use for free plans, so customers cannot have more than one of these.', 'routiz' ),
    		'value' => get_post_meta( $post->ID, '_rz_plan_disable_repeat_purchase', true ),
    	]);

    ?>

	<script type="text/javascript">
		jQuery(function(){
			jQuery('#product-type').change( function() {
				jQuery('#woocommerce-product-data').removeClass(function(i, classNames) {
					var classNames = classNames.match(/is\_[a-zA-Z\_]+/g);
					if ( ! classNames ) {
						return '';
					}
					return classNames.join(' ');
				});
				jQuery('#woocommerce-product-data').addClass( 'is_' + jQuery(this).val() );
			} );
			jQuery('.pricing').addClass( 'show_if_listing_plan' );
			jQuery('#product-type').change();
		});
	</script>

</div>
