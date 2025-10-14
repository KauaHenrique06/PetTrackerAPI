<?php

namespace App\Utils;

/**
 * Criei essa classe aqui para armazenar todas as funções de formatação
 */
class Formatter
{
    public static function cleanCpf(string $cpf){
        return preg_replace('/[^0-9]/', '', $cpf);
    }

    public static function formatCpf(string $cpf){
        $cleanedCpf = self::cleanCpf($cpf);
        return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cleanedCpf);
    }
}