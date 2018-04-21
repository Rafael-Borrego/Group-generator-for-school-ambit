<?php

    //Incluimos todas las funciones que utiliza el algoritmo
    include_once ("funciones.php");

   /*Se recogen los datos de los alumnos a través de un fichero json que se obtiene como un array asociativo con las
   características de los alumnos
   */
    $alumnos = leerFichero();
    if(empty($alumnos)){
        header('Location: esb.php?r=error');
    }
    else {
        //Se asignan los perfiles correspondientes a cada alumno
        asignacionPerfil($alumnos);

        //Se asignan los roles correspondientes a cada alumno
        asignacionRoles($alumnos);

        $listadoAlumnos = $alumnos;
        /**
         * Se lleva a cabo la cración de los grupos teniendo en cuenta las siguientes características en el siguiente orden:
         * 1º Cada grupo debe poseer un rol de los distintos tipos
         * 2º La suma de los puntos de los perfiles de los integrantes del grupo debe ser 20 o superior
         * 3º Los grupos deben posibilitar que el alumno se siente acorde a sus preferencias
         * 4º Los grupos deben poseer mas mujeres que hombres en la medida de lo posible
         **/

        $alumnosTotales = creacionGrupos($alumnos);

        $alumnosAgrupados = $alumnosTotales[0];
        $alumnosSobrantes = $alumnosTotales[1];
		$Coordinators = $alumnosTotales[2];
		$Environments = $alumnosTotales[3];
		$Speakers = $alumnosTotales[4];
		$Supervisors = $alumnosTotales[5];
		

        //Introducimos en la tabla los alumnos sobrantes
        introducirAlumnosSobrantes($alumnosSobrantes, $alumnosAgrupados);

        //Recalcular puntos del grupo
        for ($i = 0; $i < sizeof($alumnosAgrupados); $i++)
            $alumnosAgrupados[$i]["ValorGrupo"] = contarPuntosGrupo($alumnosAgrupados[$i]["Alumnos"]);
    }

?>