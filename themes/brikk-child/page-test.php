<?php
    get_header();
    $post = get_post( 3499);
    //print_r($post);
   
    $fields = get_post_meta($post->ID);
    $loc = get_post_meta( $post->ID, 'rz_location' );
    print_r ($loc);
    //print_r($fields);
 
    $meta_id = get_mid_by_key( $post->ID, 'rz_location' );
  
    //update_field('rz_full_name','new post title test', $post->ID);
     echo( $fields['rz_full_name'][0]);
    echo '<hr> Current <br>';
 
     $geo = ["Lviv, Lviv Oblast, Ukraine, 79000", "49.839683", "24.029717", "Ukraine", "Lviv, Lviv Oblast, Ukraine, 79000", "Lviv Oblast, Ukraine" ]; 
   
     update_field('rz_location__address', $geo[0], $post->ID);
     update_field('rz_location__lat', $geo[1], $post->ID);
     update_field('rz_location__lng', $geo[2], $post->ID);
      update_field('rz_location__geo_country', $geo[3], $post->ID);
       update_field('rz_location__geo_city', $geo[4], $post->ID);
        update_field('rz_location__geo_alt', $geo[5], $post->ID);
     $geo_s=maybe_serialize($geo);
     // update_field('rz_location', $geo, $post->ID);
     update_field('rz_location[]]', $geo_s, $post->ID);

    //  $lat = unserialize($geo_s);
    // print_r( $lat);
     //update_post_meta($post->ID,'rz_location',$geo);
    //update_field('rz_location', $geo, $post->ID);
     foreach ($geo as $key => $value){
        update_metadata_by_mid('post', $meta_id,$value);
        $meta_id++;
         //update_post_meta($post->ID,'rz_location',$value, $loc[$key]);
        // echo ('rz_location['.$key.'] =>'.$value);
     }
    

    // var_dump ($fields['rz_location']);
    //  echo '<hr> New <br>';
    //  print_r ($geo);
    get_footer();
?>