
'username' => 'required|regex:/^[a-zA-Z0-9_]+$/',           // Expresiones regulares_ Validar nombres de usuario con letras, números y guiones bajos.
'edad' => 'required|integer|min:18|max:65',                 // Validar edades usando integer
'fecha_nacimiento' => 'required|date|before:today',         // Validar que la fecha de nacimiento sea anterior a hoy.
'evento' => 'required|date|after:now',                      // Validar fechas para eventos futuros.
'email' => 'required|email|max:255',
'sitio_web' => 'required|url',
'uuid' => 'required|uuid',
