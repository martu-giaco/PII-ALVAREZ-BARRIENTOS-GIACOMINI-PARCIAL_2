<div class="container-contacto container-fluid py-5">
    <img src="assets/imagenes/contacto/contacto-banner.png" alt="banner contacto apple" class="img-fluid rounded-5 mb-5"
        style="max-height: 300px; object-fit: cover;">

    <h1 class="text-center mb-4">Asistencia al Cliente</h1>
    <p class="text-center mb-5 fs-5">
        Nuestro equipo de expertos en tecnología Apple está a su servicio para asistirlo con cualquier duda, problema o
        consulta que tenga.
    </p>

    <div class="row justify-content-center align-items-center gap-4">
        <div class="col-md-5">
            <img src="assets/imagenes/contacto/contacto-especialista.jpg" alt="especialista apple"
                class="img-fluid rounded-5 shadow-sm">
        </div>

        <div class="col-md-6">
            <form action="index.php" method="post" class="needs-validation" novalidate>
                <!-- Campo oculto para redirigir a la sección de enviado -->
                <input type="hidden" name="sec" value="contactoEnviado" />

                <div class="row g-3 mb-3">
                    <div class="col">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required>
                        <div class="invalid-feedback">Por favor ingrese su nombre.</div>
                    </div>
                    <div class="col">
                        <label for="apellido" class="form-label">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido" required>
                        <div class="invalid-feedback">Por favor ingrese su apellido.</div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                    <div class="invalid-feedback">Por favor ingrese un email válido.</div>
                </div>

                <div class="mb-4">
                    <label for="comentario" class="form-label">Contanos tu problema</label>
                    <textarea class="form-control" id="comentario" name="comentario" rows="4"
                        placeholder="Quería consultar sobre..." required></textarea>
                    <div class="invalid-feedback">Este campo es obligatorio.</div>
                </div>

                <button type="submit" class="btn btn-primary py-2 px-4">Consultar</button>
            </form>
        </div>
    </div>

    <section class="row align-items-center mt-5 gap-4">
        <div class="col-md-6">
            <h2>Cursos Apple: sacále el máximo provecho a tus dispositivos</h2>
            <p>
                Estos cursos están diseñados para que cualquier persona, sin importar su nivel de conocimiento previo,
                pueda aprender a usar de forma más completa y eficiente sus dispositivos Apple. A lo largo de las
                distintas sesiones, se abordan desde funciones básicas hasta herramientas más avanzadas que te permiten
                organizarte mejor, ser más productivo, y disfrutar aún más de la tecnología. Vas a aprender a configurar
                tus equipos, optimizar el uso de aplicaciones, cuidar la seguridad de tus datos y resolver dudas
                frecuentes. Ideal para quienes quieren ganar confianza digital y aprovechar todo el potencial de sus
                dispositivos.
            </p>
        </div>
        <div class="col-md-5">
            <img src="assets/imagenes/contacto/contacto-cursos.jpg" alt="cursos apple"
                class="img-fluid rounded-5 shadow-sm">
        </div>
    </section>

    <section class="row align-items-center mt-5 gap-4">
        <div class="col-md-5 order-md-2">
            <img src="assets/imagenes/contacto/contacto-charlas.jpg" alt="charlas apple"
                class="img-fluid rounded-5 shadow-sm">
        </div>
        <div class="col-md-6 order-md-1">
            <h2>Charlas educativas para estudiantes</h2>
            <p>
                Nuestras charlas están orientadas a estudiantes de primaria y secundaria, y buscan acercar la tecnología
                desde una perspectiva educativa, inclusiva y participativa. A través de encuentros dinámicos y
                contenidos pensados especialmente para cada nivel escolar, invitamos a los alumnos a reflexionar sobre
                el uso responsable de la tecnología, descubrir herramientas digitales para el estudio, y despertar
                habilidades clave como la creatividad, la comunicación y el pensamiento crítico. Es una oportunidad para
                aprender haciendo, compartir ideas y prepararse para los desafíos del mundo actual, tanto dentro como
                fuera del aula.
            </p>
        </div>
    </section>
</div>