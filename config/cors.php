<?php

return [
'paths' => ['api/*'], // Autorise CORS sur les routes API
'allowed_methods' => ['*'], // Autorise toutes les méthodes (GET, POST, etc.)
'allowed_origins' => ['*'], // Autorise toutes les origines (modifiable selon besoin)
'allowed_origins_patterns' => [],
'allowed_headers' => ['*'], // Autorise tous les headers
'exposed_headers' => [],
'max_age' => 0,
'supports_credentials' => false, // Mettre à true si besoin d'authentification avec CORS
];
