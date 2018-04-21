<?php include("Algoritmo.php");?>

<!DOCTYPE html>
<html>
    <head>
        <title>CIG</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/cig.css">
    </head>
    <body>
    <!-- Navbar (sit on top) -->
        <div class="w3-top">
	        <div class="w3-bar" id="myNavbar">
		        <a class="w3-bar-item w3-button w3-hover-black w3-hide-medium w3-hide-large w3-right" href="javascript:void(0);" onclick="toggleFunction()" title="Toggle Navigation Menu">
		          <i class="fa fa-bars"></i>
		        </a>
		        <a href="esb.php" class="w3-bar-item" style="text-decoration: none"><i class=""></i> <img src="logo.PNG" alt="logoCIG" height="35" style="margin-top: -10%; margin-left:-5%;"></a>
		        <a href="esb.php" class="w3-bar-item w3-button"><i class="fa fa-home"></i> HOME</a>
		        <a href="esb.php?r=alumnos" class="w3-bar-item w3-button w3-hide-small w3-red"><i class="fa fa-group"></i> ALUMNOS</a>
		        <a href="esb.php?r=crearGrupos" class="w3-bar-item w3-button w3-hide-small"><i class="fa fa-th"></i> CREAR GRUPOS</a>

	        </div>

	        <!-- Navbar on small screens -->
	        <div id="navDemo" class="w3-bar-block w3-white w3-hide w3-hide-large w3-hide-medium">
		        <a href="" class="w3-bar-item w3-button" onclick="toggleFunction()">ALUMNOS</a>
		        <a href="#portfolio" class="w3-bar-item w3-button" onclick="toggleFunction()">CREAR GRUPOS</a>
	        </div>
 
        </div>

		<a name="arriba"></a>
        <h1 class ="h1Medio">LISTADO DE ALUMNOS</h1>
		 
		 
		 <?php 
			/* Total de alumnos */
			/*  array_push($roles, $Coordinators);
				array_push($roles, $Environments);
				array_push($roles, $Speakers);
				array_push($roles, $Supervisors);
			*/
			
			
			$totalDeCoordiators = sizeof($Coordinators); 
			$totalDeEnvironments = sizeof($Environments); 
			$totalDeSpeakers = sizeof($Speakers); 
			$totalDeSupervisors = sizeof($Supervisors); 
			
			$sumaTotalDeRol = $totalDeCoordiators + $totalDeEnvironments + $totalDeSpeakers + $totalDeSupervisors;
	
			
			/*Hay que hacer el tanto por ciento de cada uno*/
			$PorcentajeCoordinators = ($totalDeCoordiators * 100) / $sumaTotalDeRol;
			$PorcentajeEnvironments = ($totalDeEnvironments * 100) / $sumaTotalDeRol;
			$PorcentajeSpeakers = ($totalDeSpeakers * 100) / $sumaTotalDeRol;
			$PorcentajeSupervisors = ($totalDeSupervisors * 100) / $sumaTotalDeRol;
			
			
			/*  */
		 ?>
		 <div class="w3-container">
			 <p class="w3-wide"><i class="fa fa-user"></i>Coordinators</p>
			 <div class="w3-light-grey">
				<div class="w3-container w3-padding-small w3-red w3-center" style="width:<?= $PorcentajeCoordinators ?>%"><?= round($PorcentajeCoordinators, 2)  ?>%</div>
			 </div>
			 
			 <p class="w3-wide"><i class="fa fa-user"></i>Environments</p>
			 <div class="w3-light-grey">
				<div class="w3-container w3-padding-small w3-red w3-center" style="width:<?= $PorcentajeEnvironments ?>%"><?= round($PorcentajeEnvironments, 2)  ?>%</div>
			 </div>
			 
			 <p class="w3-wide"><i class="fa fa-user"></i>Speakers</p>
			 <div class="w3-light-grey">
				<div class="w3-container w3-padding-small w3-red w3-center" style="width:<?= $PorcentajeSpeakers ?>%"><?= round($PorcentajeSpeakers, 2) ?>%</div>
			 </div>
			 
			 <p class="w3-wide"><i class="fa fa-user"></i>Supervisors</p>
			 <div class="w3-light-grey">
				<div class="w3-container w3-padding-small w3-red w3-center" style="width:<?= $PorcentajeSupervisors ?>%"><?= round($PorcentajeSupervisors, 2) ?>%</div>
			 </div>
		 </div>

        <table class="w3-table-all">
            <thead>
        <tr class="w3-red">
            <th>Nombre</th>
            <th>Académico</th>
            <th>Social</th>
            <th>Sexo</th>
            <th>Quiere Sentarse con</th>
            <th>No Quiere Sentarse con</th>
            <th>Capacidad Ayudar</th>
            <th>Necesidad Ayuda</th>
            <th>Organización</th>
            <th>Liderazgo</th>
            <th>Decisión-Participación</th>
            <th>Orden-Clase</th>
            <th>Perfil</th>
            <th>Rol</th>
        </tr>

        </thead>
            <tbody>
        <?php
            for($i=0;$i<sizeof($listadoAlumnos);$i++){
        ?>
                <tr>
                    <td><?php print_r($listadoAlumnos[$i]['Nombre']);?></td>
                    <td><?php print_r($listadoAlumnos[$i]['Academico']);?></td>
                    <td><?php print_r($listadoAlumnos[$i]['Social']);?></td>
                    <td><?php if($listadoAlumnos[$i]['Sexo'] == 0)echo 'Mujer'; else echo 'Hombre'?></td>
                    <td><?php print_r($listadoAlumnos[$i]['Quiero Sentarme'][0]);?></td>
                    <td><?php
                        for($k=0;$k<sizeof($listadoAlumnos[$i]["No quiero Sentarme"]);$k++) {
                            print_r($listadoAlumnos[$i]["No quiero Sentarme"][$k]);
                            print_r("<br>");
                        }
                        ?>
                    </td>
                    <td><?php print_r($listadoAlumnos[$i]["Es capaz de ayudar"]);  ?> </td>
                    <td><?php print_r($listadoAlumnos[$i]['Necesito ayuda']);?></td>
                    <td><?php print_r($listadoAlumnos[$i]['Organización']);?></td>
                    <td><?php print_r($listadoAlumnos[$i]['Liderazgo']);?></td>
                    <td><?php print_r($listadoAlumnos[$i]['Decision-Participacion']);?></td>
                    <td><?php print_r($listadoAlumnos[$i]['Orden clase']);?></td>
                    <td><?php print_r($listadoAlumnos[$i]['Perfil']);?></td>
                    <td><?php
                        for($k=0;$k<sizeof($listadoAlumnos[$i]["Rol"]);$k++) {
                            print_r($listadoAlumnos[$i]["Rol"][$k]);
                            print_r("<br>");
                        }
                        ?>
                    </td>

                </tr>

        <?php } ?>
            </tbody>
        </table>
		
	<!-- Footer -->
	<footer class="w3-center w3-red w3-padding-64">
	  <a href="#arriba" class="w3-button w3-light-grey"><i class="fa fa-arrow-up w3-margin-right"></i>Ir arriba</a>
	  <div class="w3-xlarge w3-section">
		<i class="fa fa-facebook-official w3-hover-opacity"></i>
		<i class="fa fa-instagram w3-hover-opacity"></i>
		<i class="fa fa-snapchat w3-hover-opacity"></i>
		<i class="fa fa-pinterest-p w3-hover-opacity"></i>
		<i class="fa fa-twitter w3-hover-opacity"></i>
		<i class="fa fa-linkedin w3-hover-opacity"></i>
	  </div>
	  <p>Proyecto CIG - Creación Inteligente de Grupos</a></p>
	</footer>
		
    <script>
        // Modal Image Gallery
        function onClick(element) {
            document.getElementById("img01").src = element.src;
            document.getElementById("modal01").style.display = "block";
            var captionText = document.getElementById("caption");
            captionText.innerHTML = element.alt;
        }

        // Change style of navbar on scroll
        window.onscroll = function() {myFunction()};
        function myFunction() {
            var navbar = document.getElementById("myNavbar");
            if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
                navbar.className = "w3-bar" + " w3-card" + " w3-animate-top" + " w3-white";
            } else {
                navbar.className = navbar.className.replace(" w3-card w3-animate-top w3-white", "");
            }
        }

        // Used to toggle the menu on small screens when clicking on the menu button
        function toggleFunction() {
            var x = document.getElementById("navDemo");
            if (x.className.indexOf("w3-show") == -1) {
                x.className += " w3-show";
            } else {
                x.className = x.className.replace(" w3-show", "");
            }
        }
    </script>
    </body>
</html>



