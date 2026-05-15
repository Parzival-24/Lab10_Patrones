<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo peso registrado</title>
</head>
<body>
    <h2>BovWeight CR – Registro de peso</h2>
    <p>Se ha registrado un nuevo peso:</p>
    <ul>
        <li><strong>Peso:</strong> {{ $registroPeso->pesoKg }} kg</li>
        <li><strong>Raza:</strong> {{ $registroPeso->razaNombre }}</li>
        <li><strong>Fecha:</strong> {{ $registroPeso->fecha }}</li>
    </ul>
</body>
</html>
