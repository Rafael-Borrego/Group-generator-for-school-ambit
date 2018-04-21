

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
		        <a href="esb.php?r=alumnos" class="w3-bar-item w3-button w3-hide-small"><i class="fa fa-group"></i> ALUMNOS</a>
		        <a href="esb.php?r=crearGrupos" class="w3-bar-item w3-button w3-hide-small"><i class="fa fa-th"></i> CREAR GRUPOS</a>

	        </div>

	        <!-- Navbar on small screens -->
	        <div id="navDemo" class="w3-bar-block w3-white w3-hide w3-hide-large w3-hide-medium">
		        <a href="" class="w3-bar-item w3-button" onclick="toggleFunction()">ALUMNOS</a>
		        <a href="#portfolio" class="w3-bar-item w3-button" onclick="toggleFunction()">CREAR GRUPOS</a>
	        </div>
 
        </div>


        <h1 class ="h1Medio w3-red">ERROR, NECESITA CREAR UN FICHERO JSON CON LOS ALUMNOS "AlumnosIntro.json"</h1>
        <p >
            <pre >
                [
                    {
                        "Nombre": "Alumno1",
                        "Academico": 3,
                        "Social":3,
                        "Sexo": 0,
                        "Quiero Sentarme":["Alumno2","Alumno9"],
                        "No quiero Sentarme":["Alumno4","Alumno5"],
                        "Es capaz de ayudar":3,
                        "Necesito ayuda" :0,
                        "Organización" : 3,
                        "Liderazgo":3,
                        "Decision-Participacion":3,
                        "Orden clase": 4
                    }
                ]
            </pre>
        </p>


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



