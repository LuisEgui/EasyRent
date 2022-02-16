# Aplicaciones/Sistemas Web

> Este proyecto forma parte de las prácticas impartidas en la asignatura de AW/SW
> Está organizado por entregas: Entrega 0, 1, 2, 3 y 4

## Como colaborar

#### Requerimientos:

Hace falta hacer uso de [pre-commit](https://github.com/pre-commit/pre-commit) para el empleo de la herramienta de formateo de codigo [Prettier](https://prettier.io/) antes de los commits.

#### Instalacion: ala

1. Instalar `pre-commit`

- Para ello es necesario tener instalado [pip](https://pypi.org/project/pip/)
- Linux: `pip install pre-commit`

2. Si no existe, crear en el directorio raiz del proyecto, el archivo `.pre-commit-config.yaml` con la configuracion de [Prettier](https://prettier.io/) (obtenida de [aqui](https://prettier.io/docs/en/precommit.html)).
3. Ubicados en el directorio del proyecto (que apunta al [este](https://github.com/Missionpage/sw-practices) repositorio en Github), instalar la configuracion descrita en el archivo anteriormente mencionado, realizando:

- `pre-commit install`

* Si `pre-commit` no se ha agragado a las variables de entorno (PATH), se puede agregar antes de realizar el anterior comando, o bien, se puede ejecutar: `/home/<user>/.local/bin/pre-commit install`

#### Pasos para hacer una implementacion

1. Crear una nueva rama con **develop** como base en la que tendremos que subir todo lo que vayamos haciendo.
2. Cuando se haya implementado todo lo que se queria en la nueva rama; hay que hacer un **pull request** a la rama develop y en la descripcion poner: "Closes #(num. de la issue que se ha hecho)" .
3. (Opcional) Poner a una persona que revise la PR
4. Rellenar todas las demas opciones que da: quien se ha encargado de hacer el codigo, de que milestone es, a que proyecto corresponde, etc.
