<?php  
/*
# Plugin Name: vote
# Description: Display feedback form submission details in admin, CSV Download
# Author: Techshu
# Version: 1.0
# Author URI: https://www.techshu.com/ 

*/



    function feedback_form_install()
{
    
    global $wpdb;
    $submitformtable=$wpdb->prefix.'vote';
    $structure = 'CREATE TABLE `' .$submitformtable.'` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` bigint(20) NOT NULL,
  `post_id` int(11) NOT NULL,
  `vote` varchar(255) NOT NULL,
  `comment` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`user_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4';

$wpdb->query($structure);


}

register_activation_hook(__FILE__, 'feedback_form_install');



function feedback_form_delete()
{
    global $wpdb;
    $drop = 'DROP TABLE IF EXISTS `wp_vote`';

$wpdb->query($drop);
}

register_uninstall_hook(__FILE__, 'feedback_form_delete');

function feedback_form_admin_show_menu()
{
    global $wp_version;
    switch($_GET['page']){
        case "submission_view":
        include 'submission_view.php';
        break;
    }
}

function feedback_form_adminactions()
{
    add_menu_page("vote", "vote module", 1, "submission_view", "feedback_form_admin_show_menu");
    add_submenu_page("submission_view", "Overview", "Overview", 1, "career_new_page", "feedback_form_admin_show_menu");

    add_submenu_page("career_new_page", "View Recruitment Entry", "View Recruitment Entry", 1, "recruitment_entry_view_page", "feedback_form_admin_show_menu");
}
add_action('admin_menu', 'feedback_form_adminactions');

add_filter('post_id' , 'activateform');
function activateform()
{
    if(is_single())
    {
        return .'   <div class="container">
    <center>
    <form name="vote_form" action="<?php bloginfo('template_directory'); ?>/a.php" method="post" onsubmit="return valid();">
    <div class="form-group">
        <input type="text" class="form-control"  name="name" id="nme" placeholder="Name" onkeyup="text();">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="email" id="eml" placeholder="Email">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="phone" id="phn" placeholder="Phone" onkeyup="num();">
    </div>
    <div class="form-group">
        <select class="form-control" name="vote" id="vote">
            <option value="">Did you like the post? </option>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
        </select>
    </div>
  <div class="form-group">
    <input type="hidden" name="post_id" value="<?php echo get_the_ID(); ?>">
  </div>
    <div class="form-group">
        <textarea class="form-control" name="comment" id="cmnt" placeholder="Comment" rows="4" cols="50"></textarea>
    </div>
    <div class="form-group">
        <input type="submit" class="form-control" name="submit" value="submit">
    </div>
    </form>
  </center>
 </div>

 <script type="text/javascript">
            function text()
            {

              var element = document.getElementById('nme');
              element.value = element.value.replace(/[^a-zA-Z_ ]+/, '');

            };
            function num()
            {

              var element = document.getElementById('phn');
              element.value = element.value.replace(/[^0-9]+/, '');

            };
            function valid()
            {
              var user_name = document.vote_form.name.value;
              var user_email = document.vote_form.email.value;
              var user_phone = document.vote_form.phone.value;
              var vote = document.vote_form.vote.value;
              var comments= document.vote_form.comment.value;

              var phonecheck=/^[6789]{1}[0-9]{9}$/ ;
              var emailcheck = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

              if(user_name == "")
              {
                alert('Please enter your name');
                document.getElementById('nme').focus();
                return false;
              }
              else if(user_email == "")
              {
                alert('Please enter email');
                document.getElementById('eml').focus();
                return false;
              }
              else if(!emailcheck.test(user_email))
              {
                alert('Please enter valid email');
                document.getElementById('eml').focus();
                return false;
              }
              else if(user_phone == "")
              {
                alert('Please enter your Phone number');
                document.getElementById('phn').focus();
                return false;
              }
              else if(!phonecheck.test(user_phone))
              {
                alert('Please enter your correct Phone number');
                document.getElementById('phn').focus();
                return false;
              }
              else if(vote=="")
              {
                alert('Please vote');
                return false;
              }
                    else if(comments=="")
                    {
                      alert('Please mention your comments');
                document.getElementById('cmnt').focus();
                return false;
                    }
              else
              {
                document.vote_form.submit();
              }
            }
          </script>'.;
    }
}

?>