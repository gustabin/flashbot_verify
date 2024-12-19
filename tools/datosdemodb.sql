INSERT INTO `user` (`id`, `name`, `email`, `passwordhash`, `rol`, `website`, `api_key`, `hostDB`, `userDB`, `passwordDB`, `databaseDB`, `typeDB`, `portDB`, `ssl_enabledDB`, `charsetDB`, `contenido`, `vencimiento`, `activo`, `token`, `verificado`, `licencia`, `tokenRecuperacion`) 
VALUES 
(1, 'John Doe', 'johndoe@example.com', 'hashedpassword123', 0, 'https://johndoe.com', 'apikey123', 'localhost', 'user1', 'pass1', 'db1', 'MySQL', 3306, 1, 'utf8', 'Contenido de prueba 1', '2025-12-31 23:59:59', 1, 'token123', 1, 1, NULL),
(2, 'Jane Smith', 'janesmith@example.com', 'hashedpassword456', 2, 'https://janesmith.com', 'apikey456', 'localhost', 'user2', 'pass2', 'db2', 'PostgreSQL', 5432, 0, 'utf8mb4', 'Contenido de prueba 2', '2026-12-31 23:59:59', 0, 'token456', 0, 3, NULL);
