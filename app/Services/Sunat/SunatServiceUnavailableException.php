<?php

namespace App\Services\Sunat;

use RuntimeException;

class SunatServiceUnavailableException extends RuntimeException
{
    // Evita exponer al navegador detalles internos del proveedor o sus credenciales.
}
