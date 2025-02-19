<?php

use Carbon\Carbon;

// Configurar el idioma globalmente
Carbon::setLocale('es'); // Mostrar fechas en español

// Crear instancias de Carbon
$ahora = Carbon::now(); // Fecha y hora actual
$utc = Carbon::now('UTC'); // Fecha y hora actual en UTC
$fechaEspecifica = Carbon::create(2024, 12, 25, 15, 30); // Año, Mes, Día, Hora, Minuto
$fechaDesdeCadena = Carbon::parse('2024-12-10 10:00:00'); // Convertir cadena a Carbon
$clonFecha = $ahora->copy(); // Crear un clon de una fecha existente

// Manipular Fechas
$masDias = $ahora->addDays(5); // Añadir 5 días
$menosMeses = $ahora->subMonths(2); // Restar 2 meses
$inicioDia = $ahora->startOfDay(); // Establecer a las 00:00 del día
$finDia = $ahora->endOfDay(); // Establecer a las 23:59:59 del día
$inicioSemana = $ahora->startOfWeek(); // Primer día de la semana (lunes por defecto)
$finSemana = $ahora->endOfWeek(); // Último día de la semana (domingo)
$primerDiaMes = $ahora->firstOfMonth(); // Primer día del mes
$ultimoDiaMes = $ahora->lastOfMonth(); // Último día del mes
$resetSegundos = $ahora->setSecond(0); // Resetear segundos a 0

// Comparar Fechas
$esFuturo = $fechaEspecifica->isFuture(); // ¿La fecha es en el futuro?
$esPasado = $fechaDesdeCadena->isPast(); // ¿La fecha es en el pasado?
$esHoy = $ahora->isToday(); // ¿La fecha es hoy?
$esIgual = $ahora->eq($fechaDesdeCadena); // ¿Las fechas son iguales?
$esAntes = $ahora->lessThan($fechaEspecifica); // ¿La fecha actual es antes?
$esDespues = $ahora->greaterThan($fechaDesdeCadena); // ¿La fecha actual es después?

// Diferencias entre Fechas
$diferenciaDias = $ahora->diffInDays($fechaDesdeCadena); // Diferencia en días
$diferenciaMeses = $ahora->diffInMonths($fechaEspecifica); // Diferencia en meses
$haceCuanto = $fechaDesdeCadena->diffForHumans(); // Descripción en lenguaje humano (p.ej., "hace 1 semana")
$dentroDe = $fechaEspecifica->diffForHumans($ahora); // "en 2 semanas"

// Formatear Fechas
$formatoLargo = $ahora->format('Y-m-d H:i:s'); // Formato completo
$formatoCorto = $ahora->format('d/m/Y'); // Día/Mes/Año
$diaSemana = $ahora->locale('es')->isoFormat('dddd'); // Día de la semana (p.ej., "martes")
$mesAnio = $ahora->locale('es')->isoFormat('MMMM YYYY'); // Mes y Año (p.ej., "diciembre 2024")

// Zona Horaria
$utc = $ahora->setTimezone('UTC'); // Convertir a UTC
$local = $ahora->setTimezone('Europe/Madrid'); // Convertir a Europe/Madrid
$zonaActual = $ahora->timezoneName; // Obtener el nombre de la zona horaria actual

// Fechas Relativas
$ayer = Carbon::yesterday(); // Ayer
$mañana = Carbon::tomorrow(); // Mañana
$haceUnaSemana = Carbon::now()->subWeek(); // Hace una semana
$proximaSemana = Carbon::now()->addWeek(); // Próxima semana

// Métodos Especiales de Manipulación
$redondeo = $ahora->roundMinute(5); // Redondear minutos al múltiplo más cercano de 5
$ajustarHora = $ahora->setTime(15, 30, 0); // Cambiar hora a las 15:30:00
$ajustarFecha = $ahora->setDate(2025, 1, 1); // Cambiar fecha al 1 de enero de 2025

// Uso en Validaciones (Laravel)
$request->validate([
    'fecha_evento' => 'required|date|after:today', // Validar que sea una fecha válida y en el futuro
    'fecha_final' => 'required|date|after:fecha_inicio', // Validar relación entre fechas
]);
