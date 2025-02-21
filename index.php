<?php

// DAL: Database.php
class Database {
    private static $host = "localhost";
    private static $dbname = "db_crud_pdo";
    private static $username = "root";
    private static $password = "";
    private static $conn;

    public static function connect() {
        if (!isset(self::$conn)) {
            self::$conn = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$dbname, self::$username, self::$password);
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$conn;
    }
}

$db = Database::connect();
$stmt = $db->prepare("SELECT * FROM usuarios");
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .container {
            flex: 1;
            max-width: 900px;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .navbar {
            background: #343a40;
        }
        .footer {
            background: #343a40;
            color: white;
            text-align: center;
            padding: 10px 0;
            margin-top: auto;
        }
    </style>
    <script>
        function confirmarEliminacion() {
            return confirm('¿Estás seguro de eliminar este usuario?');
        }
    </script>
</head>
<body>
    <nav class="navbar navbar-dark">
        
    </nav>

    <div class="container mt-4">
        <h1 class="mb-4 text-center">Gestión de Usuarios</h1>
        
        <form method="POST" action="procesar.php" class="mb-4 p-4 border rounded bg-light shadow">
            <input type="hidden" name="id" id="id">
            <div class="mb-3">
                <label class="form-label">Nombre:</label>
                <input type="text" name="nombre" id="nombre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email:</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Edad:</label>
                <input type="number" name="edad" id="edad" class="form-control" required>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" name="accion" value="crear" class="btn btn-primary w-50">Agregar</button>
                <button type="submit" name="accion" value="actualizar" class="btn btn-warning w-50">Actualizar</button>
            </div>
        </form>
        
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Edad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario) : ?>
                    <tr>
                        <td><?= $usuario['id'] ?></td>
                        <td><?= $usuario['nombre'] ?></td>
                        <td><?= $usuario['email'] ?></td>
                        <td><?= $usuario['edad'] ?></td>
                        <td>
                            <button class="btn btn-info" onclick="editarUsuario(<?= $usuario['id'] ?>, '<?= $usuario['nombre'] ?>', '<?= $usuario['email'] ?>', <?= $usuario['edad'] ?>)">Editar</button>
                            <a href="procesar.php?id=<?= $usuario['id'] ?>&accion=eliminar" class="btn btn-danger" onclick="return confirmarEliminacion();">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <footer class="footer">
        <p>&copy; 2025 CRUD de Usuarios. Todos los derechos reservados.</p>
    </footer>

    <script>
        function editarUsuario(id, nombre, email, edad) {
            document.getElementById('id').value = id;
            document.getElementById('nombre').value = nombre;
            document.getElementById('email').value = email;
            document.getElementById('edad').value = edad;
        }
    </script>
</body>
</html>