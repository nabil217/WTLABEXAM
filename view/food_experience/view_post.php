<?php
require_once __DIR__ . '/../../config/auth.php';

$flash = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($post['title']) ?> | Food Blog</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>

<?php require_once __DIR__ . '/../partials/navbar.php'; ?>

<div class="container">

    <?php if ($flash): ?>
        <div class="flash flash-success"><?= htmlspecialchars($flash) ?></div>
    <?php endif; ?>

    
    <div class="post-detail">
        <span class="badge badge-<?= $post['post_type'] ?>"><?= ucfirst($post['post_type']) ?></span>
        <h1 class="mt-1"><?= htmlspecialchars($post['title']) ?></h1>
        <div class="card-meta mt-1">
            <span>👤 <?= htmlspecialchars($post['author_name']) ?></span>
            <span>📅 <?= date('d M Y, H:i', strtotime($post['created_at'])) ?></span>
            <?php if ($post['updated_at'] !== $post['created_at']): ?>
                <span class="text-muted">(edited <?= date('d M Y', strtotime($post['updated_at'])) ?>)</span>
            <?php endif; ?>
        </div>
        <hr class="divider">
        <div class="post-content"><?= htmlspecialchars($post['content']) ?></div>

        
        <?php if (isLoggedIn() && ($post['user_id'] == getCurrentUserId() || isAdmin())): ?>
            <div class="flex-row mt-2">
                <a href="../../control/food_experience_controller.php?action=edit&id=<?= $post['id'] ?>"
                   class="btn btn-accent btn-sm">✏ Edit</a>
                <a href="../../control/food_experience_controller.php?action=delete&id=<?= $post['id'] ?>"
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Delete this post?')">🗑 Delete</a>
            </div>
        <?php endif; ?>
    </div>

    <a href="../../control/food_experience_controller.php?action=list" class="btn btn-outline btn-sm">← Back to list</a>

    
    <div class="comments-section mt-3">
        <h3>💬 Comments (<span id="comment-count"><?= count($comments) ?></span>)</h3>

        <div id="comments-list">
            <?php foreach ($comments as $c): ?>
                <div class="comment-item" id="comment-<?= $c['id'] ?>">
                    <div class="comment-avatar"><?= strtoupper(substr($c['author_name'], 0, 1)) ?></div>
                    <div class="comment-body">
                        <span class="comment-author"><?= htmlspecialchars($c['author_name']) ?></span>
                        <span class="comment-date"><?= date('d M Y, H:i', strtotime($c['created_at'])) ?></span>
                        <div class="comment-text"><?= htmlspecialchars($c['comment']) ?></div>
                        <?php if (isLoggedIn() && ($c['user_id'] == getCurrentUserId() || isAdmin())): ?>
                            <div class="comment-actions mt-1">
                                <button class="btn btn-danger btn-sm"
                                        onclick="deleteComment(<?= $c['id'] ?>, this)">Delete</button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (empty($comments)): ?>
                <p class="text-muted" id="no-comments-msg">No comments yet. Be the first!</p>
            <?php endif; ?>
        </div>

        
        <?php if (isMember()): ?>
            <div class="card mt-2" style="border-left-color:#F4A261">
                <h4 style="color:#2C6E49;margin-bottom:0.8rem;">Add a Comment</h4>
                <div id="comment-error" class="errors-box" style="display:none;"></div>
                <div class="form-group">
                    <label for="comment-text">Your Comment</label>
                    <textarea id="comment-text" class="form-control" rows="3"
                              placeholder="Share your thoughts..." maxlength="1000"></textarea>
                    <div class="form-error" id="comment-js-error"></div>
                </div>
                <button class="btn btn-primary" onclick="submitComment(<?= $post['id'] ?>)">
                    Post Comment
                </button>
                <span id="comment-spinner" style="display:none;" class="loading-spinner"></span>
            </div>
        <?php elseif (!isLoggedIn()): ?>
            <div class="visitor-notice mt-2">
                 <a href="../login.php">Login</a> to leave a comment.
            </div>
        <?php endif; ?>
    </div>

</div>

<script src="../../public/js/food_experience.js"></script>
</body>
</html>
