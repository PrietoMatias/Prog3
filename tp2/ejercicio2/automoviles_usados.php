<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Automóviles Usados</title>
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
        padding: 20px;
        text-align: center;
    }
    input{
        margin-bottom: 10px;
        padding: 5px;
        width: 200px;
        font-size: 16px;
    
    }
    input[type="submit"] {
        border-radius: 5px;
        border: 1px solid #ccc;
    }
    ::placeholder {
        color: #404043;
        opacity: 1;
    }
    .boton{
        background-color: #4CAF50;
        color: white;
        cursor: pointer;
    }
    .boton_eliminar{
        background-color: #f44336;
        color: white;
        cursor: pointer;
    }
    .boton_editar{
        background-color: #ff9e18;
        color: white;
        cursor: pointer;
    }
    .Formulario{
        width: 100%;
        margin-top: 20px;
    }
    .Lista{
        display:none;
    }
</style>
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
    <div class="Formulario">
    <h2>Agregar Automóvil Usado</h2>
    <form action="automoviles_usados.php" method="POST">
        <input type="hidden" name="action" value="create">
         <input type="text" name="dominio" placeholder="Patente"><br>
         <input type="text" name="marca" placeholder="Marca"><br>
         <input type="text" name="modelo" placeholder="Modelo"><br>
         <input type="text" name="año_fabricacion" placeholder="Año de Fabricacion"><br>
         <input type="text" name="kilometraje" placeholder="Kilometraje"><br>
        <input class="boton" type="submit" onclick="
        document.querySelector('.Lista').style.display = 'block';
        " value="Agregar Automóvil Usado">
    </form>
    </div>

    <!-- Lista de automóviles usados existentes -->
    <div class="Lista">
    <h2>Lista de Automóviles Usados</h2>
    
    <?php
    // Mostrar la lista actual de automóviles usados
    $sql = "SELECT dominio, marca, modelo, año_fabricacion, kilometraje FROM automoviles_usados";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Dominio: " . $row["dominio"] . " - Marca: " . $row["marca"] . " - Modelo: " . $row["modelo"] . " - Año de Fabricación: " . $row["año_fabricacion"] . " - Kilometraje: " . $row["kilometraje"] . " ";
            // Formulario para eliminar
            echo '<form style="display:inline;" action="automoviles_usados.php" method="POST">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="dominio" value="' . $row["dominio"] . '">
                    <input class="boton_eliminar" type="submit" value="Eliminar">
                  </form>';
            // Formulario para editar
            echo '<form style="display:inline;" action="automoviles_usados.php" method="POST">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="dominio" value="' . $row["dominio"] . '">
                    <input class="boton_editar" type="submit" value="Editar">
                  </form><br>';
        }
    } else {
        echo "0 resultados";
    }
    $conn->close(); // Cerrar la conexión
    ?>
    </div>
</body>
</html>
