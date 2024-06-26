<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Automóviles Usados</title>
</head>
<body>
    <h2>Gestión de Automóviles Usados</h2>

    <?php
    // Incluir el archivo de conexión a la base de datos
    include '../db/db.php';

    // Lógica para manejar la acción del formulario
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $action = $_POST['action'];

        if ($action == 'create') {
            // Lógica para agregar un nuevo automóvil usado
            $dominio = $_POST['dominio'];
            $marca = $_POST['marca'];
            $modelo = $_POST['modelo'];
            $año_fabricacion = $_POST['año_fabricacion'];
            $kilometraje = $_POST['kilometraje'];

            $sql = "INSERT INTO automoviles_usados (dominio, marca, modelo, año_fabricacion, kilometraje) VALUES ('$dominio', '$marca', '$modelo', '$año_fabricacion', '$kilometraje')";
            if ($conn->query($sql) === TRUE) {
                echo "Nuevo automóvil usado agregado exitosamente<br>";
            } else {
                echo "Error al agregar automóvil usado: " . $conn->error . "<br>";
            }
        } elseif ($action == 'delete') {
            // Lógica para eliminar un automóvil usado
            $dominio = $_POST['dominio'];

            $sql = "DELETE FROM automoviles_usados WHERE dominio='$dominio'";
            if ($conn->query($sql) === TRUE) {
                echo "Automóvil usado eliminado exitosamente<br>";
            } else {
                echo "Error al eliminar automóvil usado: " . $conn->error . "<br>";
            }
        } elseif ($action == 'update') {
            // Lógica para actualizar un automóvil usado
            $dominio = $_POST['dominio'];
            $marca = $_POST['marca'];
            $modelo = $_POST['modelo'];
            $año_fabricacion = $_POST['año_fabricacion'];
            $kilometraje = $_POST['kilometraje'];

            $sql = "UPDATE automoviles_usados SET marca='$marca', modelo='$modelo', año_fabricacion='$año_fabricacion', kilometraje='$kilometraje' WHERE dominio='$dominio'";
            if ($conn->query($sql) === TRUE) {
                echo "Automóvil usado actualizado exitosamente<br>";
            } else {
                echo "Error al actualizar automóvil usado: " . $conn->error . "<br>";
            }
        } elseif ($action == 'edit') {
            // Lógica para prellenar el formulario de edición
            $dominio = $_POST['dominio'];

            $sql = "SELECT dominio, marca, modelo, año_fabricacion, kilometraje FROM automoviles_usados WHERE dominio='$dominio'";
            $result = $conn->query($sql);

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                // Mostrar el formulario con los datos prellenados para editar
                echo '<form action="automoviles_usados.php" method="POST">
                        <input type="hidden" name="action" value="update">
                        Dominio: <input type="text" name="dominio" value="' . $row['dominio'] . '" readonly><br>
                        Marca: <input type="text" name="marca" value="' . $row['marca'] . '"><br>
                        Modelo: <input type="text" name="modelo" value="' . $row['modelo'] . '"><br>
                        Año de Fabricación: <input type="text" name="año_fabricacion" value="' . $row['año_fabricacion'] . '"><br>
                        Kilometraje: <input type="text" name="kilometraje" value="' . $row['kilometraje'] . '"><br>
                        <input type="submit" value="Actualizar Automóvil Usado">
                      </form><br>';
            }
        }
    }
    ?>

    <!-- Formulario para agregar un nuevo automóvil usado -->
    <h2>Agregar Automóvil Usado</h2>
    <form action="automoviles_usados.php" method="POST">
        <input type="hidden" name="action" value="create">
        Dominio: <input type="text" name="dominio"><br>
        Marca: <input type="text" name="marca"><br>
        Modelo: <input type="text" name="modelo"><br>
        Año de Fabricación: <input type="text" name="año_fabricacion"><br>
        Kilometraje: <input type="text" name="kilometraje"><br>
        <input type="submit" value="Agregar Automóvil Usado">
    </form>

    <!-- Lista de automóviles usados existentes -->
    <h2>Lista de Automóviles Usados</h2>
    <?php
    // Mostrar la lista actual de automóviles usados
    $sql = "SELECT dominio, marca, modelo, año_fabricacion, kilometraje FROM automoviles_usados";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "Dominio: " . $row["dominio"]. " - Marca: " . $row["marca"]. " - Modelo: " . $row["modelo"]. " - Año de Fabricación: " . $row["año_fabricacion"]. " - Kilometraje: " . $row["kilometraje"]. " ";
            // Formulario para eliminar
            echo '<form style="display:inline;" action="automoviles_usados.php" method="POST">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="dominio" value="' . $row["dominio"] . '">
                    <input type="submit" value="Eliminar">
                  </form>';
            // Formulario para editar
            echo '<form style="display:inline;" action="automoviles_usados.php" method="POST">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="dominio" value="' . $row["dominio"] . '">
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
