<?php
require('functions.php');

$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
$details_id=isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'0';
$testimonial_object=$wpdb->get_results("select * from ".$wpdb->prefix."vote");

?>

<table cellpadding="10" cellspacing="1" border="2">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Like</th>
        <th>Post_ID</th>
        <th>comment</th>
    </tr>

    
    <?php 

foreach ($testimonial_object as $testimonial_object_result) { 

    ?>

    <tr>
        <td><?php echo $testimonial_object_result->user_id; ?></td>
        <td><?php echo $testimonial_object_result->name; ?></td>
        <td><?php echo $testimonial_object_result->email; ?></td>
        <td><?php echo $testimonial_object_result->phone; ?></td>
        <td><?php echo $testimonial_object_result->vote; ?></td>
        <td><?php echo $testimonial_object_result->post_id; ?></td>
        <td><?php echo $testimonial_object_result->comment; ?></td>
    </tr>

<?php  

}

?>
</table>