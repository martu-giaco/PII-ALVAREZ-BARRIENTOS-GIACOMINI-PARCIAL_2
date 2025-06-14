<div class="container-contacto container-fluid">
<img src="assets/imagenes/contacto/contacto-banner.png" class="mt-3 mb-5 img-fluid rounded-5" alt="banner contacto apple">
<h1 class="text-center mt-5">Asistencia al Cliente</h1>
<p class="text-center mt-4 ">Nuestro equipo de expertos en tecnología Apple están a su servicio para asistirlo con cualquier duda, problema o consulta que tenga.</p>

<div class="d-flex justify-content-center align-items-center p-5">
    <img class="img-fluid rounded-5" src="assets/imagenes/contacto/contacto-especialista.jpg" alt="especialista apple">
    <form class="container px-5" action="?sec='contacto'" method="get" style="width: 80rem;">
        <?php
            if (isset($_GET['sec']) && $_GET['sec'] === 'contacto') {
        ?>
        <input type="hidden" name="sec" value="enviado" />
        <?php
            }
        ?>

        <div class="d-flex justify-content-between">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre">
            </div>
            <div class="mb-3">
                <label for="apellido" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido" placeholder="apellido">
            </div>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email">
        </div>
        <div class="mb-3">
            <label for="comentario" class="form-label">Contanos tu problema</label>
            <textarea class="form-control" id="comentario" rows="3" name="comentario" placeholder="Quería consultar sobre..."></textarea>
        </div>

        <input type="submit" value="Consultar" class="btn btn-primary mb-3 py-2">
    </form>
</div>

<section class="p-5 d-flex">
    <div class="p-5">
        <h2>Cursos Apple: sacále el máximo provecho a tus dispositivos</h2>
        <p>Estos cursos están diseñados para que cualquier persona, sin importar su nivel de conocimiento previo, pueda aprender a usar de forma más completa y eficiente sus dispositivos Apple. A lo largo de las distintas sesiones, se abordan desde funciones básicas hasta herramientas más avanzadas que te permiten organizarte mejor, ser más productivo, y disfrutar aún más de la tecnología. Vas a aprender a configurar tus equipos, optimizar el uso de aplicaciones, cuidar la seguridad de tus datos y resolver dudas frecuentes. Ideal para quienes quieren ganar confianza digital y aprovechar todo el potencial de sus dispositivos.</p>
    </div>
        <img class="img-fluid rounded-5 m-3" src="assets/imagenes/contacto/contacto-cursos.jpg" alt="cursos apple">
</section>

<section class="p-5 d-flex">
    <img class="img-fluid rounded-5 m-3" src="assets/imagenes/contacto/contacto-charlas.jpg" alt="charlas apple">
    <div class="p-5">
        <h2>Charlas educativas para estudiantes</h2>
        <p>Nuestras charlas están orientadas a estudiantes de primaria y secundaria, y buscan acercar la tecnología desde una perspectiva educativa, inclusiva y participativa. A través de encuentros dinámicos y contenidos pensados especialmente para cada nivel escolar, invitamos a los alumnos a reflexionar sobre el uso responsable de la tecnología, descubrir herramientas digitales para el estudio, y despertar habilidades clave como la creatividad, la comunicación y el pensamiento crítico. Es una oportunidad para aprender haciendo, compartir ideas y prepararse para los desafíos del mundo actual, tanto dentro como fuera del aula.</p>
    </div>
</section>
</div>