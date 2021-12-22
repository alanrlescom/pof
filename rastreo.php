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
            <a href="./cotizar.php" class="nav-link">Enviar</a>
            <a href="#" class="nav-link">Rastreo</a>
        </nav>
        <main class="flex flex-col justify-center m-16">
            <h1 class="text-rose-600 text-4xl">
                Rastreo de paquete
            </h1>
            <div class="flex flex-col justify-center gap-4 mt-4">
                <p class="text-xl text-center">
                    Ingresa tu número de guia para visualizar el estado de tu envío
                </p>
                <div class="flex flex-row gap-3 justify-center">
                    <input type="text" class="text-center p-3 outline-none focus:ring-rose-400 rounded-md w-2/5 ring-2 ring-rose-500 placeholder:text-rose-200" placeholder="# DE GUIA" v-model="auxNumGuia">
                    <button class="bg-rose-500 active:bg-rose-700 hover:bg-rose-600 p-2 rounded-md text-white" @click="getRastreo">
                        Rastrear
                    </button>
                </div>
            </div>
            <div class="flex flex-col w-4/5 gap-8 m-auto mt-12" v-if="data">
                <div class="flex font-bold text-xl justify-center">
                    <p>
                        Estado del número de guia
                    </p>
                    <p class="ml-2">
                        {{ numGuia }}
                    </p>
                </div>
                <div class="flex flex-row gap-8">
                    <div class="relative flex flex-col flex-1 gap-4">
                        <div class="relative bg-white w-12 h-12 rounded-full border-2 border-rose-400 flex justify-center items-center text-rose-400">
                            <svg v-if="parseInt(data.envio.estado) <= 0" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <div v-if="parseInt(data.envio.estado) === 0"  class="absolute h-2 w-full bg-rose-500 left-full top-2/4 -translate-y-2/4 rounded-md -z-10"></div>
                            <div v-if="!data.mismaCuenta && parseInt(data.envio.estado) === 1" class="absolute h-2 bg-rose-500 left-full top-2/4 -translate-y-2/4 rounded-md -z-10" style="width: 200%;"></div>
                        </div>
                        <div v-if="parseInt(data.envio.estado) > (data.mismaCuenta ? 0 : 1)" class="absolute h-2 w-full bg-rose-500 rounded-md -z-10 -translate-y-2/4" style="top: 1.5rem; left: 1.5rem;"></div>
                        <p class="text-lg font-bold">
                            Envío solicitado
                        </p>
                        <p>
                            Se inicio el proceso de envio {{ fechaCreacion }}
                        </p>
                    </div>
                    <div class="relative flex flex-col flex-1 gap-4" v-if="data.mismaCuenta">
                        <div class="relative bg-white w-12 h-12 rounded-full border-2 border-rose-400 flex justify-center items-center text-rose-400">
                            <svg v-if="parseInt(data.envio.estado) <= 1" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20" />
                            </svg>
                            <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <div v-if="parseInt(data.envio.estado) === 1"  class="absolute h-2 w-16 bg-rose-500 left-full top-2/4 -translate-y-2/4 rounded-md -z-10"></div>
                        </div>
                        <div v-if="parseInt(data.envio.estado) > 1" class="absolute h-2 w-full bg-rose-500 rounded-md -z-10 -translate-y-2/4" style="top: 1.5rem; left: 1.5rem;"></div>
                        <p class="text-lg font-bold">
                            En recolección
                        </p>
                        <p v-if="parseInt(data.envio.estado) === 1">
                            Recolectando hoy
                        </p>
                    </div>
                    <div :class="estado < (data.mismaCuenta ? 1 : 0) ? 'opacity-25' : ''" class="relative flex flex-col flex-1 gap-4" v-if="!data.mismaCuenta || (data.mismaCuenta && parseInt(data.envio.estado) >= 2)">
                        <div class="relative bg-white w-12 h-12 rounded-full border-2 border-rose-400 flex justify-center items-center text-rose-400">
                            <svg v-if="parseInt(data.envio.estado) <= 2" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                            <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <div v-if="parseInt(data.envio.estado) === 2"  class="absolute h-2 w-16 bg-rose-500 left-full top-2/4 -translate-y-2/4 rounded-md -z-10"></div>
                        </div>
                        <div v-if="parseInt(data.envio.estado) > 2" class="absolute h-2 w-full bg-rose-500 rounded-md -z-10 -translate-y-2/4" style="top: 1.5rem; left: 1.5rem;"></div>
                        <p class="text-lg font-bold">
                            Recolectado
                        </p>
                    </div>
                    <div :class="estado < 2 ? 'opacity-25' : ''" class="relative flex flex-col flex-1 gap-4">
                        <div class="relative bg-white w-12 h-12 rounded-full border-2 border-rose-400 flex justify-center items-center text-rose-400">
                            <svg v-if="parseInt(data.envio.estado) <= (['1','3'].includes(data.envio.recoleccion) ? 3 : 4)" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <div v-if="parseInt(data.envio.estado) === 3"  class="absolute h-2 w-16 bg-rose-500 left-full top-2/4 -translate-y-2/4 rounded-md -z-10"></div>
                            <div v-if="!['1','3'].includes(data.envio.recoleccion) && parseInt(data.envio.estado) === 4"  class="absolute h-2 w-16 bg-rose-500 left-full top-2/4 -translate-y-2/4 rounded-md -z-10"></div>
                        </div>
                        <div v-if="parseInt(data.envio.estado) > (['1','3'].includes(data.envio.recoleccion) ? 3 : 4)" class="absolute h-2 w-full bg-rose-500 rounded-md -z-10 -translate-y-2/4" style="top: 1.5rem; left: 1.5rem;"></div>
                        <p class="text-lg font-bold">
                            En camino
                        </p>
                        <div v-if="parseInt(data.envio.estado) <= 3" class="flex flex-col">
                            <p>
                                Llegando {{ fechaLlegada }}
                            </p>
                            <p>
                                antes de las 8 PM
                            </p>
                        </div>
                    </div>
                    <div :class="estado < 3 ? 'opacity-25' : ''" class="relative flex flex-col flex-1 gap-4" v-if="['1','3'].includes(data.envio.recoleccion)">
                        <div class="relative bg-white w-12 h-12 rounded-full border-2 border-rose-400 flex justify-center items-center text-rose-400">
                            <svg v-if="parseInt(data.envio.estado) <= 4" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                            </svg>
                            <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <div v-if="parseInt(data.envio.estado) === 4"  class="absolute h-2 w-16 bg-rose-500 left-full top-2/4 -translate-y-2/4 rounded-md -z-10"></div>
                        </div>
                        <div v-if="parseInt(data.envio.estado) > 4" class="absolute h-2 w-full bg-rose-500 rounded-md -z-10 -translate-y-2/4" style="top: 1.5rem; left: 1.5rem;"></div>
                        <p class="text-lg font-bold">
                            En sucursal
                        </p>
                    </div>
                    <div v-if="estado >= (['1','3'].includes(data.envio.recoleccion) ? 3 : 1)" :class="estado < (['1','3'].includes(data.envio.recoleccion) ? 4 : 3) ? 'opacity-25' : ''" class="relative flex flex-col flex-1 gap-4">
                        <div class="relative bg-white w-12 h-12 rounded-full border-2 border-rose-400 flex justify-center items-center text-rose-400">
                            <svg v-if="parseInt(data.envio.estado) <= 5" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <p class="text-lg font-bold">
                            Entregado
                        </p>
                        <div class="flex flex-col">
                            <p>
                                Entregado {{ fechaEntrega }}
                            </p>
                            <p>
                                a las {{ horaEntrega }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <script src="./js/scripts.js?t=<?php echo md5_file("./js/scripts.js");?>"></script>
    <script src="./js/vue/rastreo.js?t=<?php echo md5_file("./js/vue/rastreo.js");?>"></script>
</body>

</html>