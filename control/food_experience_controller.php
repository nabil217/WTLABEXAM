<?php
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../model/FoodExperiencePost.php';
require_once __DIR__ . '/../model/FoodExperienceComment.php';

$action = $_GET['action'] ?? 'list';
$postModel = new FoodExperiencePost();
$commentModel = new FoodExperienceComment();


if ($action === 'list') {
    $posts = $postModel->getAllPosts();
    require_once __DIR__ . '/../view/food_experience/index.php';
    exit;
}


if ($action === 'view') {
    $post_id = (int)($_GET['id'] ?? 0);
    $post = $postModel->getPostById($post_id);
    if (!$post) {
        $_SESSION['flash'] = "Post not found.";
        header("Location: food_experience_controller.php?action=list");
        exit;
    }
    $comments = $commentModel->getCommentsByPost($post_id);
    require_once __DIR__ . '/../view/food_experience/view_post.php';
    exit;
}


if ($action === 'create') {
    requireLogin('../view/food_experience/index.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // PHP validation
        $errors = [];
        $title     = trim($_POST['title'] ?? '');
        $content   = trim($_POST['content'] ?? '');
        $post_type = $_POST['post_type'] ?? 'both';
        $restaurant_id = !empty($_POST['restaurant_id']) ? (int)$_POST['restaurant_id'] : null;
        $menu_item_id  = !empty($_POST['menu_item_id'])  ? (int)$_POST['menu_item_id']  : null;

        if (empty($title))           $errors[] = "Title is required.";
        if (strlen($title) > 255)    $errors[] = "Title must be under 255 characters.";
        if (empty($content))         $errors[] = "Content is required.";
        if (strlen($content) < 10)   $errors[] = "Content must be at least 10 characters.";
        $allowed_types = ['restaurant', 'food', 'both'];
        if (!in_array($post_type, $allowed_types)) $errors[] = "Invalid post type.";

        if (empty($errors)) {
            $new_id = $postModel->createPost(
                getCurrentUserId(), $title, $content, $post_type,
                $restaurant_id, $menu_item_id
            );
            $_SESSION['flash'] = "Post published successfully!";
            header("Location: food_experience_controller.php?action=view&id=$new_id");
            exit;
        }
        
        require_once __DIR__ . '/../view/food_experience/create_post.php';
        exit;
    }

    
    $errors = [];
    $title = $content = $post_type = '';
    require_once __DIR__ . '/../view/food_experience/create_post.php';
    exit;
}


if ($action === 'edit') {
    requireLogin();
    $post_id = (int)($_GET['id'] ?? 0);
    $post = $postModel->getPostById($post_id);
    if (!$post) {
        header("Location: food_experience_controller.php?action=list");
        exit;
    }
    
    if ($post['user_id'] != getCurrentUserId() && !isAdmin()) {
        header("Location: food_experience_controller.php?action=list");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $errors = [];
        $title     = trim($_POST['title'] ?? '');
        $content   = trim($_POST['content'] ?? '');
        $post_type = $_POST['post_type'] ?? 'both';

        if (empty($title))    $errors[] = "Title is required.";
        if (empty($content))  $errors[] = "Content is required.";

        if (empty($errors)) {
            $postModel->updatePost($post_id, getCurrentUserId(), $title, $content, $post_type);
            $_SESSION['flash'] = "Post updated successfully!";
            header("Location: food_experience_controller.php?action=view&id=$post_id");
            exit;
        }
        require_once __DIR__ . '/../view/food_experience/edit_post.php';
        exit;
    }

    
    $errors = [];
    $title     = $post['title'];
    $content   = $post['content'];
    $post_type = $post['post_type'];
    require_once __DIR__ . '/../view/food_experience/edit_post.php';
    exit;
}


if ($action === 'delete') {
    requireLogin();
    $post_id = (int)($_GET['id'] ?? 0);
    $postModel->deletePost($post_id, getCurrentUserId(), isAdmin());
    $_SESSION['flash'] = "Post deleted.";
    header("Location: food_experience_controller.php?action=list");
    exit;
}
?>
