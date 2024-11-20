<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi EPS</title>
    <link rel="stylesheet" href="styles.css?v=1.0">
</head>
<body>
    <header>
        <div class="logo">
            <h1 class="title">MediEPS</h1>
        </div>
        
        <div class="menu">
            <nav>
                <ul>
                    <li><a href="#home">Inicio</a></li>
                    <li><a href="#services">Nosotros</a></li>
                    <li><a href="CRUD/crear_afiliado.php">Afiliate Aquí</a></li>
                    <li><a href="CRUD/planes.php">Planes complementarios</a></li>  
                </ul>
            </nav>
        </div>
    </header>

    <section id="home">
        <h2>Tu salud, es nuestra prioridad</h2>
        <p>En MediEPS nos esforzamos por brindar servicios de salud de calidad a todos nuestros afiliados.</p>
    </section>

    <section id="services">
        <h2>Servicios de la EPS</h2>
        <div class="service-card">
            <h3>Atención Primaria</h3>
            <p>Consulta médica general y de urgencias.</p>
        </div>
        <div class="service-card">
            <h3>Especialidades Médicas</h3>
            <p>Atención en cardiología, pediatría, neurología, y más.</p>
        </div>
        <div class="service-card">
            <h3>Laboratorios Clínicos</h3>
            <p>Pruebas de diagnóstico para asegurar tu bienestar.</p>
        </div>
        <div class="service-card">
            <h3>Autorizaciones</h3>
            <p>Solicita autorizaciones.</p>
        </div>
    </section>

    <section id="about">
        <h2>Acerca MediEPS</h2>
        <p>MediEPS es una organización de salud comprometida con el bienestar de sus afiliados, brindando atención y servicios de calidad.</p>
    </section>

    <section id="contact">
        <h2>Contacto</h2>
        <p>¿Tienes dudas? Contáctanos:</p>
        <!-- Formulario apunta a procesar_contacto.php -->
        <form action="procesar_contacto.php" method="POST">
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="message">Mensaje:</label>
            <textarea id="message" name="message" required></textarea>
            
            <button type="submit">Enviar</button>
        </form>
    </section>

    <footer>
        <p>&copy; 2024 MediEPS</p>
    </footer>
</body>
</html>
