<?php
session_start();
$conn = new mysqli('localhost', 'root', '1234', 'flappybird');

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($id, $hash);
    if ($stmt->fetch() && password_verify($_POST['password'], $hash)) {
        $_SESSION['user_id'] = $id;
        header("Location: game.php");
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Login Happy Bird</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fredoka+One&display=swap');

        body {
            background: linear-gradient(to top, #87ceeb 0%, #fffacd 100%);
            font-family: 'Fredoka One', cursive, Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #444;
        }

        .container {
            background: #fff;
            border-radius: 20px;
            padding: 30px 40px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            text-align: center;
            width: 320px;
            position: relative;
        }

        h1 {
            color: #f9a825;
            margin-bottom: 25px;
            text-shadow: 2px 2px #d48806;
            font-size: 2.2rem;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            margin: 10px 0 20px;
            border: 2px solid #f9a825;
            border-radius: 30px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus, input[type="password"]:focus {
            outline: none;
            border-color: #fbc02d;
            box-shadow: 0 0 8px #fbc02d;
        }

        input[type="submit"] {
            background: #f9a825;
            border: none;
            padding: 12px 0;
            width: 100%;
            border-radius: 30px;
            color: #fff;
            font-weight: bold;
            font-size: 1.1rem;
            cursor: pointer;
            box-shadow: 0 6px #c17900;
            transition: background 0.3s ease;
        }

        input[type="submit"]:hover {
            background: #fbc02d;
        }

        .error {
            background-color: #f9d6d5;
            color: #b71c1c;
            border: 2px solid #b71c1c;
            border-radius: 15px;
            padding: 12px;
            margin-bottom: 15px;
            font-weight: bold;
        }

        /* Happy Bird style: little bird icon on top */
        .bird-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 15px;
            background: url('imagen/avatar2.jpg') no-repeat center center;
            background-size: contain;
            animation: bounce 2s infinite ease-in-out;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0);}
            50% { transform: translateY(-15px);}
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="bird-icon" aria-hidden="true"></div>
        <h1>Iniciar sesión Happy Bird</h1>

        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post" autocomplete="off">
            <input type="text" name="username" placeholder="Usuario" required />
            <input type="password" name="password" placeholder="Contraseña" required />
            <input type="submit" value="Iniciar sesión" />
        </form>
    </div>
</body>
</html>
