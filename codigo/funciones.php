
<?php

    /**
     * Función que lee el fichero json con los datos de los alumnos devolviendo un array asociativo con los mismos
     * @function leerFichero
     * @return mixed*
     *
     */
    function leerFichero()
    {

        $data = file_get_contents("AlumnosIntro.json");
        $alumnos = json_decode($data, true);

        return $alumnos;
    }

    /**
     * Función que muestra un array asociativo de forma visible
     * @function mostrarJson
     * @param $alumnos
     */
    function mostrarJson(&$alumnos){
            echo "<pre>";
            print_r($alumnos);
            echo "</pre>";
    }

    /**
     *  Función que muestra los datos referentes a los alumnos
     * @function mostrarAlumnosGrupos
     * @param $grupos
     */
    function mostrarAlumnosGrupos($grupos)
    {
        print_r("<br><b>GRUPOS</b><br>");
        for ($i = 0; $i < sizeof($grupos); $i++) {
            print_r("<b>grupos:$i</b><br>");
            for ($j = 0; $j < sizeof($grupos[$i]["Alumnos"]); $j++) {

                print_r($grupos[$i]["Alumnos"][$j]["Nombre"]);
                print_r(" ");
                print_r($grupos[$i]["Alumnos"][$j]["Rol"]);
                print_r("Perfil: ");
                print_r($grupos[$i]["Alumnos"][$j]["Perfil"]);
                print_r(" No se quiere sentar: ");
                print_r($grupos[$i]["Alumnos"][$j]["No quiero Sentarme"]);
                print_r("Sexo: ");
                if($grupos[$i]["Alumnos"][$j]["Sexo"]) print_r("Hombre");
            else print_r("Mujer");
                print_r("<br>");
            }
            echo "Valor grupos: " . $grupos[$i]["ValorGrupo"] . "<br>";
        }

    }

    /**
     *   Función que asigna los perfiles de cada alumno atendiendo a sus características
     * @function asignacionPerfil
     * @param $alumnos
     */
    function asignacionPerfil(&$alumnos)
    {
            //Recorremos el array de los alumnos
            for ($i = 0; $i < sizeof($alumnos); $i++) {
                //Obtenemos los valores de las variables
                $capacidad_de_ayudar = $alumnos[$i]['Es capaz de ayudar'];
                $necesidad_de_ayuda = $alumnos[$i]['Necesito ayuda'];

                /*Asignación de un único perfil a cada alumno*/
                /*Asignación del perfil AB*/
                if ($capacidad_de_ayudar > 2 && $necesidad_de_ayuda < 1) {
                    $alumnos[$i]["Perfil"] = "AB";
                }
                /*Asignación del perfil C*/
                else if ($capacidad_de_ayudar >= 1 && $necesidad_de_ayuda >= 1) {
                    $alumnos[$i]["Perfil"] = "C";
                }
                /*Asignación del perfil DE*/
                else {
                    $alumnos[$i]["Perfil"] = "DE";
                }

            }

    }


    /**Función que lleva acabo la asignación de los roles a cada alumno atendiendo a sus habilidades
     * @function asignacionRoles
     * @param $alumnos
     */
    function asignacionRoles(&$alumnos)
    {
        //Recorremos todos los alumnos
        for ($i = 0; $i < sizeof($alumnos); $i++) {

            //Obtenemos el valor de cada habilidad
            $organizacion = $alumnos[$i]['Organización'];
            $liderazgo = $alumnos[$i]['Liderazgo'];
            $decision = $alumnos[$i]['Decision-Participacion'];
            $orden = $alumnos[$i]['Orden clase'];

            /*Incializamos la caracteristica del ROL a un array ya que un alumno puede tener varios roles*/
            $alumnos[$i]["Rol"] = array();
            //Asignamos los roles de cada alumno aplicando filtros a sus habilidades
            /*Para el ROL: coordinator*/
            if ($organizacion >= 4 && $liderazgo >= 4 && $decision >= 3 && $orden >= 3) {
                array_push($alumnos[$i]["Rol"], "Coordinator");
            }
            /*Para el ROL: environment*/
            if ($organizacion >= 3 && $liderazgo >= 3 && $decision >= 3 && $orden >= 4) {
                array_push($alumnos[$i]["Rol"], "Environment");
            }
            /*Para el ROL: Speaker*/
            if ($liderazgo >= 3 && $decision >= 4) {
                array_push($alumnos[$i]["Rol"], "Speaker");
            }
            /*Para el ROL: Supervisor*/
            if ($organizacion >= 4 && $liderazgo >= 3) {
                array_push($alumnos[$i]["Rol"], "Supervisor");
            }
        }
    }


    /**
     * Función que cuenta los puntos que posee un grupo atendiendo a los perfiles de sus alumnos
     * @function contarPuntosGrupo
     * @param $grupo
     * @return int
     */
    function contarPuntosGrupo($grupo)
    {

        $ab = 0;
        $c = 0;
        $de = 0;

        for ($i = 0; $i < sizeof($grupo); $i++) {
            if (strcmp($grupo[$i]["Perfil"], "AB") == 0) $ab += 10;
            if (strcmp($grupo[$i]["Perfil"], "C") == 0) $c += 5;
            if (strcmp($grupo[$i]["Perfil"], "DE") == 0) $de += 1;
        }

        return $ab + $c + $de;
    }

