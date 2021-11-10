@include('label.index')

<div class="rz-geo-field">

    <input
        type="text"
        name="rz_geo"
        value="{{ $value }}"
        placeholder="{{ $placeholder }}"
        class="{{ $html->class }}"
        @if( $html->id )id="{{ $html->id }}"@endif>

    <a href="#" class="rz-geo-get">
        <i class="material-icon-gps_fixedmy_location"></i>
    </a>

</div>

<input type="hidden" name="rz_geo_n" value="{{ $geo_n }}">
<input type="hidden" name="rz_geo_e" value="{{ $geo_e }}">
<input type="hidden" name="rz_geo_s" value="{{ $geo_s }}">
<input type="hidden" name="rz_geo_w" value="{{ $geo_w }}">
