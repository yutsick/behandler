<?php

use \Routiz\Inc\Src\Listing_Type\Action;

get_header();

global $rz_submission, $rz_explore;

$action_fields = Action::get_action_fields( $rz_submission->listing_type );
$actions = $rz_submission->listing_type->get_action();
?>
 

<div class="brk-submission rz-submission">


	<div class="brk--content">
		
		<div class="brk--middle">
			<div class="brk--row">
					    <div class="rz-submission-content">
					        <?php

							
                            $field_collected_ids = [];

                                foreach( $rz_submission->tabs as $index => $tab ) {
                                if( isset( $tab['content'] ) ) {

                                    $fields = [];

                                    foreach( $tab['content'] as $content ) {
                                        if( ! in_array( $content->fields->key, $field_collected_ids ) ) {
                                            $fields[] = $content;
                                            $field_collected_ids[] = $content->fields->key;
                                        }
                                    }
                                   
                                    $rz_submission->component->render([
                                       
                                        'type' => 'fields',
                                        'group' => $index,
                                        'title' => $tab['title'],
                                        'fields' => $fields,
                                        
                                        //'type' => 'pricing',
                                       // 'type' => 'reservation'
                                    ]);
                                      $rz_submission->component->render([
                                        'type' => 'pricing'
                                        
                                    ]);
                                    $rz_submission->component->render([
                                        'type' => 'reservation'
                                    ]);
                                    $rz_submission->component->render([
                                        'type' => 'publish'
                                    ]);

                                    $rz_submission->component->render([
                                        'type' => 'success'
                                    ]);


                                }
                            }
                                                                                         
                            ?>
					    </div>

				    


			</div>
		</div>
 
		
	</div>
</div>
<script>

</script>
<?php get_footer();
