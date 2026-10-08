<?php

session_start();

require_once "../config/database.php";

if (isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($username === "" || $password === "") {

        $error = "Username dan password wajib diisi.";

    } else {

        try {

            $stmt = $pdo->prepare("
                SELECT id, nama, username, password
                FROM users
                WHERE username = :username
                LIMIT 1
            ");

            $stmt->execute([
                ":username" => $username
            ]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user["password"])) {

                session_regenerate_id(true);

                $_SESSION["admin_id"] = $user["id"];
                $_SESSION["admin_nama"] = $user["nama"];
                $_SESSION["admin_username"] = $user["username"];

                header("Location: index.php");
                exit;

            } else {

                $error = "Username atau password salah.";

            }

        } catch (PDOException $e) {

            $error = "Terjadi kesalahan pada database.";

        }

    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Login Admin - KSR PMI UNPAS</title>

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            font-family: "Segoe UI", Arial, sans-serif;
            background: #f5f6fa;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 430px;
        }

        .login-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.08);
        }

        .logo {
            text-align: center;
            margin-bottom: 25px;
        }

        .logo img {
            width: 75px;
            height: 75px;
            object-fit: contain;
            margin-bottom: 15px;
        }

        .logo h1 {
            font-size: 24px;
            color: #222;
            margin-bottom: 5px;
        }

        .logo p {
            font-size: 13px;
            color: #888;
        }

        .login-title {
            margin-bottom: 25px;
        }

        .login-title h2 {
            font-size: 20px;
            color: #222;
            margin-bottom: 5px;
        }

        .login-title p {
            color: #888;
            font-size: 13px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #444;
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 17px;
        }

        .input-wrapper input {
            width: 100%;
            height: 48px;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 0 15px 0 45px;
            outline: none;
            font-size: 14px;
            transition: 0.2s;
        }

        .input-wrapper input:focus {
            border-color: #c62828;
            box-shadow: 0 0 0 3px rgba(198, 40, 40, 0.08);
        }

        .password-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            border: 0;
            background: none;
            color: #888;
            cursor: pointer;
            font-size: 17px;
        }

        .password-wrapper input {
            padding-right: 45px;
        }

        .error-message {
            background: #fff0f0;
            border: 1px solid #ffd2d2;
            color: #c62828;
            padding: 12px 14px;
            border-radius: 9px;
            font-size: 13px;
            margin-bottom: 18px;
        }

        .login-button {
            width: 100%;
            height: 48px;
            border: none;
            border-radius: 10px;
            background: #c62828;
            color: white;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
        }

        .login-button:hover {
            background: #a91f1f;
            transform: translateY(-1px);
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #888;
            font-size: 13px;
            text-decoration: none;
        }

        .back-link:hover {
            color: #c62828;
        }

        .copyright {
            text-align: center;
            margin-top: 20px;
            font-size: 11px;
            color: #aaa;
        }

        @media (max-width: 480px) {

            .login-card {
                padding: 30px 22px;
            }

            .logo h1 {
                font-size: 21px;
            }

        }

    </style>

</head>

<body>

    <div class="login-container">

        <div class="login-card">

            <div class="logo">

                <img
                    src="../assets/img/ksr.png"
                    alt="Logo KSR PMI UNPAS"
                >

                <h1>KSR PMI UNPAS</h1>

                <p>Unit Universitas Pasundan</p>

            </div>


            <div class="login-title">

                <h2>Login Admin</h2>

                <p>
                    Masuk untuk mengelola website KSR.
                </p>

            </div>


            <?php if ($error !== ""): ?>

                <div class="error-message">

                    <i class="bi bi-exclamation-circle"></i>

                    <?= htmlspecialchars($error) ?>

                </div>

            <?php endif; ?>


            <form method="POST">

                <div class="form-group">

                    <label for="username">
                        Username
                    </label>

                    <div class="input-wrapper">

                        <i class="bi bi-person"></i>

                        <input
                            type="text"
                            id="username"
                            name="username"
                            placeholder="Masukkan username"
                            autocomplete="username"
                            required
                        >

                    </div>

                </div>


                <div class="form-group">

                    <label for="password">
                        Password
                    </label>

                    <div class="input-wrapper password-wrapper">

                        <i class="bi bi-lock"></i>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Masukkan password"
                            autocomplete="current-password"
                            required
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            id="togglePassword"
                        >
                            <i class="bi bi-eye"></i>
                        </button>

                    </div>

                </div>


                <button
                    type="submit"
                    class="login-button"
                >
                    <i class="bi bi-box-arrow-in-right"></i>
                    &nbsp; Masuk ke Admin
                </button>

            </form>


            <a
                href="../index.php"
                class="back-link"
            >
                <i class="bi bi-arrow-left"></i>
                Kembali ke Website
            </a>

        </div>


        <div class="copyright">

            © <?= date("Y") ?> KSR PMI Unit Universitas Pasundan

        </div>

    </div>


    <script>

        const passwordInput =
            document.getElementById("password");

        const togglePassword =
            document.getElementById("togglePassword");

        togglePassword.addEventListener("click", function () {

            const icon = this.querySelector("i");

            if (passwordInput.type === "password") {

                passwordInput.type = "text";

                icon.classList.remove("bi-eye");

                icon.classList.add("bi-eye-slash");

            } else {

                passwordInput.type = "password";

                icon.classList.remove("bi-eye-slash");

                icon.classList.add("bi-eye");

            }

        });

    </script>

</body>

</html>