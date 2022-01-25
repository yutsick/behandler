<?php 

use \Routiz\Inc\Src\Request\Request;
use \Routiz\Inc\Src\Listing\Listing;
use \Routiz\Inc\Src\Listing\Appointments;


$request = \Routiz\Inc\Src\Request\Request::instance();
// $listing = new \Routiz\Inc\Src\Listing\Listing( $request->get('listing_id') );
$listing = new \Routiz\Inc\Src\Listing\Listing( 3645 );
$action = $listing->type->get_action('booking_appointments');

$rz_listing = new Listing( 3645 );
$appointments = new Appointments( $rz_listing );
$rz_upcoming = $appointments->get( $checkin_date, null, 1, $request->get('guests'), $request->get('addons') );
global $rz_upcoming;
global $rz_listing;

?>

<span class="rz-overlay"></span>       
<div class="rz-modal rz-modal-ready rz-booking_modal" data-id="booking_modal">
  <a href="#" class="rz-close">
    <i class="fas fa-times"></i>
  </a>
  <div class="rz-modal-content">
    <div class="rz-modal-container " id="booking_modal">
      <div class="rz--heading">
        <div class="rz--col-heading">
          <h4 class="rz--title rz-ellipsis">
              TEST
          </h4>
        </div>
        <div class="rz--col-close">
          <a href="#" class="rz-close" data-action="toggle-mobile-action">
              <i class="fas fa-times"></i>
          </a>
        </div>
      </div>

    <?php include_once('appointments.php'); ?>

    </div>
  </div>
</div>
