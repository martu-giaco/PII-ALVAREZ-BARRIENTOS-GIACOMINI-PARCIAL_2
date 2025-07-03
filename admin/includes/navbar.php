<?php
?>
<header class="container-fluid">
    <nav class="navbar navbar-expand-sm bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="?sec=inicio">
            <img src="../assets/imagenes/Apple_logo_black.svg" alt="apple-logo" style="height: 30px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
        <?php
            foreach (secciones_menu() as $value) {
            ?>
                <li class="nav-item">
                    <a  class="nav-link" href="?sec=<?= $value; ?>"><?= ucfirst(strtolower($value)); ?></a>
                </li>
            <?php
            }
        ?>
        </ul>
        </div>
    </div>
    </nav>
</header>
