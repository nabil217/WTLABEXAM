const reviewForm = document.getElementById('reviewForm');

if(reviewForm) {

    reviewForm.addEventListener('submit', function(e) {

        e.preventDefault();

        const menu_item_id = document.getElementById('menu_item_id').value;
        const comment = document.getElementById('comment').value;

        if(comment.trim() === '') {
            alert('Comment required');
            return;
        }

        const formData = new FormData();

        formData.append('menu_item_id', menu_item_id);
        formData.append('comment', comment);

        fetch('api/add-review.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {

            alert(data.message);
            location.reload();
        });
    });
}

const deleteButtons = document.querySelectorAll('.delete-review');

if(deleteButtons.length > 0) {

    deleteButtons.forEach(button => {

        button.addEventListener('click', function() {

            const review_id = this.dataset.id;

            const formData = new FormData();
            formData.append('review_id', review_id);

            fetch('api/delete-review.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {

                if(data.success) {
                    location.reload();
                }
            });
        });
    });
}