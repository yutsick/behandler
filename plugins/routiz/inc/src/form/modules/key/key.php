<?php

namespace Routiz\Inc\Src\Form\Modules\Key;

use \Routiz\Inc\Src\Form\Modules\Module;

class Key extends Module {

    public $pre_defined = [

        'post_title' => 'Title',
        'post_content' => 'Content',
        // 'rz_tagline' => 'Tagline',
        //'rz_cover' => 'Cover Image',
        'rz_gallery' => 'Gallery',
        'rz_location' => 'Location',
        'rz_price' => 'Price',
        'rz_guests' => 'Guests',
        // 'rz_booking' => 'Booking',

    ];

    public function before_construct() {
        $this->defaults += [
            'defined' => true,
        ];
    }

    public function finish() {

        $this->props->is_defined = array_key_exists( $this->props->value, $this->pre_defined );

        if( $this->props->is_defined ) {
            $this->class[] = 'rz-is-defined';
        }

    }

    public function controller() {

        return array_merge( (array) $this->props, [
            'pre_defined' => $this->pre_defined,
            'strings' => (object) [
                'defined' => esc_html__('Defined', 'routiz'),
                'select' => esc_html__('Select', 'routiz'),
                'custom' => esc_html__('Custom', 'routiz'),
            ]
        ]);

    }

}
