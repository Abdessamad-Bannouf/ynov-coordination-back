<?php

return [
'paths' => ['api/*'], // Autorise CORS sur les routes API
'allowed_methods' => ['*'], // Autorise toutes les méthodes (GET, POST, etc.)
'allowed_origins' => explode(',', env('FRONTEND_URLS', 'http://localhost:5173')), // '*' est incompatible avec supports_credentials
'allowed_origins_patterns' => [],
'allowed_headers' => ['*'], // Autorise tous les headers
'exposed_headers' => [],
'max_age' => 3600,
'supports_credentials' => true, // Mettre à true si besoin d'authentification avec CORS
];
