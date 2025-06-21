<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Flappy Bird Pantalla Completa</title>
  <style>
    html, body {
      margin: 0; padding: 0; height: 100%; overflow: hidden;
      background: #70c5ce;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      font-family: Arial, sans-serif;
      color: #444;
    }
    canvas {
      display: block;
      background: #70c5ce;
      width: 100vw;
      height: 100vh;
    }
    #score {
      position: fixed;
      top: 15px;
      left: 50%;
      transform: translateX(-50%);
      font-size: 24px;
      font-weight: bold;
      color: #fff;
      text-shadow: 1px 1px 2px #000;
      z-index: 10;
    }
    button.logout {
      position: fixed;
      bottom: 15px;
      left: 50%;
      transform: translateX(-50%);
      padding: 10px 25px;
      font-size: 18px;
      border-radius: 20px;
      border: none;
      background: #f9a825;
      color: white;
      cursor: pointer;
      box-shadow: 0 4px #c17900;
      z-index: 10;
    }
    button.logout:hover {
      background: #fbc02d;
    }

    #game-over {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%) scale(0.8);
      background: white;
      padding: 40px 50px;
      border-radius: 25px;
      text-align: center;
      box-shadow: 0 12px 25px rgba(0,0,0,0.3);
      z-index: 20;
      animation: popIn 0.4s ease-out forwards;
    }

    #game-over h2 {
      font-size: 32px;
      color: #444;
      margin: 0 0 10px;
    }

    #game-over p {
      font-size: 20px;
      margin: 0 0 20px;
    }

    #game-over button {
      padding: 12px 25px;
      font-size: 18px;
      border-radius: 30px;
      border: none;
      background: #f9a825;
      color: white;
      cursor: pointer;
      box-shadow: 0 4px #c17900;
      transition: background 0.3s;
    }

    #game-over button:hover {
      background: #fbc02d;
    }

    @keyframes popIn {
      from {
        opacity: 0;
        transform: translate(-50%, -50%) scale(0.5);
      }
      to {
        opacity: 1;
        transform: translate(-50%, -50%) scale(1);
      }
    }

    /* Pantalla de inicio */
    #start-screen {
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: #70c5ce;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      z-index: 30;
    }

    #start-screen h1 {
      font-size: 48px;
      margin-bottom: 20px;
      color: white;
      text-shadow: 2px 2px 4px #000;
    }

    #start-screen button {
      padding: 15px 30px;
      font-size: 22px;
      border-radius: 30px;
      border: none;
      background: #f9a825;
      color: white;
      cursor: pointer;
      box-shadow: 0 4px #c17900;
    }

    #start-screen button:hover {
      background: #fbc02d;
    }
  </style>
