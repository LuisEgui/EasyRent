<?php

require_once '../vendor/autoload.php';
require_once __DIR__.'/includes/config/config.php';

$rutaApp = RUTA_IMGS;

$tituloPagina = 'Sobre Nosotros';

$contenidoPrincipal = <<<EOS
<header>
        <h2>Miembros</h2>
      </header>
      <article>
        <ul>
          <li>
            <a class="atajoMiembro" href="#almudena">Almudena Gómez-Sancha</a>
          </li>
        </ul>
        <ul>
          <li>
            <a class="atajoMiembro" href="#notkero">Notkero Gómez</a>
          </li>
        </ul>
        <ul>
          <li>
            <a class="atajoMiembro" href="#ivan">Iván Hernández</a>
          </li>
        </ul>
        <ul>
          <li>
            <a class="atajoMiembro" href="#luis">Luis Egui</a>
          </li>
        </ul>
        <ul>
          <li>
            <a class="atajoMiembro" href="#otero">Óscar Otero</a>
          </li>
        </ul>
        <ul>
          <li>
            <a class="atajoMiembro" href="#patri">Patricia Plata</a>
          </li>
        </ul>
      </article>

      <div id="almudena">
        <h2 class="tituloNombre" ><strong>Almudena Gómez-Sancha </strong></h2>
        <p class="tituloCorreo"><strong>Correo electrónico: </strong></p>
        <p class="correoMiembro">almu@ucm.es</p>
        <img class="fotoMiembro" src="{$rutaApp}/1.jpg" alt="Profile Img"/>
        <p class="tituloDescripcion"><strong>Descripción: </strong></p>
        <p class="descripcionMiembro">
          Aficionada a los juegos de ingenio. Es la más rápida en resolverlos.
        </p>
      </div>

      <div id="notkero">
        <h2 class="tituloNombre" ><strong>Notkero Gómez </strong></h2>
        <p class="tituloCorreo"><strong>Correo electrónico: </strong></p>
        <p class="correoMiembro">notkero@ucm.es</p>
        <img class="fotoMiembro" src="{$rutaApp}/2.jfif" alt="Profile Img"/>
        <p class="tituloDescripcion"><strong>Descripción: </strong></p>
        <p class="descripcionMiembro">
          Aficionado del deporte en general, del trabajo en grupo y las
          relaciones sociales.
        </p>
      </div>

      <div id="ivan">
        <h2 class="tituloNombre" ><strong>Iván Hernández </strong></h2>
        <p class="tituloCorreo"><strong>Correo electrónico: </strong></p>
        <p class="correoMiembro">ivan@ucm.es</p>
        <img class="fotoMiembro" src="{$rutaApp}/3.jfif" alt="Profile Img"/>
        <p class="tituloDescripcion"><strong>Descripción: </strong></p>
        <p class="descripcionMiembro">
          Aficionado a cantar en clase. El reggaeton antiguo es lo más para él.
        </p>
      </div>

      <div id="luis">
        <h2 class="tituloNombre" ><strong>Luis Egui </strong></h2>
        <p class="tituloCorreo"><strong>Correo electrónico: </strong></p>
        <p class="correoMiembro">luis@ucm.es</p>
        <img class="fotoMiembro" src="{$rutaApp}/5.jpeg" alt="Profile Img"/>
        <p class="tituloDescripcion"><strong>Descripción: </strong></p>
        <p class="descripcionMiembro">
          Aficionado a jugar a baloncesto. El mejor metiendo triples.</p>
      </div>

      <div id="otero">
        <h2 class="tituloNombre" ><strong>Óscar Otero </strong></h2>
        <p class="tituloCorreo"><strong>Correo electrónico: </strong></p>
        <p class="correoMiembro">otero@ucm.es</p>
        <img class="fotoMiembro" src="{$rutaApp}/6.jpg" alt="Profile Img"/>
        <p class="tituloDescripcion"><strong>Descripción: </strong></p>
        <p class="descripcionMiembro">
          Aficionado a las relaciones sociales. Se conoce hasta a la última
          persona que viva en Madrid.
        </p>
      </div>

      <div id="patri">
        <h2 class="tituloNombre" ><strong>Patricia Plata </strong></h2>
        <p class="tituloCorreo"><strong>Correo electrónico: </strong></p>
        <p class="correoMiembro">patri@ucm.es</p>
        <img class="fotoMiembro" src="{$rutaApp}/4.jfif" alt="Profile Img"/>
        <p class="tituloDescripcion"><strong>Descripción: </strong></p>
        <p class="descripcionMiembro">
          Aficionada a ver series en Netflix. La mejor haciendo recomendaciones.
        </p>
      </div>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
