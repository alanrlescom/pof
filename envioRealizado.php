<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POF | Envio realizado</title>
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="./css/styles.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        [v-cloak] {
            display: none;
        }

        body {
            background-color: #fafafa;
        }

    </style>
</head>

<body>
    <div id="root" v-cloak>
        <nav class="navbar">
            <a href="./index.php" class="nav-link"> Pack On Fire </a>
            <div class="spacer"></div>
            <a href="./index.php" class="nav-link">Inicio</a>
            <a href="#" class="nav-link">Enviar</a>
            <a href="#" class="nav-link">Rastreo</a>
        </nav>
        <main class="flex justify-center m-16" v-if="data">
            <div class="bg-white w-4/5 flex flex-col gap-3 rounded-md overflow-hidden shadow-md">
                <div class="flex flex-row items-stretch">
                    <div class="flex flex-row grow bg-rose-500 text-white text-3xl p-5 rounded-md font-bold items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <p>
                            Gracias por su pedido
                        </p>
                    </div>
                    <div class="flex flex-col justify-start p-3">
                        <a class="text-xl" href="./rastreo.php?guia=<?php echo $_GET["guia"];?>">
                            <p class="font-bold">
                                Número de Guia <?php echo $_GET["guia"];?>
                            </p>
                            <p class="text-base">
                                
                                    Puedes rastrear tu envío haciendo click aqui
                            </p>
                        </a>
                    </div>
                </div>
                <div class="flex flex-col gap-4 p-4">
                    <p class="italic font-bold">
                        El pedido ha sido recibido y esta siendo procesado
                    </p>
                    <div class="flex flex-row gap-4 text-base">
                        <div class="flex-1 flex flex-col gap-4">
                            <p class="text-lg text-rose-600">
                                Remitente
                            </p>
                            <div class="h-1 w-full bg-rose-400 mb-4"></div>
                            <p>
                                Contacto: <span class="font-bold">{{ data.remitente.nombre }}, tel. {{data.remitente.telefono}}</span>
                            </p>
                            <p>
                                Direccion: <span class="font-bold">{{ origen }}</span>
                            </p>
                        </div>
                        <div class="flex-1 flex flex-col gap-4">
                            <p class="text-lg text-rose-600">
                                Destinatario
                            </p>
                            <div class="h-1 w-full bg-rose-400 mb-4"></div>
                            <p>
                                Contacto: <span class="font-bold">{{ data.destinatario.nombre }}, tel. {{data.destinatario.telefono}}</span>
                            </p>
                            <p>
                                Direccion: <span class="font-bold">{{ destino }}</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-row justify-end p-4">
                    <a class="p-3 bg-slate-200 active:bg-slate-400 hover:bg-slate-300 text-slate-800 rounded-md" href="./index.php">
                        Volver
                    </a>
                </div>
            </div>
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <script src="./js/scripts.js?t=<?php echo md5_file("./js/scripts.js");?>"></script>
    <script src="./js/vue/envioRealizado.js?t=<?php echo md5_file("./js/vue/envioRealizado.js");?>"></script>
</body>

</html>