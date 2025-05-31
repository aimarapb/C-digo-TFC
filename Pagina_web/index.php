<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://kit.fontawesome.com/b37619a977.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body class="bg-gray-200">
  
<!-- ESTA ES LA PARTE DE ARRIBA -->
    <div id="cabecera" class="flex flex-row h-24 bg-blue-300">

        <div class="flex mx-auto">
            <p class="my-auto mx-auto text-3xl font-sans antialiased tracking-wide">Monitorización</p>
        </div>

    </div>

<!-- ESTA ES LA PARTE DE ABAJO -->
    <div class="flex flex-col">
            <div id="parte-abajo" class="flex flex-col md:flex-row p-2">

                <!-- ESTA ES LA PARTE DE ABAJO IZQUIERDA -->
                    <div id="izq-entero" class="md:w-2/5 w-full shadow-lg bg-gray-100 rounded-lg p-4">
                        <div id="hayConexion" class="rounded-md text-center bg-slate-900 text-white font-bold py-1 mb-4">
                                    
                        </div>

                            <p class="font-bold">Estado de los servicios</p>
                            <div class="mb-8">
                                <table class="table table-striped border-2 border-collapse">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Servicio</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Actividad</th>
                                    </tr>
                                    </thead>
                                    <tbody id="verServicios" class="table-group-divider">
                                    </tbody>
                                </table>
                            </div>

                    </div>
            
         <!-- ESTA ES LA PARTE DE ABAJO DERECHA -->
                    <div id="der-partido" class="md:w-3/5 w-full flex flex-col p-2">
            
                    <!-- ESTA ES LA PARTE DE ABAJO PRIMER BLOQUE-->
                        <div class="h-96 md:h-48 p-2 rounded-lg my-2 shadow-lg bg-gray-100 flex flex-col md:flex-row justify-center">

                            <div class="flex flex-row items-center w-full md:w-2/3">
                                <div class="flex flex-col items-center mx-auto">
                                    <p class="mb-4 font-bold">Uso CPU</p>
            
                                    <?php
                                    $data = json_decode(file_get_contents("datos.json"), true);
                                    echo "<p>" . $data['uso_cpu'] . " %</p>";
                                    ?>
                
                                    <div id="barraCPU">
                                        
                                    </div>
                
                                </div>
            
                                <div class="flex flex-col items-center mx-auto">
                                    <p class="mb-4 font-bold">Uso Memoria</p>
            
                                    <?php
                                    echo "<p>" . $data['memoria_usada'] . "</p>";
                                    ?>
                
                                    <div class="my-auto">
                                        <?php
                                        echo "<p>Quedan " . $data['memoria_libre'] . " libres</p>";
                                        echo "<p>En total hay " . $data['memoria_total'] . " de espacio</p>";
                                        ?>
                                    </div>
                                </div>
            
                            </div>
                                
                                
                                <div class="flex flex-col w-full md:w-1/3 items-center mx-auto">
                                    <p class="mb-4 font-bold">Uso Disco duro</p>
            
                                    <?php
                                    echo "<p>" . $data['disco_usado'] . "</p>";
                                    ?>
                
                                    <div class="my-auto">
                                        <?php
                                        echo "<p>Quedan " . $data['disco_libre'] . " libres</p>";
                                        echo "<p>En total hay " . $data['disco_total'] . " de espacio</p>";
                                        ?>
                                    </div>
                                </div>
            
                        </div>
            
                    <!-- ESTA ES LA PARTE DE ABAJO SEGUNDO BLOQUE-->
                        <div class="h-80 p-2 rounded-lg my-2 shadow-lg bg-gray-100 flex flex-col">
                            <div class="flex flex-row">
                                
                                <div class="flex flex-col w-1/3">
                                    <p class="font-bold mb-8">Direcciones IP:</p>
                                    <div class="ml-2 mb-2 rounded-md border-l-4 border-indigo-500 bg-blue-100">
                                    <?php
                                        $data = json_decode(file_get_contents("datos.json"), true);
                                        echo "<p> IP pública: " . $data['ip_publica'] . "</p>";
                                    ?>
                                    </div>
                    
                                    <div class="ml-2 mb-2 rounded-md border-l-4 border-indigo-500 bg-blue-100">
                                    <?php
                                        echo "<p>IP local: " . $data['ip_local'] . "</p>";
                                    ?>
                                    </div>
                                </div>

                                <div class="w-1/3 flex flex-col items-center">
                                    <p class="mb-8 font-bold">Temperatura</p>
                                    <?php
                                        echo "<p>" . $data['temperatura'] . " ºC </p>";
                                    ?>
                                </div>
            
                                <div class="w-1/3 flex flex-col items-center">
                                    <p class="mb-8 font-bold">Tiempo activo</p>
                                    <?php
                                        echo "<p>" . $data['uptime'] . "</p>";
                                    ?>
                                </div>

                            </div>

                            <div class="flex flex-col md:flex-row mt-4">

                                <div class="w-1/2 flex flex-col">
                                    <div class="mb-4 font-bold">
                                        <?php
                                            $data = json_decode(file_get_contents("datos.json"), true);
                                            echo "<p>Dispositivos conectados al Wi-Fi: " . $data['conectados'] . "</p>";
                                        ?>
                                    </div>
                    
                                    <?php if ($data['conectados'] != 0): ?>
                                    <div>
                                        <?php
                                            echo "<p>Info de los dispositivos: " . $data['info_conectados'] . "</p>";
                                        ?>
                                    </div>
                                    <?php endif; ?>
                                </div>

                                <div class="w-1/2">
                                    <details>
                                    <summary>Reiniciar Raspberry</summary>
                                    <form method="post">
                                        <button onclick="confirmar()" class="bg-red-500 rounded-md text-lg px-2">Reiniciar</button>
                                    </form>
                                    </details>
                    
                                    <form id="hacerReinicio" method="post" action="reinicio.php" style="display: none;">
                                        <input type="hidden" name="reiniciar" value="1">
                                    </form>
                                </div>

                            </div>
                            
                        </div>
            
                    </div>

            </div>
        <div class="rounded-lg my-2 shadow-lg bg-gray-100 mx-2">
            <p class="font-bold">Usuarios que han accedido en los últimos 15 días</p>
                            <div class="mb-8">
                                <table class="table table-striped border-2 border-collapse">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Usuarios</th>
                                    </tr>
                                    </thead>
                                    <tbody id="sesionDatos" class="table-group-divider">
                                    </tbody>
                                </table>
                            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <script>
        function traerDatos() {
            fetch('/estado_servicios.json')
            .then(response => response.json())
            .then(data => {
                poner=document.getElementById("verServicios");
                poner.innerHTML = '';
                console.log(data);

                for(let i in data) {  
                servicio = data[i];
                tr = document.createElement("tr");
                tr.innerHTML = `
                    <th scope="row">${parseInt(i) + 1}</th>
                    <td>${servicio.servicio}</td>
                    <td>${servicio.estado}</td>
                    <td>${servicio.funcionando}</td>
                `;
                poner.appendChild(tr);
                }
            });
        }

        function datosSesion() {
            fetch('inicios_sesion.json')
            .then(response => response.json())
            .then(datos => {
                escribir=document.getElementById("sesionDatos");
                escribir.innerHTML = '';

                for(let i in datos) {
                sesion = datos[i];
                tr2 = document.createElement("tr");
                tr2.innerHTML = `
                    <th scope="row">${parseInt(i) + 1}</th>
                    <td>${sesion.fecha}</td>
                    <td>${sesion.usuario}</td>
                `;
                escribir.appendChild(tr2);
                }
            })
        }

        function confirmar() {
            respuesta = window.confirm('¿Estas seguro que quieres reinciar?');
            if (respuesta) {
                document.getElementById("hacerReinicio").submit();
            }
        }

        conexion = "<?php echo $data['conexion']; ?>";

        ponerConexion = document.getElementById("hayConexion");

        if (conexion === "Sí" || conexion === "si" || conexion === "true" || conexion === "1") {
            ponerConexion.innerHTML = "Hay conexión a Internet";
        } else {
            ponerConexion.innerHTML = "No hay conexión a Internet";
        }

        porCPU = <?php echo $data['uso_cpu']; ?>;
        console.log(porCPU);

        const ponerCPU = document.getElementById("barraCPU");

        if (!isNaN(porCPU)) {
            ponerCPU.innerHTML = `
                <div class="progress w-48 my-8">
                    <div class="progress-bar" style="width: ${porCPU}%" role="progressbar" aria-valuenow="${porCPU}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            `;
        }

    
        
        window.addEventListener('load', traerDatos);
        window.addEventListener('load', datosSesion);


    </script>

</body>
</html>
