<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Happy Bird - ¡Bienvenido!</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fredoka+One&display=swap');

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Fredoka One', cursive, Arial, sans-serif;
            /* Aquí pongo la imagen de fondo desde la carpeta imagen */
            background: url('imagen/fondo.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
            text-align: center;
            padding: 20px;
            /* Para darle un ligero filtro oscuro y mejorar legibilidad */
            position: relative;
        }

        /* Capa oscura encima del fondo para que el texto se lea mejor */
        body::before {
            content: "";
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: -1;
        }

        .bird-icon {
            width: 120px;
            height: 120px;
            background: url('imagen/avatar2.jpg') no-repeat center center;
            background-size: contain;
            animation: bounce 2s infinite ease-in-out;
            margin-bottom: 25px;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0);}
            50% { transform: translateY(-20px);}
        }

        h1 {
            font-size: 3rem;
            color: #f9a825;
            text-shadow: 3px 3px #d48806;
            margin-bottom: 10px;
        }

        p.subtitle {
            font-size: 1.3rem;
            margin-bottom: 40px;
            color: #fff;
            text-shadow: 1px 1px 3px #000;
        }

        .btn-group {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
        }

        a.btn {
            background: #f9a825;
            color: white;
            padding: 15px 35px;
            border-radius: 35px;
            font-weight: bold;
            font-size: 1.1rem;
            text-decoration: none;
            box-shadow: 0 6px #c17900;
            transition: background 0.3s ease;
            min-width: 150px;
        }

        a.btn:hover {
            background: #fbc02d;
        }

        footer {
            position: absolute;
            bottom: 15px;
            font-size: 0.9rem;
            color: #ddd;
        }

        @media (max-width: 400px) {
            h1 {
                font-size: 2.2rem;
            }

            a.btn {
                padding: 12px 25px;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="bird-icon" aria-hidden="true"></div>
    <h1>¡Bienvenido a Happy Bird!</h1>
    <p class="subtitle">¡Desafía tus reflejos y vuela alto en este divertido juego!</p>
    <div class="btn-group">
        <a href="registro.php" class="btn" aria-label="Registrarse en Happy Bird">Registrarse</a>
        <a href="login.php" class="btn" aria-label="Iniciar sesión en Happy Bird">Iniciar sesión</a>
    </div>
    <footer>© 2025 Happy Bird - Hecho con 🐦 y código</footer>
</body>
</html>
