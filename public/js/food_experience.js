


document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('post-form');
    if (form) {
        form.addEventListener('submit', function (e) {
            var valid = true;

            var title = document.getElementById('title');
            var titleError = document.getElementById('title-error');
            if (title && titleError) {
                if (title.value.trim() === '') {
                    titleError.textContent = 'Title is required.';
                    valid = false;
                } else if (title.value.trim().length > 255) {
                    titleError.textContent = 'Title must be under 255 characters.';
                    valid = false;
                } else {
                    titleError.textContent = '';
                }
            }

            var content = document.getElementById('content');
            var contentError = document.getElementById('content-error');
            if (content && contentError) {
                if (content.value.trim() === '') {
                    contentError.textContent = 'Content is required.';
                    valid = false;
                } else if (content.value.trim().length < 10) {
                    contentError.textContent = 'Content must be at least 10 characters.';
                    valid = false;
                } else {
                    contentError.textContent = '';
                }
            }

            if (!valid) e.preventDefault();
        });
    }
});

function submitComment(postId) {
    var commentText = document.getElementById('comment-text');
    var jsError = document.getElementById('comment-js-error');
    var spinner = document.getElementById('comment-spinner');
    var errorBox = document.getElementById('comment-error');

    if (!commentText || commentText.value.trim() === '') {
        jsError.textContent = 'Comment cannot be empty.';
        return;
    }
    if (commentText.value.trim().length > 1000) {
        jsError.textContent = 'Comment must be under 1000 characters.';
        return;
    }
    jsError.textContent = '';

    if (spinner) spinner.style.display = 'inline-block';

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4) {
            if (spinner) spinner.style.display = 'none';
            if (this.status === 200) {
                try {
                    var data = JSON.parse(this.responseText);
                    if (data.success) {
                        appendComment(data, postId);
                        commentText.value = '';
                        if (errorBox) errorBox.style.display = 'none';
                        var noMsg = document.getElementById('no-comments-msg');
                        if (noMsg) noMsg.style.display = 'none';
                    } else {
                        if (errorBox) {
                            errorBox.style.display = 'block';
                            errorBox.innerHTML = '<ul><li>' + (data.error || 'Failed to post comment.') + '</li></ul>';
                        }
                    }
                } catch (err) {
                    console.error('JSON parse error', err);
                }
            }
        }
    };
    xhttp.open('POST', '../../control/api_comments.php', true);
    xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhttp.send('action=add_comment&post_id=' + encodeURIComponent(postId)
             + '&comment=' + encodeURIComponent(commentText.value.trim()));
}

function appendComment(data, postId) {
    var list = document.getElementById('comments-list');
    var countEl = document.getElementById('comment-count');

    var avatar = data.author_name.charAt(0).toUpperCase();
    var dateStr = new Date(data.created_at).toLocaleString();

    var html = '<div class="comment-item" id="comment-' + data.comment_id + '">'
             + '  <div class="comment-avatar">' + avatar + '</div>'
             + '  <div class="comment-body">'
             + '    <span class="comment-author">' + escapeHtml(data.author_name) + '</span>'
             + '    <span class="comment-date">' + dateStr + '</span>'
             + '    <div class="comment-text">' + escapeHtml(data.comment) + '</div>'
             + '    <div class="comment-actions mt-1">'
             + '      <button class="btn btn-danger btn-sm"'
             + '              onclick="deleteComment(' + data.comment_id + ', this)">Delete</button>'
             + '    </div>'
             + '  </div>'
             + '</div>';

    list.insertAdjacentHTML('beforeend', html);

    if (countEl) countEl.textContent = parseInt(countEl.textContent || 0) + 1;
}

function deleteComment(commentId, btn) {
    if (!confirm('Delete this comment?')) return;

    btn.disabled = true;
    btn.textContent = 'Deleting...';

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            try {
                var data = JSON.parse(this.responseText);
                if (data.success) {
                    var el = document.getElementById('comment-' + commentId);
                    if (el) el.remove();
                    var countEl = document.getElementById('comment-count');
                    if (countEl) countEl.textContent = Math.max(0, parseInt(countEl.textContent) - 1);
                } else {
                    alert(data.error || 'Could not delete comment.');
                    btn.disabled = false;
                    btn.textContent = 'Delete';
                }
            } catch (err) { console.error(err); }
        }
    };
    xhttp.open('POST', '../../control/api_comments.php', true);
    xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhttp.send('action=delete_comment&comment_id=' + encodeURIComponent(commentId));
}

function deletePost(postId, btn) {
    if (!confirm('Delete this post and all its comments?')) return;

    btn.disabled = true;
    btn.textContent = 'Deleting...';

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            try {
                var data = JSON.parse(this.responseText);
                if (data.success) {
                    var card = btn.closest('.card');
                    if (card) {
                        card.style.transition = 'opacity 0.3s';
                        card.style.opacity = '0';
                        setTimeout(function () { card.remove(); }, 300);
                    }
                } else {
                    alert(data.error || 'Could not delete post.');
                    btn.disabled = false;
                    btn.textContent = 'Delete';
                }
            } catch (err) { console.error(err); }
        }
    };
    xhttp.open('POST', '../../control/api_comments.php', true);
    xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhttp.send('action=delete_post&post_id=' + encodeURIComponent(postId));
}

function escapeHtml(str) {
    var div = document.createElement('div');
    div.appendChild(document.createTextNode(str));
    return div.innerHTML;
}
