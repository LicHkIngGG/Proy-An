<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="navbar">
            <div class="navbar-left">
                <a href="#">SGAPJ</a>
            </div>
            <div class="navbar-right">
                <a href="#">Menú</a>
                <a href="#">Inicia sesión como</a>
            </div>
        </div>
    </header>
    <main>
        <section class="main-content">
            <h1>Desarrollo de un Sistema Gamificado para el Aprendizaje de Programación en la Juventud</h1>
            <p>Página web de ayuda a aprender programación a nivel básico en estudiantes de colegio.</p>
            <p>Estos cursos vienen certificados por los docentes en la plataforma que te ayudarán en tu camino, estos módulos van de manera secuencial. Esto te permitirá a mantener un progreso continuo y constante</p>
            <p>Gracias por escogernos como alternativa a tu aprendizaje.</p>
            <button id="openIDE">Abrir Online IDE</button>
        </section>
    </main>

    <!-- Modal for Online IDE -->
    <div id="ideModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <iframe src="Online_IDE.html" width="100%" height="500px"></iframe>
        </div>
    </div>

    <script>
        var modal = document.getElementById("ideModal");
        var btn = document.getElementById("openIDE");
        var span = document.getElementsByClassName("close")[0];

        btn.onclick = function() {
            modal.style.display = "block";
        }

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
