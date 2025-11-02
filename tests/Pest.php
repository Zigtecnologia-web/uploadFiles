<?php

// Para projetos PHP puros, basta usar PHPUnit como base:
pest()->extend(\PHPUnit\Framework\TestCase::class);

// Opcional: colocar helpers ou expectations aqui
expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});
