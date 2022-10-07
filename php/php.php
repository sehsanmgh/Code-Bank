<?
function get_user_name()
{
    return isset($_SESSION['username']) ? $_SESSION['username'] : null;
}


// user SESSION-----------------------------------------------------------------------
function login_user($username, $password)
{
    global $connection;
    $username = trim($username);
    $password = trim($password);
    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);
    $query = "SELECT * FROM users WHERE username = '{$username}' ";
    $select_user_query = mysqli_query($connection, $query);
    if (!$select_user_query) {
        die("QUERY FAILED" . mysqli_error($connection));
    }
    while ($row = mysqli_fetch_array($select_user_query)) {
        $db_user_id = $row['user_id'];
        $db_username = $row['username'];
        $db_user_password = $row['user_password'];
        $db_user_firstname = $row['user_firstname'];
        $db_user_lastname = $row['user_lastname'];
        $db_user_role = $row['user_role'];
        if (password_verify($password, $db_user_password)) {
            $_SESSION['user_id'] = $db_user_id;
            $_SESSION['username'] = $db_username;
            $_SESSION['firstname'] = $db_user_firstname;
            $_SESSION['lastname'] = $db_user_lastname;
            $_SESSION['user_role'] = $db_user_role;
            redirect("/cms/admin");
        } else {
            return false;
        }
    }
    return true;
}
//end of user SESSION-----------------------------------------------------------------------





// add post-------------------------------------------------------------------------------------
if (isset($_POST['create_post'])) {
    $post_title = escape($_POST['title']);
    $post_user = escape($_POST['post_user']);
    $post_category_id = escape($_POST['post_category']);
    $post_status = escape($_POST['post_status']);
    $post_image = escape($_FILES['image']['name']);
    $post_image_temp = escape($_FILES['image']['tmp_name']);
    $post_tags = escape($_POST['post_tags']);
    $post_content = escape($_POST['post_content']);
    $post_date = escape(date('d-m-y'));
    move_uploaded_file($post_image_temp, "../images/$post_image");
    $query = "INSERT INTO posts(post_category_id, post_title, post_user, post_date,post_image,post_content,post_tags,post_status) ";
    $query .= "VALUES({$post_category_id},'{$post_title}','{$post_user}',now(),'{$post_image}','{$post_content}','{$post_tags}', '{$post_status}') ";
    $create_post_query = mysqli_query($connection, $query);
    confirmQuery($create_post_query);
    $the_post_id = mysqli_insert_id($connection);
    echo "<p class='bg-success'>Post Created. <a href='../post.php?p_id={$the_post_id}'>View Post </a> or <a href='posts.php'>Edit More Posts</a></p>";
}
//end of add post-------------------------------------------------------------------------------------





// add user---------------------------------------------------------------------------------------
if (isset($_POST['create_user'])) {
    $user_firstname    = escape($_POST['user_firstname']);
    $user_lastname     = escape($_POST['user_lastname']);
    $user_role         = escape($_POST['user_role']);
    $username          = escape($_POST['username']);
    $user_email        = escape($_POST['user_email']);
    $user_password     = escape($_POST['user_password']);
    $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));
    $query = "INSERT INTO users(user_firstname, user_lastname, user_role,username,user_email,user_password) ";
    $query .= "VALUES('{$user_firstname}','{$user_lastname}','{$user_role}','{$username}','{$user_email}', '{$user_password}') ";
    $create_user_query = mysqli_query($connection, $query);
    confirmQuery($create_user_query);
    echo "User Created: " . " " . "<a href='users.php'>View Users</a> ";
}
//end of add user---------------------------------------------------------------------------------------



