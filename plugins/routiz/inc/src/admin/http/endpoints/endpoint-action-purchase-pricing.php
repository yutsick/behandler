<?php

namespace Routiz\Inc\Src\Admin\Http\Endpoints;

use \Routiz\Inc\Src\Request\Request;
use \Routiz\Inc\Src\Validation;
use \Routiz\Inc\Src\Listing\Listing;
use \Routiz\Inc\Src\Form\Component as Form;

if ( ! defined('ABSPATH') ) {
	exit;
}

class Endpoint_Action_Purchase_Pricing extends Endpoint {

	public $action = 'rz_action_purchase_pricing';

    public function action() {

		$request = Request::instance();

		if( ! $request->is_empty('listing_id') ) {

			$listing = new Listing( $request->get('listing_id') );

			if( $listing->id ) {

				wp_send_json([
					'success' => true,
					'html' => Rz()->get_template('routiz/single/pricing-purchase')
				]);

			}

		}

		wp_send_json([
			'success' => false
		]);

		wp_send_json( $response );

	}

}
