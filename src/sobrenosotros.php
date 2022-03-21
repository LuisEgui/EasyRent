<?php

require_once __DIR__.'/includes/config.php';

$rutaApp = RUTA_IMGS;

$tituloPagina = 'Sobre Nosotros';

$contenidoPrincipal = <<<EOS
<header>
        <h2>Miembros</h2>
      </header>
      <article>
        <ul>
          <li>
            <a href="#almudena">Almudena Gómez-Sancha</a>
          </li>
        </ul>
        <ul>
          <li>
            <a href="#notkero">Notkero Gómez</a>
          </li>
        </ul>
        <ul>
          <li>
            <a href="#ivan">Iván Hernández</a>
          </li>
        </ul>
        <ul>
          <li>
            <a href="#luis">Luis Egui</a>
          </li>
        </ul>
        <ul>
          <li>
            <a href="#otero">Óscar Otero</a>
          </li>
        </ul>
        <ul>
          <li>
            <a href="#patri">Patricia Plata</a>
          </li>
        </ul>
      </article>

      <div id="almudena">
        <h2><strong>Almudena Gómez-Sancha </strong></h2>
        <p><strong>Correo electrónico: </strong></p>
        <p>almu@ucm.es</p>
        <p><strong>Foto: </strong></p>
        <img src="{$rutaApp}/1.jpg" />
        <p><strong>Descripción: </strong></p>
        <p>
          Aficionada a los juegos de ingenio. Es la más rápida en resolverlos.
        </p>
      </div>

      <div id="notkero">
        <h2><strong>Notkero Gómez </strong></h2>
        <p><strong>Correo electrónico: </strong></p>
        <p>notkero@ucm.es</p>
        <p><strong>Foto: </strong></p>
        <img src="{$rutaApp}/2.jfif" />
        <p><strong>Descripción: </strong></p>
        <p>
          Aficionado del deporte en general, del trabajo en grupo y las
          relaciones sociales.
        </p>
      </div>

      <div id="ivan">
        <h2><strong>Iván Hernández </strong></h2>
        <p><strong>Correo electrónico: </strong></p>
        <p>ivan@ucm.es</p>
        <p><strong>Foto: </strong></p>
        <img src="{$rutaApp}/3.jfif" />
        <p><strong>Descripción: </strong></p>
        <p>
          Aficionado a cantar en clase. El reggaeton antiguo es lo más para él.
        </p>
      </div>

      <div id="luis">
        <h2><strong>Luis Egui </strong></h2>
        <p><strong>Correo electrónico: </strong></p>
        <p>luis@ucm.es</p>
        <p><strong>Foto: </strong></p>
        <img src="{$rutaApp}/5.jpeg" />
        <p><strong>Descripción: </strong></p>
        <p>Aficionado a jugar a baloncesto. El mejor metiendo triples.</p>
      </div>

      <div id="otero">
        <h2><strong>Óscar Otero </strong></h2>
        <p><strong>Correo electrónico: </strong></p>
        <p>otero@ucm.es</p>
        <p><strong>Foto: </strong></p>
        <img src="{$rutaApp}/6.jpg" />
        <p><strong>Descripción: </strong></p>
        <p>
          Aficionado a las relaciones sociales. Se conoce hasta a la última
          persona que viva en Madrid.
        </p>
      </div>

      <div id="patri">
        <h2><strong>Patricia Plata </strong></h2>
        <p><strong>Correo electrónico: </strong></p>
        <p>patri@ucm.es</p>
        <p><strong>Foto: </strong></p>
        <img src="{$rutaApp}/4.jfif" />
        <p><strong>Descripción: </strong></p>
        <p>
          Aficionada a ver series en Netflix. La mejor haciendo recomendaciones.
        </p>
      </div>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';