/** Función que lleva a cabo el proceso de creación y división en grupos teniendo en cuenta:
 *  1º Cada grupo debe poseer un alumno con cada uno de los siguientes roles (Coordinator, Environment ,Speaker, Supervisor).
 *  2º Cada grupo debe tener un perfil total aceptable, cumpliendo que tenga 20 o mas puntos en total.
 *  3º Tiene en cuenta las preferencias de cada alumno a la hora de crear los grupos
 *  4º Se tiene en cuenta la creación de grupos donde el número de mujeres predomina
 *
 *  Perfiles compatibles en cada grupo
 *  PUNTOS
 * AB = 10
 * C = 5
 * DE = 1
 *
 * MINIMO 20 puntos.
 *
 * AB AB AB AB -> 4AB
 * AB AB AB DE -> 3AB+1DE
 * AB AB DE DE -> 2AB + 2DE
 * AB AB AB C -> 3AB + 1C
 * AB AB C  C -> 2AB + 2C
 * AB C  C  C -> 1AB + 3C
 * AB AB DE C -> 2AB + 1DE + C
 * AB DE C  C -> 1AB + 1DE + 2C
 * C  C  C  C -> 4C
 *
 * @function creacionGrupos
 * @param $alumnos
 * @return array
 */
    function creacionGrupos($alumnos){
        /*
         * Separación de los alumnos atendiendo a sus roles
         */
        $Speakers = array();
        $Coordinators = array();
        $Supervisors = array();
        $Environments = array();

        //Se recorren todos los alumnos clasificandolos atendiendo a su rol
        for ($i = 0; $i < sizeof($alumnos); $i++) {

            for ($j = 0; $j < sizeof($alumnos[$i]['Rol']); $j++) {

                if (strcmp($alumnos[$i]['Rol'][$j], 'Speaker') == 0) {
                    array_push($Speakers, $alumnos[$i]);
                }
                if (strcmp($alumnos[$i]["Rol"][$j], "Coordinator") == 0) {
                    array_push($Coordinators, $alumnos[$i]);
                }
                if (strcmp($alumnos[$i]["Rol"][$j], "Supervisor") == 0) {
                    array_push($Supervisors, $alumnos[$i]);
                }
                if (strcmp($alumnos[$i]["Rol"][$j], "Environment") == 0) {
                    array_push($Environments, $alumnos[$i]);
                }
            }

        }

        //Variable que almacena alumnos separados por rol
        $roles = array();
        array_push($roles, $Coordinators);
        array_push($roles, $Environments);
        array_push($roles, $Speakers);
        array_push($roles, $Supervisors);

        //Cada grupo poseerá 4 integrantes por lo que dividiendo la cantidad de alumnos entre 4 obtenemos el número de grupo
        $numeroGrupos = sizeof($alumnos) / 4;

        $grupos = array();

        /**
        Posiciones array RolesCompletos
            0 -> Coordinator
            1 ->Environment
            2 ->Speaker
            3 ->Supervisor
         * */

        //Recorremos los grupos
        for ($i = 0; $i < $numeroGrupos; $i++) {

            //Añadimos a cada grupo las características "Roles Completos", "Alumnos", "ValorGrupo"
            array_push($grupos, ["RolesCompletos" => [0, 0, 0, 0], "Alumnos" => [], "ValorGrupo" => 0]);

            //Recorremos los roles
            for ($k = 0; $k < 4; $k++) {

                //Si posee el grupo algun rol incompleto se intenta rellenar
                if ($grupos[$i]["RolesCompletos"][$k] == 0) {

                    //Si el integrante del rol no está vacio
                    if (!empty($roles[$k][0])) {

                        //Meterlo en el grupo y buscar ese alumno en los roles al que pertenece eliminandolo de los mismos
                        array_push($grupos[$i]["Alumnos"], $roles[$k][0]);
                        //Ponemos a 1 el rol completado
                        $grupos[$i]["RolesCompletos"][$k] = 1;
                        //El alumno buscado será el que se eliminará en el array de roles
                        $alumnoBuscado = $roles[$k][0];

                        //Buscar en el array de cada Rol y eliminar el alumno ya insertado en la variable de grupos
                        for ($l = 0; $l < 4; $l++) {

                            //Obtenemos la variable que indica donde está el alumno
                            $index = array_search($alumnoBuscado, $roles[$l]);
                            //Si la ha encontrado se elimina del grupo
                            if ($index !== FALSE) {
                                //Se elimina de roles[$i] el elemento index evitando los huecos entre los elementos
                                array_splice($roles[$l], $index, 1);

                            }
                        }
                    }
                }
            }
            //Contamos los puntos de cada grupo y los añadimos a la característica del grupo
            $grupos[$i]['ValorGrupo'] = contarPuntosGrupo($grupos[$i]["Alumnos"]);

        }
        //Las personas que han sobrado las metemos en un grupo aparte para conocer las personas que no hacen grupo
        $alumnosSobrantes = array();



        //Recorremos los roles de nuevo y quien se halla quedado esas personas no han formado grupo

        //Recorremos los roles
        for ($k = 0; $k < sizeof($roles); $k++) {
            //Recorremos los alumnos de cada rol
            for($i=0;$i<sizeof($roles[$k]);$i++) {

                if(!empty($roles[$k][$i])) {
                    //Meterlo en el grupo y buscar ese alumno en los roles al que pertenece eliminandolo de los mismos
                    array_push($alumnosSobrantes, $roles[$k][$i]);
                    //Alumno buscado que vamos a eliminar
                    $alumnoBuscado = $roles[$k][$i];

                    //Recorremos los roles eliminando el alumno
                    for ($l = 0; $l < 4; $l++) {
                        //Obtenemos la variable que indica donde está el alumno
                        $index = array_search($alumnoBuscado, $roles[$l]);
                        //Si encuentra el alumno en roles
                        if ($index !== FALSE) {

                            //Se elimina de roles[$i] el elemento index evitando los huecos entre los elementos
                            array_splice($roles[$l], $index, 1);
                            //Se renueva la i porque los elementos se mueven al principio
                            $i = -1;
                        }

                    }

                }

            }
        }

        //Se balancean los puntos de los grupos
        balancearPerfilesGrupos($grupos, $numeroGrupos);

        //Se balancean los grupos atendiendo a sus preferencias
        balancearPreferenciasGrupos($grupos, $numeroGrupos);

        //Se balancean los grupos para que existan mas mújeres en los grupos que hombres
        balancearMujeresHombres($grupos,$numeroGrupos);


        $alumnosTotales = array();
        array_push($alumnosTotales,$grupos);
        array_push($alumnosTotales,$alumnosSobrantes);
		
		/*  Para poder sacar los porcentajes añadimos una campo más por cada rol 
			al array de alumnostotales */
		array_push($alumnosTotales, $Coordinators);
		array_push($alumnosTotales, $Environments);
		array_push($alumnosTotales, $Speakers);
		array_push($alumnosTotales, $Supervisors);

        return $alumnosTotales;
    }


    /**
     *  Función que balanceará los grupos para que se cumpla que el mayor número de grupos poseen 20 puntos
     * @function balancearPerfilesGrupos
     * @param $grupos
     * @param $numeroGrupos
     */
    function balancearPerfilesGrupos(&$grupos, $numeroGrupos)
    {
        //Recorremos los grupos para realizar los balanceos
        for ($i = 0; $i < $numeroGrupos; $i++) {
            //Buscamos el primer grupo con cantidad menor de 20 puntos
            if (!empty($grupos[$i]["ValorGrupo"]) && $grupos[$i]["ValorGrupo"] < 20) {

                //Comparacion con otro grupo e intercambio de los elementos
                for ($k = 0; $k < $numeroGrupos; $k++) {

                    //Evitamos el intercambio con nosotros mismos
                    if ($k != $i) {

                        //Accedemos al alumno del grupo que será intercambiado
                        $grupoSimuladoA = $grupos[$i]; //Grupo menor a 20 inicial
                        $grupoSimuladoB = $grupos[$k];
                        //Puntuaciones tras el intercambio
                        $puntacionSimuladoA = contarPuntosGrupo($grupoSimuladoA["Alumnos"]);
                        $puntacionSimuladoB = contarPuntosGrupo($grupoSimuladoB["Alumnos"]);

                        //Si la suma de ambos grupos no llega a 40 puntos entonces no tiene sentido el intercambio
                        if(($puntacionSimuladoA + $puntacionSimuladoB) < 40) break;

                        //Comparamos cada alumno de un rol con otro rol
                        for ($l = 0; $l < sizeof($grupos[$i]["Alumnos"]); $l++) {

                            //Si no está vacio el alumno del intercambio
                            if (!empty($grupoSimuladoB["Alumnos"][$l])) {

                                //Realizamos copias de los grupos
                                $alumnoIntercambio = $grupoSimuladoB["Alumnos"][$l];
                                //Realizamos el intercambio entre los grupos copia
                                $grupoSimuladoB["Alumnos"][$l] = $grupoSimuladoA["Alumnos"][$l];
                                $grupoSimuladoA["Alumnos"][$l] = $alumnoIntercambio;


                                $puntacionSimuladoA = contarPuntosGrupo($grupoSimuladoA["Alumnos"]);
                                $puntacionSimuladoB = contarPuntosGrupo($grupoSimuladoB["Alumnos"]);

                                //Si no llegan a 40 la suma de los dos grupos entonces no tiene sentido el intercambio
                                if(($puntacionSimuladoB+$puntacionSimuladoA)<40) break;

                                /*Si en los grupos en los que se ha intercambiado se igualan o superan los 20 puntos entonces están
                                 correctos
                                */
                                if ($puntacionSimuladoA >= 20 && $puntacionSimuladoB >= 20) {
                                    //Copiamos los grupos copia sobre los grupos originales efectuando la copia
                                    $grupos[$i] = $grupoSimuladoA;
                                    $grupos[$k] = $grupoSimuladoB;

                                    //Recalculamos los puntos de cada grupo original tras el intercambio
                                    $grupos[$i]["ValorGrupo"] = contarPuntosGrupo($grupos[$i]["Alumnos"]);
                                    $grupos[$k]["ValorGrupo"] = contarPuntosGrupo($grupos[$k]["Alumnos"]);

                                    break;

                                }
                            }
                        }
                    }
                }
            }
        }
    }


    /**
     * Función que establece si la persona que posee el arrayNoQuieroSentarme, estaría agusto en ese grupo o no
     * @function busquedaEnGrupo
     * @param $grupo
     * @param $arrayNoQuieroSentarme
     * @return int
     */
    function busquedaEnGrupo($grupo, $arrayNoQuieroSentarme){
        //Recorremos cada grupo de alumnos
        for($i=0;$i<sizeof($grupo);$i++){
            //Recorremos el array de personas con las que no se quiere sentar el alumno
            for($k=0;$k<sizeof($arrayNoQuieroSentarme);$k++){
                //Si encuentra alguna persona con la que no quiere sentarse devuelve true
                if(strcmp($arrayNoQuieroSentarme[$k],$grupo[$i]["Nombre"])==0){
                    return 1;
                }
            }
        }
        //Si está agusto en el grupo devulve false
        return 0;
    }

    /*
     * Función que cuenta el número de mújeres de un grupo
     * @function contarMujeresGrupo
     * @param $grupos
     * @param $numeroChicasMaxGrupo
     */
    function contarMujeresGrupo($grupo,$numeroChicasMaxGrupo){
        $numeroChicas = 0;
        //Recorremos el grupo contando el numero de chicas
        for($i=0;$i<sizeof($grupo["Alumnos"]);$i++){
            if($grupo["Alumnos"][$i]["Sexo"] == 0) $numeroChicas++;
        }
        //Si el número de chicas en el grupo es menor al máximo entonces se puede insertar mas sino no
        return $numeroChicas<$numeroChicasMaxGrupo? 1:0;
    }

    /**
     * Función que realiza los intercambios entre hombres y mujeres de los distintos grupos, para que al intercambiarse
     * queden en cada grupo el mayor número de mujeres, respetando las preferencias, los roles, y los puntos de cada
     * grupo mayores a 20
     * @function balancearMujeresHombres
     * @param $grupos
     * @param $numeroGrupos
     */
    function balancearMujeresHombres(&$grupos, $numeroGrupos){

        //Recorremos los grupos para realizar los balanceos
        for ($i = 0; $i < $numeroGrupos; $i++) {
            //  print_r("<h2>Grupo ".$i."</h2>");
            // /Dentro del grupo Recorremos cada alumno en busca de un intercambio o no
            for ($k = 0; $k < sizeof($grupos[$i]["Alumnos"]); $k++) {
                ///Si se encuentra en el grupo uno de los que no quiere sentarse se realiza el intercambio
                //$arrayNoQuieroSentarme = $grupos[$i]["Alumnos"][$k]["No quiero Sentarme"];
                //   print_r("<h4>El alumno ".$grupos[$i]["Alumnos"][$k]["Nombre"]." </h4>>");

                //Si el que queremos cambiar es un hombre (A) y se cumple que haya menos de $numeroChicasMaxGrupo por grupo
                if ($grupos[$i]["Alumnos"][$k]["Sexo"] == 1 && contarMujeresGrupo($grupos[$i],3) == 1) {

                    //  print_r("El alumno " . $grupos[$i]["Alumnos"][$k]["Nombre"] . "no le gusta el grupo<br>");

                    //Buscamos otra persona de otro grupo del mismo rol
                    for ($l = 0; $l < $numeroGrupos; $l++) {
                        //Evitar los intercambios en el mismo grupo
                        if ($i != $l) {
                            //Accedemos al alumno del grupo que será intercambiado
                            $grupoSimuladoA = $grupos[$i]; //Grupo menor a 20 inicial
                            $grupoSimuladoB = $grupos[$l];
                            if(!empty( $grupoSimuladoB["Alumnos"][$k]) && !empty($grupoSimuladoA["Alumnos"][$k])) {
                                $estudianteIntercambioB = $grupoSimuladoB["Alumnos"][$k];
                                $estudianteIntercambioA = $grupoSimuladoA["Alumnos"][$k];

                                $grupoSimuladoA["Alumnos"][$k] = $estudianteIntercambioB;
                                $grupoSimuladoB["Alumnos"][$k] = $estudianteIntercambioA;

                                //Puntuaciones tras el intercambio
                                $puntacionSimuladoA = contarPuntosGrupo($grupoSimuladoA["Alumnos"]);
                                $puntacionSimuladoB = contarPuntosGrupo($grupoSimuladoB["Alumnos"]);

                                if(($puntacionSimuladoB+$puntacionSimuladoA )< 40) break;
                                //Array de las personas con las que no quiere sentarse B
                                $arrayNoQuieroSentarmeEnB = $estudianteIntercambioB["No quiero Sentarme"];
                                //Si la persona que entra acepta a los de su grupo y el intercambio produce mas de 20 puntos en cada grupo...
                                if (busquedaEnGrupo($grupoSimuladoB["Alumnos"], $arrayNoQuieroSentarmeEnB)
                                    && $puntacionSimuladoA >= 20
                                    && $puntacionSimuladoB >= 20
                                    && $estudianteIntercambioB["Sexo"] == 0
                                ) {
                                    $grupos[$i] = $grupoSimuladoA;
                                    $grupos[$l] = $grupoSimuladoB;
                                    $grupos[$i]["ValorGrupo"] = contarPuntosGrupo($grupos[$i]["Alumnos"]);
                                    $grupos[$l]["ValorGrupo"] = contarPuntosGrupo($grupos[$l]["Alumnos"]);

                                    break;
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    /** Función que lleva a cabo los intercambios para que las personas se encuentren en el grupo con personas con las que
     * quieran sentarse, además de tener en cuenta el rol, y que el intercambio respete que el grupo posea 20 o mas puntos
     * @function balancearPreferenciasGrupos
     * @param $grupos
     * @param $numeroGrupos
     */
    function balancearPreferenciasGrupos(&$grupos, $numeroGrupos)
    {

        //Recorremos los grupos para realizar los balanceos
        for ($i = 0; $i < $numeroGrupos; $i++) {
            //Dentro del grupo Recorremos cada alumno en busca de un intercambio o no
            for ($k = 0; $k < sizeof($grupos[$i]["Alumnos"]); $k++) {

                ///Si se encuentra en el grupo uno de los que no quiere sentarse se realiza el intercambio
                $arrayNoQuieroSentarme = $grupos[$i]["Alumnos"][$k]["No quiero Sentarme"];
                //Si hay alguien que no le gusta en el grupo
                if (busquedaEnGrupo($grupos[$i]["Alumnos"], $arrayNoQuieroSentarme) == true) {

                    //Buscamos otra persona de otro grupo del mismo rol
                    for ($l = 0; $l < $numeroGrupos; $l++) {
                        //Evitar los intercambios en el mismo grupo
                        if ($i != $l) {

                            //Copias de los grupos que van a intercambiar estudiantes
                            $grupoSimuladoA = $grupos[$i]; //Grupo menor a 20 inicial
                            $grupoSimuladoB = $grupos[$l];

                            //Si alguno de los alumnos no existe o esta vacio entonces sale del bucle
                            if(empty($grupoSimuladoB["Alumnos"][$k]) || empty($grupoSimuladoA["Alumnos"][$k])) break;
                            //Estudiantes intercambiados
                            $estudianteIntercambioB = $grupoSimuladoB["Alumnos"][$k];
                            $estudianteIntercambioA = $grupoSimuladoA["Alumnos"][$k];

                            //Realizamos el intercambio entre los estudiantes simulados
                            $grupoSimuladoA["Alumnos"][$k] = $estudianteIntercambioB;
                            $grupoSimuladoB["Alumnos"][$k] = $estudianteIntercambioA;

                            //Puntuaciones tras el intercambio
                            $puntacionSimuladoA = contarPuntosGrupo($grupoSimuladoA["Alumnos"]);
                            $puntacionSimuladoB = contarPuntosGrupo($grupoSimuladoB["Alumnos"]);

                            //Si el intercambio
                            if(($puntacionSimuladoA+$puntacionSimuladoB)<40) break;

                            //Array de las personas con las que no quuiere sentarse el alumno B
                            $arrayNoQuieroSentarmeEnB = $estudianteIntercambioB["No quiero Sentarme"];

                            //Si la persona que entra acepta a los de su grupo y el intercambio produce mas de 20 puntos en cada grupo...
                            if (busquedaEnGrupo($grupoSimuladoB["Alumnos"], $arrayNoQuieroSentarmeEnB)
                                && $puntacionSimuladoA >= 20
                                && $puntacionSimuladoB >= 20){

                                //Se produce el intercambio copiando el grupoSimuladoA al real
                                $grupos[$i] = $grupoSimuladoA;
                                $grupos[$l] = $grupoSimuladoB;
                                $grupos[$i]["ValorGrupo"] = contarPuntosGrupo($grupos[$i]["Alumnos"]);
                                $grupos[$l]["ValorGrupo"] = contarPuntosGrupo($grupos[$l]["Alumnos"]);

                                break;
                            }
                        }
                    }
                }
            }
        }
    }

/**
 * Función que introduce los alumnos sin agrupar, en los grupos menos favorecidos por los puntos.
 * @function introducirAlumnosSobrantes
 * @param $alumnosSobrantes
 * @param $alumnosAgrupados
 * @return int
 */
    function introducirAlumnosSobrantes(&$alumnosSobrantes,&$alumnosAgrupados){

        //Introducir los alumnos donde encajen
        $puntuacionGrupoMenosPersonas = $alumnosAgrupados[0]["ValorGrupo"];
        $indiceGrupoMenosPersonas = 0;

        /** @var array $alumnosSobrantes */
        if(sizeof($alumnosSobrantes) == 0) return 1;
        //Recorremos el grupo en busca del grupo con menos candidatos
        for($i=0;$i<sizeof($alumnosAgrupados);$i++){
            if($puntuacionGrupoMenosPersonas > $alumnosAgrupados[$i]["ValorGrupo"]){
                $puntuacionGrupoMenosPersonas = $alumnosAgrupados[$i]["ValorGrupo"];
                $indiceGrupoMenosPersonas = $i;
            }
        }
            //Marcamos la persona como que se añade al grupo pero es no compatible
            $alumnosSobrantes[0]["SobroEnElgrupo"] = true;


            //Metemos el alumno en el grupo con menos personas
            array_push($alumnosAgrupados[$indiceGrupoMenosPersonas]["Alumnos"], $alumnosSobrantes[0]);

            //Metemos un campo para indicar los alumnos repescados
            $alumnosAgrupados[$indiceGrupoMenosPersonas]["AlumnosRepescados"] = true;

            //Eliminamos el alumno porque ya no es sobrante
            array_splice($alumnosSobrantes, 0, 1);


            //Hacemos una llamada recursiva para que lo haga con todos los alumnosSobrantes hasta que no queden ninguno
            introducirAlumnosSobrantes($alumnosSobrantes, $alumnosAgrupados);


    }

