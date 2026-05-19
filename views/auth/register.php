<!-- views/auth/register.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Register - Food Blog</title>
    <style>
        body { font-family: Arial; max-width: 500px; margin: 50px auto; }
        input, select { width: 100%; padding: 8px; margin: 5px 0 10px; box-sizing: border-box; }
        button { background: #e44d26; color: white; padding: 10px 20px; border: none; cursor: pointer; }
        .error { color: red; background: #ffe0e0; padding: 8px; margin-bottom: 10px; }
        #adminHint { color: #e44d26; font-size: 0.82rem; display: none; margin-bottom: 8px; }
    </style>
</head>
<body>
    <?php include 'views/partials/navbar.php'; ?>

    <h2>Register</h2>

    <?php if (!empty($errors)): ?>
        <div class="error">
            <?php foreach ($errors as $e): ?>
                <p><?= htmlspecialchars($e) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="index.php?page=register" id="registerForm">
        <label>Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>

        <label>Role:</label>
        <select name="role" id="roleSelect">
            <option value="member" <?= (($_POST['role'] ?? '') === 'member') ? 'selected' : '' ?>>Member</option>
            <option value="admin"  <?= (($_POST['role'] ?? '') === 'admin')  ? 'selected' : '' ?>>Admin</option>
        </select>

        <label>Email:</label>
        <input type="email" name="email" id="emailInput"
               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
        <small id="emailMsg" style="color:red;"></small>
        

        <label>Password (min 8 chars):</label>
        <input type="password" name="password" id="pass1" required>

        <label>Confirm Password:</label>
        <input type="password" name="confirm_password" id="pass2" required>

        <button type="submit">Register</button>
        <p>Already have an account? <a href="index.php?page=login">Login</a></p>
    </form>

    <script>
        const roleSelect = document.getElementById('roleSelect');
        const emailInput = document.getElementById('emailInput');
        const emailMsg   = document.getElementById('emailMsg');
        const adminHint  = document.getElementById('adminHint');

        // Show hint when Admin is selected
        roleSelect.addEventListener('change', function() {
            adminHint.style.display = this.value === 'admin' ? 'block' : 'none';
            emailMsg.textContent = '';
        });

        // Email blur: check domain + AJAX availability
        emailInput.addEventListener('blur', function() {
            const email = this.value;
            const role  = roleSelect.value;
            if (!email) return;

            if (role === 'admin' && !email.endsWith('@foodblog.com')) {
                emailMsg.textContent = "Invalid Email";
                return;
            } else {
                emailMsg.textContent = '';
            }

            fetch('index.php?page=api-check-email&email=' + encodeURIComponent(email))
                .then(res => res.json())
                .then(data => {
                    emailMsg.textContent = !data.available ? "Email already registered!" : "";
                });
        });

        // Final submit check
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const p1    = document.getElementById('pass1').value;
            const p2    = document.getElementById('pass2').value;
            const email = emailInput.value;
            const role  = roleSelect.value;

            if (role === 'admin' && !email.endsWith('@foodblog.com')) {
                alert("Did not match the requirment!");
                e.preventDefault();
                return;
            }
            if (p1 !== p2) {
                alert("Passwords do not match!");
                e.preventDefault();
            }
        });
    </script>
</body>
</html>