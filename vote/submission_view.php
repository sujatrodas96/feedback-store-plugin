<?php
require('functions.php');

global $wpdb;

function download_csv() {
    if (isset($_POST['download_csv'])) {
        global $wpdb;
        $filename = "submissions_" . date('Ymd') . ".csv";
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=' . $filename);

        $fp = fopen('php://output', 'w');

        // Add header
        $header = array('ID', 'Name', 'Email', 'Phone', 'Like', 'Post_ID', 'Comment');
        fputcsv($fp, $header);

        // Add data
        $testimonial_object = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "vote");
        foreach ($testimonial_object as $row) {
            fputcsv($fp, array(
                $row->user_id,
                $row->name,
                $row->email,
                $row->phone,
                $row->vote,
                $row->post_id,
                $row->comment
            ));
        }

        fclose($fp);
        exit;
    }
}
add_action('admin_init', 'download_csv');

// Ensure there's no whitespace before the opening PHP tag above.

// Page Output
$url = basename(__FILE__) . "?" . (isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : 'cc=cc');
$details_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : '0';
$testimonial_object = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "vote");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submission Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .table {
            margin-top: 20px;
        }
        .btn-success {
            background-color: #28a745;
            border: none;
        }
        .btn-success:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Submission Details</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Like</th>
                        <th>Post_ID</th>
                        <th>Comment</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($testimonial_object as $testimonial_object_result) { ?>
                        <tr>
                            <td><?php echo $testimonial_object_result->user_id; ?></td>
                            <td><?php echo $testimonial_object_result->name; ?></td>
                            <td><?php echo $testimonial_object_result->email; ?></td>
                            <td><?php echo $testimonial_object_result->phone; ?></td>
                            <td><?php echo $testimonial_object_result->vote; ?></td>
                            <td><?php echo $testimonial_object_result->post_id; ?></td>
                            <td><?php echo $testimonial_object_result->comment; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="text-center mt-4">
            <form method="post" action="">
                <input type="submit" name="download_csv" class="btn btn-success" value="Download CSV">
            </form>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
