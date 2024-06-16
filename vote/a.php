<?php
// Load WordPress
require_once('../../../wp-load.php');

// Check if form is submitted
if(isset($_POST['submit'])) {
    global $wpdb;

    // Sanitize input data
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);
    $vote = sanitize_text_field($_POST['vote']);
    $comment = sanitize_textarea_field($_POST['comment']);
    $post_id = intval($_POST['post_id']);

    // Prepare data for insertion
    $data = array(
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'vote' => $vote,
        'comment' => $comment,
        'post_id' => $post_id
    );

    // Specify the format of the data
    $format = array('%s', '%s', '%s', '%s', '%s', '%d');

    // Insert data into database
    $table_name = $wpdb->prefix . 'vote';
    $wpdb->insert($table_name, $data, $format);

    // Redirect back to the post
    wp_redirect(get_permalink($post_id));
    exit;
}
?>
