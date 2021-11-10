<h4 class="rz--title">{{ $title }}</h4>

<form>
    <div class="rz-grid">

        @if( $action_fields->allow_seasons )

            {{ $form->render([
                'type' => 'number',
                'id' => 'rz_price',
                'name' => $strings->price_base,
                'min' => 0,
                'step' => 0.01,
                'required' => boolval( ! $action_fields->allow_not_required_price ),
                'col' => 6
            ]) }}

            {{ $form->render([
                'type' => 'number',
                'id' => 'rz_price_weekend',
                'name' => $strings->price_weekend,
                'min' => 0,
                'step' => 0.01,
                'col' => 6
            ]) }}

        @else

            {{ $form->render([
                'type' => 'number',
                'id' => 'rz_price',
                'name' => $strings->price_base,
                'min' => 0,
                'step' => 0.01,
                'required' => boolval( ! $action_fields->allow_not_required_price ),
            ]) }}

        @endif

        @if( $action_fields->allow_security_deposit )

            {{ $form->render([
                'type' => 'number',
                'id' => 'rz_security_deposit',
                'name' => $strings->security_deposit,
                'min' => 0,
                'step' => 0.01,
            ]) }}

        @endif

        @if( $action_fields->allow_long_term )

            <div class="rz-form-group rz-col-12">
                <h5 class="rz-mb-0">{{ $strings->long_term_discount }}</h5>
            </div>

            {{ $form->render([
                'type' => 'number',
                'id' => 'rz_long_term_week',
                'name' => $strings->long_term_week,
                'min' => 0,
                'step' => 0.01,
                'col' => 6,
            ]) }}

            {{ $form->render([
                'type' => 'number',
                'id' => 'rz_long_term_month',
                'name' => $strings->long_term_month,
                'min' => 0,
                'step' => 0.01,
                'col' => 6,
            ]) }}

        @endif

        @if( $action_fields->allow_seasons )

            <div class="rz-form-group rz-col-12">
                <h5 class="rz-mb-0">{{ $strings->seasonal_pricing }}</h5>
            </div>

            {{ $form->render([
                'type' => 'repeater',
                'id' => 'rz_price_seasonal',
                'name' => $strings->add_seasonal_pricing,
                'button' => [
                    'label' => $strings->add_period
                ],
                'templates' => [

                    /*
                     * period
                     *
                     */
                    'period' => [
                        'name' => $strings->period,
                        'heading' => 'start',
                        'fields' => [

                            'start' => [
                                'type' => 'text',
                                'name' => $strings->start_date,
                                'placeholder' => 'DD/MM',
                                'col' => 6,
                            ],
                            'end' => [
                                'type' => 'text',
                                'name' => $strings->end_date,
                                'placeholder' => 'DD/MM',
                                'col' => 6,
                            ],
                            'price' => [
                                'type' => 'number',
                                'name' => $strings->price_base,
                                'min' => 0,
                                'step' => 0.01,
                                'col' => 6,
                            ],
                            'price_weekend' => [
                                'type' => 'number',
                                'name' => $strings->price_weekend,
                                'min' => 0,
                                'step' => 0.01,
                                'col' => 6,
                            ],

                        ]
                    ],

                ]
            ]) }}

        @endif

        @if( $action_fields->allow_extra_pricing )

            <div class="rz-form-group rz-col-12">
                <h5 class="rz-mb-0">{{ $strings->extra_service_pricing }}</h5>
            </div>

            {{ $form->render([
                'type' => 'repeater',
                'id' => 'rz_extra_pricing',
                'name' => $strings->add_extra_pricing,
                'button' => [
                    'label' => $strings->add_service
                ],
                'templates' => [

                    /*
                     * service
                     *
                     */
                    'service' => [
                        'name' => $strings->service,
                        'heading' => 'name',
                        'fields' => [

                            'name' => [
                                'type' => 'text',
                                'name' => $strings->service_name,
                                'placeholder' => $strings->service_name_placeholder,
                                'col' => 4,
                            ],
                            'type' => [
                                'type' => 'select',
                                'name' => $strings->service_type,
                                'options' => [
                                    'single_fee' => $strings->single_fee,
                                    'per_day' => $strings->per_day,
                                ],
                                'allow_empty' => false,
                                'col' => 4,
                            ],
                            'price' => [
                                'type' => 'number',
                                'name' => $strings->service_price,
                                'min' => 0,
                                'step' => 0.01,
                                'col' => 4,
                            ],

                        ]
                    ],

                ]
            ]) }}

        @endif

        @if( $action_fields->allow_addons )

            <div class="rz-form-group rz-col-12">
                <h5 class="rz-mb-0">{{ $strings->addons }}</h5>
            </div>

            {{ $form->render([
                'type' => 'repeater',
                'id' => 'rz_addons',
                'name' => $strings->add_addons,
                'button' => [
                    'label' => $strings->add_addon
                ],
                'templates' => [

                    /*
                     * addon
                     *
                     */
                    'addon' => [
                        'name' => $strings->addon,
                        'heading' => 'name',
                        'fields' => [
                            'name' => [
                                'type' => 'text',
                                'name' => $strings->addon_name,
                                'placeholder' => $strings->enter_addon_name,
                                'col' => 6,
                            ],
                            'price' => [
                                'type' => 'number',
                                'name' => $strings->addon_price,
                                'min' => 0,
                                'step' => 0.01,
                                'col' => 6,
                            ],
                            'key' => [
                                'type' => 'auto-key',
                                'name' => $strings->addon_id,
                            ],
                        ]
                    ],

                ]
            ]) }}

        @endif

    </div>
</form>
