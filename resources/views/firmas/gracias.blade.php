<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Firma Registrada</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #dbeafe, #f0f9ff);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

<div class="max-w-md w-full bg-white rounded-2xl shadow-xl border border-blue-200 overflow-hidden">
    <!-- Encabezado institucional -->
    <div class="bg-gradient-to-r from-blue-800 to-blue-900 px-6 py-5 text-center">
        <div class="flex justify-center mb-3">
            <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center shadow-md">
                <!-- Academic Cap Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-7 h-7 text-blue-800">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.08 0-2.127.235-3 .675v12.75a2.25 2.25 0 002.25 2.25h13.5A2.25 2.25 0 0021 16.915v-1.17M3 3.75C3 2.784 3.784 2 4.75 2h14.5A1.75 1.75 0 0121 3.75v1.5M3 6h18M3 9h18M3 12h9" />
                </svg>
            </div>
        </div>
        <h2 class="text-xl font-bold text-white">ESCUELA DE INFORMÁTICA</h2>
        <p class="text-blue-200 text-sm mt-1">Facultad de Ciencias Físicas y Matemáticas</p>
    </div>

    <!-- Contenido -->
    <div class="p-7 text-center">
        <!-- Icono de éxito -->
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 mb-5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>

        <span class="inline-block px-4 py-1.5 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full mb-4">
                Firma registrada correctamente
            </span>

        <h1 class="text-xl font-bold text-gray-800 mb-3">¡Gracias por su validación!</h1>

        <p class="text-gray-600 text-sm leading-relaxed mb-5">
            La firma de la ficha de prácticas pre profesionales ha sido registrada
            exitosamente en el sistema.
        </p>

        <p class="text-gray-500 text-sm">
            Ya puede cerrar esta ventana.<br>
            No es necesario realizar ninguna otra acción.
        </p>
    </div>

    <!-- Pie -->
    <div class="bg-blue-50 px-6 py-4 text-center border-t border-blue-100">
        <p class="text-xs text-blue-800 font-medium">
            Formato 01: Ficha de Registro de Prácticas Pre Profesionales
        </p>
    </div>
</div>

</body>
</html>
