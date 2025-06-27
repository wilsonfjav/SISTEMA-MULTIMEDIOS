<?php
// utils/validaciones.php

function validarCampos($datos, $camposRequeridos) {
    foreach ($camposRequeridos as $campo) {
        if (!isset($datos[$campo]) || trim($datos[$campo]) === '') {
            return "Falta el campo: $campo";
        }
    }
    return true;
}
