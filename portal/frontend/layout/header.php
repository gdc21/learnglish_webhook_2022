<?php $this->temp['perfiles'] = array(1, 3, 4, 5, 6, 7); ?>
<?php
/**
 * Verifica en la seccion de modulos si esta habilitada esta opcion, tbl:lg00043
 */
if (verificaModuloSistemaActivo('integracionGsuite')) { ?>
    <header style="height: 12vh; display: flex; align-items: center;">
        <style>
            @media screen and (max-width: 1300px) {
                header {
                    height: auto !important;
                    min-height: 9vh !important;
                }

                #imagenPresentacion {
                    padding: 2px 2px !important;
                    height: 8vh !important;
                }
            }

            @media screen and (max-width: 820px) {
                header {
                    min-height: 6vh !important;
                }

                #imagenPresentacion {
                    height: 5vh !important;
                }
            }
        </style>
    <?php } else { ?>
        <header>
        <?php } ?>


        <?php if (!isset($_SESSION["userLogged"]) || $_SESSION["tipoSesion"] == 2) { ?>
            <a class="hide" data-toggle="modal" href='#loginForm' id="btnLogin"></a>
            <div aria-hidden="true" aria-labelledby="Login" role="dialog" tabindex="-1" id="loginForm" class="modal fade" style="display: none;">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            <!-- <button data-bs-dismiss="modal" class="close" type="button">
                                <span aria-hidden="true">×</span> <span class="sr-only">Close</span>
                            </button> -->
                            <h4 id="myModalLabel" class="modal-title">
                                <center>Acceso</center>
                            </h4>
                        </div>

                        <form id="startSession" novalidate="novalidate" autocomplete="off">
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-login" role="tabpanel" aria-labelledby="nav-login-tab">
                                    <div class="modal-body">
                                        <div>
                                            <label for="uname">Usuario:</label><br>
                                        </div>
                                        <div>
                                            <span class="error"></span> <input type="text" id="uname" name="uname" class="form-control" onfocus="document.getElementById('uname').focus();">
                                        </div>
                                        <div>
                                            <br> <label for="pw">Contraseña:</label> <br>
                                        </div>
                                        <div>
                                            <span class="error"></span>
                                            <input type="password" autocomplete="off" id="pw" name="pw" class="form-control">
                                        </div>
                                        <br> <span class="error-login error"></span>
                                        <div id="recoverpass" style="text-align: right;">
                                            <a href="#">Olvide mi contraseña</a>
                                        </div>
                                        <br>
                                        <input type="checkbox" id="check" onchange="muestraPassword()">
                                        <label for="check">Mostrar contraseña</label>
                                        <br>
                                        <a href="#" id=""></a>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="submit" value="Ingresar" class="btn btn-primary">
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-recover" role="tabpanel">
                                    <div class="modal-body">
                                        <div>
                                            <label for="ruser">Ingresa tu usuario:</label><br>
                                        </div>
                                        <div>
                                            <input type="text" id="ruser" name="ruser" class="form-control" placeholder="Ingresa un usuario">
                                            <br>
                                            <div id="mensaje-recuperar" class="alert bg-warning text-dark" role="alert" style="font-size: 14px; display: none;"></div>
                                        </div>
                                        <br>
                                        <div id="login-form" style="text-align: right;">
                                            <a href="#">Iniciar sesión</a>
                                        </div>
                                        <br>
                                        <div class="modal-footer">
                                            <button id="recuperar" class="btn btn-primary">Recuperar contraseña</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>
        <nav>
            <ul id="menu" class="d-flex align-items-center">
                <?php
                $url = "";
                $text = 'Log in';
                $inicio = 'inicio';
                $boton_id = 'loginBtn';
                if (isset($_SESSION['userLogged']) && $_SESSION["tipoSesion"] == 1) {
                    $url = CONTEXT . "/home/menu";
                    $text = 'Salir';
                    $boton_id = 'logoutBtn';
                    $inicio = 'inicio_m';
                }
                if (isset($_SESSION['userLogged']) && $_SESSION["tipoSesion"] == 2) {
                    $url = CONTEXT . "/home/menu";
                    $text = 'Log in';
                    $boton_id = 'loginBtn';
                    $inicio = 'inicio';
                } else {
                    $url = "#";
                }
                // var_dump($_SESSION['log']);
                // var_dump($this->temp ['path_home']);
                ?>

                <li class="menu_inicio menus <?php if (isset($this->temp['retroseso'])) {
                                                    echo 'retroseso';
                                                } ?>"><i class="fa fa-home pages <?= $inicio ?>"></i></li>

                <?php
                /**
                 * Verifica en la seccion de modulos si esta habilitada esta opcion, tbl:lg00043
                 */
                if (verificaModuloSistemaActivo('ExamenTrimestral')) { ?>
                    <li class="align-items-center d-flex">
                        <i class="fa fa-pencil-square" style="margin: 10px;" aria-hidden="true"></i> <br>
                        <strong>
                            <a href="<?= CONTEXT ?>evaluaciontrimestral/evaluacionlistarlecciones" style="color: #000 !important">
                                Evaluación trimestral
                            </a>
                        </strong>
                    </li>
                <?php } ?>

                <?php if (isset($_SESSION["perfil"]) && ($_SESSION["perfil"] == 1 || $_SESSION["perfil"] == 3 || $_SESSION["perfil"] == 4)) { ?>
                    <li class="menu_inicio menus <?php if (isset($this->temp['retroseso'])) {
                                                        echo 'retroseso';
                                                    } ?>">
                        <strong><a href="<?= CONTEXT ?>admin/manager" style="color: #000 !important">Menú</a></strong>
                    </li>
                <?php } else if ($_SESSION['perfil'] == 6) { ?>
                    <li class="menu_inicio menus <?php if (isset($this->temp['retroseso'])) {
                                                        echo 'retroseso';
                                                    } ?>"><a href="<?= CONTEXT ?>home/teacher/">Menú</a></li>
                <?php } elseif ($_SESSION['perfil'] == 7) { ?>
                    <li class="menu_inicio menus <?php if (isset($this->temp['retroseso'])) {
                                                        echo 'retroseso';
                                                    } ?>"><a href="<?= CONTEXT ?>home/tutor/">Menú</a></li>
                <?php } ?>
                <?php
                /**
                 * Verifica en la seccion de modulos si esta habilitada esta opcion, tbl:lg00043
                 */
                if (verificaModuloSistemaActivo('integracionGsuite')) { ?>
                    <ul class="menu_second" style="top: 0 !important; height: 100%; display: flex; align-items: center;">
                    <?php } else { ?>

                        <ul class="menu_second">
                        <?php } ?>

                        <?php if (isset($_SESSION['userLogged'])) {
                            $login = (new Administrador())->informacionUsuario($_SESSION['idUsuario']);
                            #$nombre = $login[0]['LGF0010002']." ".$login[0]['LGF0010003']." ".$login[0]['LGF0010004'];
                            $nombre = $login[0]['LGF0010002'];
                            if ($_SESSION['perfil'] == 1) { // Admin
                                $titulo = "Administrador: " . $nombre;
                            } else if ($_SESSION['perfil'] == 2) { // Usuario/alumno
                                $titulo = $login[0]['institucion'] . ": " . $nombre;
                            } else if ($_SESSION['perfil'] == 3) { // Cliente
                                $titulo = "Cliente: " . $_SESSION['nombre'];
                            } else if ($_SESSION['perfil'] == 4) { // Institucion
                                $titulo = "Institución: " . $_SESSION['nombre'];
                            } else if ($_SESSION['perfil'] == 5) { // Demo
                                $titulo = "Usuario demo: " . $nombre;
                            } else if ($_SESSION['perfil'] == 6) { // Docente
                                $titulo = "Docente: " . $nombre;
                            } else if ($_SESSION['perfil'] == 7) { // Tutor
                                $titulo = "Tutor: " . $nombre;
                            }
                            #$titulo = $nombre;
                        ?>
                            <!-- <li><strong><?php echo $titulo; ?></strong></li> -->
                        <?php } ?>
                        <?php if (isset($_SESSION['userLogged'])) {
                            /**
                             * Verifica en la seccion de modulos si esta habilitada esta opcion, tbl:lg00043
                             */
                            if (verificaModuloSistemaActivo('SistemaCache')) { ?>
                                <li>
                                    <a href="<?= CONTEXT ?>home/borrarcache/learn12" target="_blank">Cache</a>
                                </li>
                            <?php } ?>
                            <li>
                                <div class="dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropdownMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                        <strong><?php echo $titulo; ?></strong>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-lg-end">
                                        <a href="<?= CONTEXT ?>Home/profile"><i class="fa fa-user" aria-hidden="true"></i> Mi Perfil</a>
                                        <a href="https://translate.google.com.mx/" target="_blank"><i class="fa fa-book" aria-hidden="true"></i> Diccionario</a>

                                        <?php if (verificaModuloSistemaActivo('MenuRecursos')) : ?>
                                            <a href="https://www.youtube.com/@learnglishpro6011" target="_blank"><i class="fa fa-globe"></i> Videos introductorios</a>
                                            <a href="https://www.bibliotechnia.com.mx/auth/exception_access/UrYiZ3AmNOKNueyAP3po8ifMfhNs-63rjOzk2PBj0TQ=" target="_blank"><i class="fa fa-globe"></i> Libros digitales</a>
                                            <a href="https://teachers.learnglishpro.com/Courses/" target="_blank"><i class="fa fa-globe"></i> Ideas para proyectos transversales</a>
                                            <a href="http://www.hopinadigital.com.mx/" target="_blank"><i class="fa fa-globe"></i> Sitios Web recomendados y Juegos para computadoras y dispositivos móviles.</a>
                                        <?php endif; ?>

                                        <!-- <a id="abrir-traslate" ><i class="fa fa-book" aria-hidden="true" style="color: #000 !important; font-size: 20px !important;"></i> Traductor</a> -->
                                        <a id="<?= $boton_id ?>"><i class="fa fa-sign-out" aria-hidden="true"></i> <?= $text ?></a>
                                    </ul>
                                </div>
                            </li>
                        <?php } else { ?>

                            <li>
                                <?php
                                /**
                                 * Verifica en la seccion de modulos si esta habilitada esta opcion, tbl:lg00043
                                 */
                                if (verificaModuloSistemaActivo('integracionGsuite')) { ?>
                                    <img id="imagenPresentacion" src="<?php echo CONTEXT ?>/portal/IMG/glimg.png" style="background: rgba(255,255,255,0.7); height: 10vh; padding: 2px 15px; border-radius: 10px; max-height: 100% !important; margin-right: 10px; border: 2px solid rgba(255,255,255,0.4);">
                                <?php } ?>

                                <a id="<?= $boton_id ?>" class="menu-login">Ingresar</a>
                                <img src="<?php echo CONTEXT ?>/portal/IMG/login.png">
                            </li>
                        <?php } ?>

                        <li class="menu_inicio menus"></li>
                        <?php if (isset($_SESSION['userLogged']) && $_SESSION["tipoSesion"] == 2) { ?>
                            <li><a id="registro" class="menu-login" href="<?= CONTEXT . "auth/registro" ?>">Registrate</a></li>
                        <?php } ?>
                        <!-- <li><a id="<?= $boton_id ?>" class="menu-login"><?= $text ?></a></li> -->
                        </ul>
                    </ul>
        </nav>
        </header>
        <!--COMIENZA el div del CONTENIDO EN GENERAL -->