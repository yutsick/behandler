<?php

defined('ABSPATH') || exit;

global $rz_listing;

$gallery = $rz_listing->get_gallery([
    'brk_cover_large',
    'brk_cover_small',
    'rz_gallery_large',
]);

$gallery_num = count( $gallery );
$has_favorite = $rz_listing->type->get( 'rz_display_listing_favorite' );

?>

<?php if( $gallery ): ?>
    <div class="brk-cover-outer">
        <div class="brk-row">
            <div class="">

                <div class="brk--images" data-size="<?php echo min( 5, $gallery_num ); ?>">
                    <?php foreach( $gallery as $key => $image ): ?>
                        <?php if( isset( $image['brk_cover_large'] ) ): ?>
                            <a href="#" class="brk--image" style="background-image: url('<?php echo esc_url( $image['brk_cover_large'] ); ?>');"></a>
                        <?php endif; ?>
                        <?php if( $key >= 4 ) { break; } ?>
                    <?php endforeach; ?>
                </div>

                <ul class="brk-lightbox-stack" style="margin:0;list-style:none;">
                    <?php foreach( $gallery as $key => $image ): ?>
                        <li class="brk-lightbox" data-image="<?php echo esc_url( $image['rz_gallery_large'] ); ?>"></li>
                    <?php endforeach; ?>
                </ul>
                <ul class="brk-gallery-actions brk--top">
                    <?php if( $has_favorite ): ?>
                        <?php

                            $user_favorites = get_user_meta( get_current_user_id(), 'rz_favorites', true );
                            if( ! is_array( $user_favorites ) ) {
                                $user_favorites = [];
                            }

                            $is_favorite = in_array( get_the_ID(), $user_favorites );

                        ?>
                        <li>
                            <a class="<?php if( is_user_logged_in() and $is_favorite ) { echo 'rz-active'; } ?>" href="#" <?php if( is_user_logged_in() ) { echo 'data-action="add-favorite"'; }else{ echo 'data-modal="signin"'; } ?> data-id="<?php the_ID(); ?>">
                                <i class="far fa-heart"></i>
                                <?php esc_html_e( 'Add to favorites', 'brikk' ); ?>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if( get_option('rz_enable_share') ): ?>
                        <li>
                            <a href="#" data-modal="share">
                                <?php esc_html_e( 'Share', 'brikk' ); ?>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <?php if( count( $gallery ) > 5 ): ?>
                    <ul class="brk-gallery-actions brk--bottom">
                        <li>
                            <a href="#" data-action="expand-gallery">
                                <i class="far fa-images"></i>
                                <?php echo sprintf( esc_html__( '+%s more', 'brikk' ), count( $gallery ) - 5 ); ?>
                            </a>
                        </li>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