</head>
<body>
  <div id="start-screen">
    <h1>Flappy Bird</h1>
    <button onclick="startGame()">Comenzar juego</button>
  </div>

  <div id="score">Puntaje: 0</div>
  <canvas id="game"></canvas>
  <button class="logout" onclick="location.href='logout.php'">Cerrar sesión</button>
  
  <div id="game-over">
    <h2>Has perdido</h2>
    <p>Puntaje: <span id="final-score">0</span></p>
    
    <button onclick="restartGame()">Volver a intentar</button>
  </div>

  <script>
  const canvas = document.getElementById('game');
  const ctx = canvas.getContext('2d');

  let width, height;
  let bird, pipes, score, gameOver;
  let fondoX = 0;

  //tubo superior
  const tuboSuperiorImg = new Image();
  tuboSuperiorImg.src = 'imagen/superior.png';

  //fondo tubo inferior
  const tuboInferiorImg = new Image();
  tuboInferiorImg.src = 'imagen/inferior.png';

  //fondo de la pagina
  const fondo = new Image();
  fondo.src = 'imagen/fondo.png'; // 🌄 Imagen de fondo
  //imagen del avatar
  const GAP = 130;
  const birdImg = new Image();
  birdImg.src = 'imagen/avatar2.jpg';

  function resize() {
    width = window.innerWidth;
    height = window.innerHeight;
    canvas.width = width;
    canvas.height = height;
  }

  window.addEventListener('resize', resize);
  resize();

  function initGame() {
    bird = { x: width * 0.15, y: height / 2, vy: 0 };
    pipes = [];
    score = 0;
    gameOver = false;
    fondoX = 0;
    
    document.getElementById('score').innerText = "Puntaje: 0";
    document.getElementById('game-over').style.display = 'none';
    update();
  }

  function drawBackground() {
    fondoX -= 1; // Velocidad del fondo

    if (fondoX <= -width) fondoX = 0;

    ctx.drawImage(fondo, fondoX, 0, width, height);
    ctx.drawImage(fondo, fondoX + width, 0, width, height);
  }

  function drawBird() {
    const birdWidth = 40, birdHeight = 40;
    ctx.drawImage(birdImg, bird.x - birdWidth / 2, bird.y - birdHeight / 2, birdWidth, birdHeight);
  }

  function drawPipes() {
    pipes.forEach(pipe => {
      const tuboSuperiorAltura = pipe.top;
      const tuboInferiorAltura = height - (pipe.top + GAP);

      // Tubo superior (desde la parte superior de la pantalla hacia abajo)
      ctx.drawImage(tuboSuperiorImg, pipe.x, 0, 40, tuboSuperiorAltura);

      // Tubo inferior (desde el GAP hacia el fondo)
      ctx.drawImage(tuboInferiorImg, pipe.x, pipe.top + GAP, 40, tuboInferiorAltura);
    });
  }

  function update() {
    if (gameOver) return;

    ctx.clearRect(0, 0, width, height);
    drawBackground(); // ✅ Dibujar fondo

    bird.vy += 0.5;
    bird.y += bird.vy;

    if (bird.y > height || bird.y < 0) endGame();

    if (pipes.length === 0 || pipes[pipes.length - 1].x < width * 0.7) {
      let top = Math.random() * (height * 0.6) + height * 0.1;
      pipes.push({ x: width, top: top, passed: false });
    }

    pipes.forEach(pipe => {
      pipe.x -= 3;

      if (
        bird.x + 20 > pipe.x && bird.x - 20 < pipe.x + 40 &&
        (bird.y - 20 < pipe.top || bird.y + 20 > pipe.top + GAP)
      ) endGame();

      if (!pipe.passed && pipe.x + 40 < bird.x) {
        score++;
        pipe.passed = true;
        document.getElementById('score').innerText = "Puntaje: " + score;
      }
    });

    pipes = pipes.filter(pipe => pipe.x > -40);
    drawPipes();
    drawBird();
    requestAnimationFrame(update);
  }

  function endGame() {
    gameOver = true;
    document.getElementById('final-score').innerText = score;

    fetch('save_score.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'score=' + score
    });

    // Obtener y mostrar mejor puntaje
    fetch('get_best_score.php')
      .then(response => response.json())
      .then(data => {
        document.getElementById('best-score').innerText = data.best_score ?? 0;
      });

    const gameOverBox = document.getElementById('game-over');
    gameOverBox.style.display = 'block';
    gameOverBox.style.animation = 'none';
    void gameOverBox.offsetWidth;
    gameOverBox.style.animation = 'popIn 0.4s ease-out forwards';
  }

  function restartGame() {
    initGame();
  }

  function startGame() {
    document.getElementById('start-screen').style.display = 'none';
    initGame();
  }

  document.addEventListener('keydown', e => {
    if (e.code === 'Space' && !gameOver) bird.vy = -7;
  });

  canvas.addEventListener('click', () => {
    if (!gameOver) bird.vy = -7;
  });

  // initGame(); ← ya no lo llamamos directamente, se espera al clic de inicio
  </script>
</body>
</html>