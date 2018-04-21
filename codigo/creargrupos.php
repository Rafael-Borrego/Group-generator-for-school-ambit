<?php
    include ("Algoritmo.php");
?>
<!DOCTYPE html>
<html xmlns="">
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
        <a href="esb.php" class="w3-bar-item w3-button"><i class="fa fa-home"></i>HOME</a>
        <a href="esb.php?r=alumnos" class="w3-bar-item w3-button w3-hide-small"><i class="fa fa-group"></i> ALUMNOS</a>
        <a href="esb.php?r=crearGrupos" class="w3-bar-item w3-button w3-hide-small w3-red"><i class="fa fa-th"></i> CREAR GRUPOS</a>
		
      </div>
		
      <!-- Navbar on small screens -->
      <div id="navDemo" class="w3-bar-block w3-white w3-hide w3-hide-large w3-hide-medium">
        <a href="" class="w3-bar-item w3-button" onclick="toggleFunction()">ALUMNOS</a>
        <a href="#portfolio" class="w3-bar-item w3-button" onclick="toggleFunction()">CREAR GRUPOS</a>
      </div>
    </div>
	<a name="arriba"></a>
    <h1 class="h1Medio">GRUPOS FORMADOS</h1>
    <?php
    for($i=0;$i<sizeof($alumnosAgrupados);$i++){
        ?>
    <table class="w3-table-all">
        <caption><?php echo "<h3> Grupo  ".($i+1).": ".$alumnosAgrupados[$i]["ValorGrupo"]." pts</h3>";?></caption>
        <thead>
            <tr class="w3-red">
                <th>Nombre</th>
                <th>Académico</th>
                <th>Social</th>
                <th>Sexo</th>
                <th>Quiere sentarse con</th>
                <th>No quiere sentarse con</th>
                <th>Capacidad ayudar</th>
                <th>Necesidad ayuda</th>
                <th>Organización</th>
                <th>Liderazgo</th>
                <th>Decision-Participación</th>
                <th>Orden-Clase</th>
                <th>Perfil</th>
                <th>Rol</th>
            </tr>
        </thead>
        <tbody>
        <?php
            for($j=0;$j<sizeof($alumnosAgrupados[$i]["Alumnos"]);$j++){
        ?>
        <tr class="<?php if(!empty($alumnosAgrupados[$i]["Alumnos"][$j]["SobroEnElgrupo"])) echo ".w3-table-all w3-light-blue";?>">

               <td><?php print_r($alumnosAgrupados[$i]["Alumnos"][$j]["Nombre"]); ?></td>
               <td><?php print_r($alumnosAgrupados[$i]["Alumnos"][$j]["Academico"]); ?></td>
               <td><?php print_r($alumnosAgrupados[$i]["Alumnos"][$j]["Social"]); ?></td>
               <td><?php
                   if($alumnosAgrupados[$i]["Alumnos"][$j]["Sexo"]==0) print_r("Mujer");
                   else print_r("Hombre");
                   ?>
               </td>
                <td> <?php for($k=0;$k<sizeof($alumnosAgrupados[$i]["Alumnos"][$j]["Quiero Sentarme"]);$k++) {
                            print_r($alumnosAgrupados[$i]["Alumnos"][$j]["Quiero Sentarme"][$k]);
                            print_r("<br>");
                        }
                        ?>
                </td>
                <td> <?php for($k=0;$k<sizeof($alumnosAgrupados[$i]["Alumnos"][$j]["No quiero Sentarme"]);$k++) {
                    print_r($alumnosAgrupados[$i]["Alumnos"][$j]["No quiero Sentarme"][$k]);
                        print_r("<br>");
                }
                ?>
                </td>
                <td><?php print_r($alumnosAgrupados[$i]["Alumnos"][$j]["Es capaz de ayudar"]); ?></td>
                <td><?php print_r($alumnosAgrupados[$i]["Alumnos"][$j]["Necesito ayuda"]); ?></td>
                <td><?php print_r($alumnosAgrupados[$i]["Alumnos"][$j]["Organización"]);?></td>
                <td><?php print_r($alumnosAgrupados[$i]["Alumnos"][$j]["Liderazgo"]);?></td>
                <td><?php print_r($alumnosAgrupados[$i]["Alumnos"][$j]["Decision-Participacion"]);?></td>
                <td><?php print_r($alumnosAgrupados[$i]["Alumnos"][$j]["Orden clase"]);?></td>
                <td><?php print_r($alumnosAgrupados[$i]["Alumnos"][$j]["Perfil"]);?></td>
                <td><?php
                    for($k=0;$k<sizeof($alumnosAgrupados[$i]["Alumnos"][$j]["Rol"]);$k++) {
                        print_r($alumnosAgrupados[$i]["Alumnos"][$j]["Rol"][$k]);
                        print_r("<br>");
                    }
                ?>
                </td>
        </tr>
        <?php
            }
        ?>
        </tbody>
    </table>


    <?php
    }

    ?>

	<div class="w3-row w3-center w3-light-blue w3-padding-16">
	  <div>
		<span class="w3-xlarge">*Alumnos de color azul: aquellos que se han añadido después de realizar los grupos</span><br>
	  </div>
	</div>
	
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


