<?php
/**
 * Plugin Name: Decimal Point LearnDash
 * Plugin URI: https://www.learndash.com/
 * Description: Decimal Point LearnDash.
 * Version: 0.1
 * Author: Noreen Gul
 * Author URI: https://www.learndash.com/
 **/
global $wpdb;
$rows_affected = $wpdb->query(
    "ALTER TABLE {$wpdb->prefix}learndash_pro_quiz_question
  MODIFY points double (10,2) NULL;"
);

function script_add( $post_id )  {

    global $wpdb;
    update_post_meta($post_id,'question_points',$_REQUEST['points']);
    $post_meta=get_post_meta($post_id,'question_pro_id')[0];
    $wpdb->query("UPDATE  {$wpdb->prefix}learndash_pro_quiz_question SET points = ".$_REQUEST['points']." WHERE sort=".$post_meta);
}
add_action( 'wp_after_insert_post', 'script_add' );

add_action('admin_footer', 'my_admin_add_js');

function my_admin_add_js() {

    ?><script>
        jQuery( document ).ready(function() {
            jQuery("input[name='points']").each(function(i, v) {

                jQuery(v).attr('step','any');
            });

            jQuery("input[name='answerData[][points]']").each(function(i, v) {

                jQuery(v).attr('step','any');
            });
        });

</script> <?php
}

?>