// edit post-------------------------------------------------------------------------------------------------------------
if (isset($_GET['p_id'])) {
    $the_post_id =  escape($_GET['p_id']);
}
$query = "SELECT * FROM posts WHERE post_id = $the_post_id  ";
$select_posts_by_id = mysqli_query($connection, $query);
while ($row = mysqli_fetch_assoc($select_posts_by_id)) {
    $post_id            = $row['post_id'];
    $post_user          = $row['post_user'];
    $post_title         = $row['post_title'];
    $post_category_id   = $row['post_category_id'];
    $post_status        = $row['post_status'];
    $post_image         = $row['post_image'];
    $post_content       = $row['post_content'];
    $post_tags          = $row['post_tags'];
    $post_comment_count = $row['post_comment_count'];
    $post_date          = $row['post_date'];
}
if (isset($_POST['update_post'])) {
    $post_user           =  escape($_POST['post_user']);
    $post_title          =  escape($_POST['post_title']);
    $post_category_id    =  escape($_POST['post_category']);
    $post_status         =  escape($_POST['post_status']);
    $post_image          =  escape($_FILES['image']['name']);
    $post_image_temp     =  escape($_FILES['image']['tmp_name']);
    $post_content        =  escape($_POST['post_content']);
    $post_tags           =  escape($_POST['post_tags']);
    move_uploaded_file($post_image_temp, "../images/$post_image");
    if (empty($post_image)) {
        $query = "SELECT * FROM posts WHERE post_id = $the_post_id ";
        $select_image = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_array($select_image)) {
            $post_image = $row['post_image'];
        }
    }
    $post_title = mysqli_real_escape_string($connection, $post_title);
    $query = "UPDATE posts SET ";
    $query .= "post_title  = '{$post_title}', ";
    $query .= "post_category_id = '{$post_category_id}', ";
    $query .= "post_date   =  now(), ";
    $query .= "post_user = '{$post_user}', ";
    $query .= "post_status = '{$post_status}', ";
    $query .= "post_tags   = '{$post_tags}', ";
    $query .= "post_content= '{$post_content}', ";
    $query .= "post_image  = '{$post_image}' ";
    $query .= "WHERE post_id = {$the_post_id} ";
    $update_post = mysqli_query($connection, $query);
    confirmQuery($update_post);
    echo "<p class='bg-success'>Post Updated. <a href='../post.php?p_id={$the_post_id}'>View Post </a> or <a href='posts.php'>Edit More Posts</a></p>";
}
//end of edit post-------------------------------------------------------------------------------------------------------------






// view all post--------------------------------------------------------------------------------------
include("delete_modal.php");
if (isset($_POST['checkBoxArray'])) {
    foreach ($_POST['checkBoxArray'] as $postValueId) {
        $bulk_options = $_POST['bulk_options'];
        switch ($bulk_options) {
            case 'published':
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId}  ";
                $update_to_published_status = mysqli_query($connection, $query);
                confirmQuery($update_to_published_status);
                break;
            case 'draft':
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId}  ";
                $update_to_draft_status = mysqli_query($connection, $query);
                confirmQuery($update_to_draft_status);
                break;
            case 'delete':
                $query = "DELETE FROM posts WHERE post_id = {$postValueId}  ";
                $update_to_delete_status = mysqli_query($connection, $query);
                confirmQuery($update_to_delete_status);
                break;
            case 'clone':
                $query = "SELECT * FROM posts WHERE post_id = '{$postValueId}' ";
                $select_post_query = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_array($select_post_query)) {
                    $post_title         = $row['post_title'];
                    $post_category_id   = $row['post_category_id'];
                    $post_date          = $row['post_date'];
                    $post_author        = $row['post_author'];
                    $post_status        = $row['post_status'];
                    $post_image         = $row['post_image'];
                    $post_tags          = $row['post_tags'];
                    $post_content       = $row['post_content'];
                }
                $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date,post_image,post_content,post_tags,post_status) ";
                $query .= "VALUES({$post_category_id},'{$post_title}','{$post_author}',now(),'{$post_image}','{$post_content}','{$post_tags}', '{$post_status}') ";
                $copy_query = mysqli_query($connection, $query);
                if (!$copy_query) {

                    die("QUERY FAILED" . mysqli_error($connection));
                }
                break;
        }
    }
}
?>
<form action="" method='post'>
    <table class="table table-bordered table-hover">
        <div id="bulkOptionContainer" class="col-xs-4">
            <select class="form-control" name="bulk_options" id="">
                <option value="">Select Options</option>
                <option value="published">Publish</option>
                <option value="draft">Draft</option>
                <option value="delete">Delete</option>
                <option value="clone">Clone</option>
            </select>
        </div>
        <div class="col-xs-4">
            <input type="submit" name="submit" class="btn btn-success" value="Apply">
            <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
        </div>
        <thead>
            <tr>
                <th><input id="selectAllBoxes" type="checkbox"></th>
                <th>Id</th>
                <th>Users</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Date</th>
                <th>View Post</th>
                <th>Edit</th>
                <th>Delete</th>
                <th>Views</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * FROM posts ORDER BY post_id DESC ";
            $select_posts = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($select_posts)) {
                $post_id            = $row['post_id'];
                $post_author        = $row['post_author'];
                $post_user          = $row['post_user'];
                $post_title         = $row['post_title'];
                $post_category_id   = $row['post_category_id'];
                $post_status        = $row['post_status'];
                $post_image         = $row['post_image'];
                $post_tags          = $row['post_tags'];
                $post_comment_count = $row['post_comment_count'];
                $post_date          = $row['post_date'];
                $post_views_count   = $row['post_views_count'];
                echo "<tr>";
            ?>
                <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $post_id; ?>'></td>
            <?php
                echo "<td>$post_id </td>";
                if (!empty($post_author)) {
                    echo "<td>$post_author</td>";
                } elseif (!empty($post_user)) {
                    echo "<td>$post_user</td>";
                }
                echo "<td>$post_title</td>";
                $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id} ";
                $select_categories_id = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($select_categories_id)) {
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];
                    echo "<td>$cat_title</td>";
                }
                echo "<td>$post_status</td>";
                echo "<td><img width='100' src='../images/$post_image' alt='image'></td>";
                echo "<td>$post_tags</td>";
                $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
                $send_comment_query = mysqli_query($connection, $query);
                $row = mysqli_fetch_array($send_comment_query);
                $comment_id = $row['comment_id'];
                $count_comments = mysqli_num_rows($send_comment_query);
                echo "<td><a href='post_comments.php?id=$post_id'>$count_comments</a></td>";
                echo "<td>$post_date </td>";
                echo "<td><a class='btn btn-primary' href='../post.php?p_id={$post_id}'>View Post</a></td>";
                echo "<td><a class='btn btn-info' href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
                echo "<td><a class='btn btn-danger' href='posts.php?delete=delete&p_id={$post_id}'>Delete</a></td>";
                echo "<td><a href='posts.php?reset=reset&p_id={$post_id}'>{$post_views_count}</a></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</form>
