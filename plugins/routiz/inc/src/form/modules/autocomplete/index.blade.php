@include('label.index')

<div class="rz-quick<?php if( $term_name ) { echo ' rz-is-selected'; } ?>">

    <?php Rz()->the_template( 'routiz/search/hiddens' ); ?>

    <div class="rz-quick-input">
        <i class="rz-quick-preloader fas fa-sync fa-spin"></i>
        <input
            class="rz-quick-label rz-transition"
            name=""
            type="text"
            placeholder="{{ $placeholder }}"
            value="{{ $term_name }}"
            autocomplete="nope">
        <input class="rz-quick-value" type="hidden" name="{{ $id }}" value="{{ $value }}">
        <a href="#" class="rz-icon-clear fas fa-times"></a>
    </div>

    <div class="rz-autocomplete rz-is-empty">
        <ul class="rz-listed">
            <!-- autocomplete rows -->
        </ul>
    </div>

</div>
