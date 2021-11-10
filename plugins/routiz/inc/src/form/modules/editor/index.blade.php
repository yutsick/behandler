@include('label.index')


@if( ! is_admin() or wp_doing_ajax() )

    <div class="rz-editor">
        <textarea id="{{ $editor_id }}" name="{{ $id }}">{{ $value }}</textarea>
    </div>

@else

    @php

        $settings = [
            'media_buttons' => false,
            'quicktags' => [ 'buttons' => 'strong,em,del,ul,ol,li,close' ],
            'tinymce' => [
                'toolbar1' => 'bold,italic,underline,separator,link,unlink,separator,bullist,numlist,separator,undo,redo',
                'toolbar2' => '',
                'toolbar3' => '',
            ],
        ];

        wp_editor( $value, $editor_id, $settings );

    @endphp

@endif