<?php
if (isset($_GET['delete'])) {
    $post_id = $_GET['p_id'];
    if (is_the_logged_in_user_owner($post_id)) {
        $stmt = stmtConnection();
        mysqli_stmt_prepare($stmt, "DELETE FROM posts WHERE post_id=?");
        mysqli_stmt_bind_param($stmt, "i", $post_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        redirect("posts.php");
    }
}
if (isset($_GET['reset'])) {
    $post_id = $_GET['p_id'];
    if (is_the_logged_in_user_owner($post_id)) {
        $stmt = stmtConnection();
        mysqli_stmt_prepare($stmt, "UPDATE posts SET post_views_count=0 WHERE post_id=?");
        mysqli_stmt_bind_param($stmt, "i", $post_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        redirect("posts.php");
    }
}
?>
<script>
    $(document).ready(function() {
        $(".delete_link").on('click', function() {
            var id = $(this).attr("rel");
            var delete_url = "posts.php?delete=" + id + " ";
            $(".modal_delete_link").attr("href", delete_url);
            $("#myModal").modal('show');
        });
    });
    <?php if (isset($_SESSION['message'])) {
        unset($_SESSION['message']);
    } ?>
</script>
<?
//end of view all post--------------------------------------------------------------------------------------






// source----------------------------------------------------------------------------------
if (isset($_GET['source'])) {
    $source = $_GET['source'];
} else {
    $source = '';
}
switch ($source) {
    case 'add_post';
        include "includes/add_post.php";
        break;
    case 'edit_post';
        include "includes/edit_post.php";
        break;
    case '200';
        echo "NICE 200";
        break;
    default:
        include "includes/view_all_posts.php";
        break;
}
//end of source----------------------------------------------------------------------------------





// connection------------------------------------------------------------------------
$db['db_host'] = "localhost";
$db['db_user'] = "root";
$db['db_pass'] = "root";
$db['db_name'] = "cms";
foreach ($db as $key => $value) {
    define(strtoupper($key), $value);
}
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$query = "SET NAMES utf8";
mysqli_query($connection, $query);
//end of  connection------------------------------------------------------------------------
