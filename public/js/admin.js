function deleteMember(userId, memberName, btn) {
    if (!confirm('Remove member "' + memberName + '"?\n\nThis will also delete ALL their posts, comments and reviews.')) return;

    btn.disabled = true;
    btn.textContent = 'Removing...';

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            try {
                var data = JSON.parse(this.responseText);
                if (data.success) {
                    var row = document.getElementById('member-row-' + userId);
                    if (row) {
                        row.style.transition = 'opacity 0.3s';
                        row.style.opacity = '0';
                        setTimeout(function () { row.remove(); }, 300);
                    }
                    showMessage('Member removed successfully.', 'success');
                } else {
                    alert(data.error || 'Could not remove member.');
                    btn.disabled = false;
                    btn.textContent = 'Remove';
                }
            } catch (err) { console.error(err); }
        }
    };
    xhttp.open('POST', '../../control/admin_controller.php?action=delete_member', true);
    xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhttp.send('user_id=' + encodeURIComponent(userId));
}


function deleteReview(reviewId, btn) {
    if (!confirm('Remove this review?')) return;

    btn.disabled = true;
    btn.textContent = 'Removing...';

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            try {
                var data = JSON.parse(this.responseText);
                if (data.success) {
                    var row = document.getElementById('review-row-' + reviewId);
                    if (row) {
                        row.style.transition = 'opacity 0.3s';
                        row.style.opacity = '0';
                        setTimeout(function () { row.remove(); }, 300);
                    }
                    showMessage('Review removed successfully.', 'success');
                } else {
                    alert(data.error || 'Could not remove review.');
                    btn.disabled = false;
                    btn.textContent = 'Remove';
                }
            } catch (err) { console.error(err); }
        }
    };
    xhttp.open('POST', '../../control/admin_controller.php?action=delete_review', true);
    xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhttp.send('review_id=' + encodeURIComponent(reviewId));
}


function showMessage(msg, type) {
    var el = document.getElementById('action-message');
    if (el) {
        el.textContent = msg;
        el.className = 'flash flash-' + (type === 'success' ? 'success' : 'error');
        el.style.display = 'block';
        setTimeout(function () { el.style.display = 'none'; }, 3000);
    }
}
