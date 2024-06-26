<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Estudiantes</title>
</head>
<body>
    <h2>Gestión de Estudiantes</h2>

    <?php
    // Incluir el archivo de conexión a la base de datos
    include '../db/db.php';

    // Lógica para manejar la acción del formulario
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $action = $_POST['action'];

        if ($action == 'create') {
            // Lógica para agregar un nuevo estudiante
            $legajo = $_POST['legajo'];
            $nombre_completo = $_POST['nombre_completo'];
            $dni = $_POST['dni'];
            $telefono = $_POST['telefono'];
            $mail = $_POST['mail'];

            $sql = "INSERT INTO estudiantes (legajo, nombre_completo, dni, telefono, mail) VALUES ('$legajo', '$nombre_completo', '$dni', '$telefono', '$mail')";
            if ($conn->query($sql) === TRUE) {
                echo "Nuevo estudiante agregado exitosamente<br>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
            }
        } elseif ($action == 'delete') {
            // Lógica para eliminar un estudiante
            $legajo = $_POST['legajo'];

            $sql = "DELETE FROM estudiantes WHERE legajo=$legajo";
            if ($conn->query($sql) === TRUE) {
                echo "Estudiante eliminado exitosamente<br>";
            } else {
                echo "Error eliminando el estudiante: " . $conn->error . "<br>";
            }
        } elseif ($action == 'update') {
            // Lógica para actualizar un estudiante
            $legajo = $_POST['legajo'];
            $nombre_completo = $_POST['nombre_completo'];
            $dni = $_POST['dni'];
            $telefono = $_POST['telefono'];
            $mail = $_POST['mail'];

            $sql = "UPDATE estudiantes SET nombre_completo='$nombre_completo', dni='$dni', telefono='$telefono', mail='$mail' WHERE legajo='$legajo'";
            if ($conn->query($sql) === TRUE) {
                echo "Estudiante actualizado exitosamente<br>";
            } else {
                echo "Error actualizando el estudiante: " . $conn->error . "<br>";
            }
        } elseif ($action == 'edit') {
            // Lógica para prellenar el formulario de edición
            $legajo = $_POST['legajo'];

            $sql = "SELECT legajo, nombre_completo, dni, telefono, mail FROM estudiantes WHERE legajo='$legajo'";
            $result = $conn->query($sql);

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                // Mostrar el formulario con los datos prellenados para editar
                echo '<form action="estudiantes.php" method="POST">
                        <input type="hidden" name="action" value="update">
                        Legajo: <input type="text" name="legajo" value="' . $row['legajo'] . '" readonly><br>
                        Nombre Completo: <input type="text" name="nombre_completo" value="' . $row['nombre_completo'] . '"><br>
                        DNI: <input type="text" name="dni" value="' . $row['dni'] . '"><br>
                        Teléfono: <input type="text" name="telefono" value="' . $row['telefono'] . '"><br>
                        Mail: <input type="text" name="mail" value="' . $row['mail'] . '"><br>
                        <input type="submit" value="Actualizar Estudiante">
                      </form><br>';
            }
        }
    }
    ?>

    <!-- Formulario para agregar un nuevo estudiante -->
    <h2>Agregar Estudiante</h2>
    <form action="estudiantes.php" method="POST">
        <input type="hidden" name="action" value="create">
        Legajo: <input type="text" name="legajo"><br>
        Nombre Completo: <input type="text" name="nombre_completo"><br>
        DNI: <input type="text" name="dni"><br>
        Teléfono: <input type="text" name="telefono"><br>
        Mail: <input type="text" name="mail"><br>
        <input type="submit" value="Agregar Estudiante">
    </form>

    <!-- Lista de estudiantes existentes -->
    <h2>Lista de Estudiantes</h2>
    <?php
    // Mostrar la lista actual de estudiantes
    $sql = "SELECT legajo, nombre_completo, dni, telefono, mail FROM estudiantes";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "Legajo: " . $row["legajo"]. " - Nombre Completo: " . $row["nombre_completo"]. " - DNI: " . $row["dni"]. " - Teléfono: " . $row["telefono"]. " - Mail: " . $row["mail"]. " ";
            // Formulario para eliminar
            echo '<form style="display:inline;" action="estudiantes.php" method="POST">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="legajo" value="' . $row["legajo"] . '">
                    <input type="submit" value="Eliminar">
                  </form>';
            // Formulario para editar
            echo '<form style="display:inline;" action="estudiantes.php" method="POST">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="legajo" value="' . $row["legajo"] . '">
                    <input type="submit" value="Editar">
                  </form><br>';
        }
    } else {
        echo "0 resultados";
    }
    $conn->close(); // Cerrar la conexión
    ?>
</body>
</html>
