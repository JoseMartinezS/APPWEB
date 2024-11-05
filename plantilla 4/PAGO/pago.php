<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Pago</title>
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            margin: 20px;
        }

        .container {
            display: flex;
            width: 100%;
            max-width: 1000px;
        }

        /* Contenedores de columnas */
        .column {
            width: 50%;
            padding: 20px;
        }

        /* Estilo del formulario */
        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        /* Checkbox */
        .save-info {
            margin-top: 10px;
        }

        /* Estilo para el contenedor de productos */
        .product-list {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            background-color: #f9f9f9;
        }

        .product-item {
            margin-bottom: 10px;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        /* Botón de pago */
        button[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Columna Izquierda (Formulario de Pago) -->
        <div class="column">
            <h2>Formulario de Pago</h2>
            <form action="procesar_pago.php" method="post">
                <!-- País o Región -->
                <div class="form-group">
                    <label>País o Región</label>
                    <select name="pais" required>
                        <option value="mexico">México</option>
                    </select>
                </div>

                <!-- Nombre y Apellidos -->
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" name="nombre" required>
                </div>
                <div class="form-group">
                    <label>Apellidos</label>
                    <input type="text" name="apellidos" required>
                </div>

                <!-- Empresa (Opcional) -->
                <div class="form-group">
                    <label>Empresa (opcional)</label>
                    <input type="text" name="empresa">
                </div>

                <!-- Dirección -->
                <div class="form-group">
                    <label>Dirección</label>
                    <input type="text" name="direccion" required>
                </div>

                <!-- Descripción de la casa -->
                <div class="form-group">
                    <label>Descripción de la casa</label>
                    <input type="text" name="descripcion_casa">
                </div>

                <!-- Código Postal -->
                <div class="form-group">
                    <label>Código Postal</label>
                    <input type="text" name="codigo_postal" required>
                </div>

                <!-- Ciudad -->
                <div class="form-group">
                    <label>Ciudad</label>
                    <input type="text" name="ciudad" required>
                </div>

                <!-- Estado -->
                <div class="form-group">
                    <label>Estado</label>
                    <select name="estado" required>
                        <option value="aguascalientes">Aguascalientes</option>
                        <option value="baja_california">Baja California</option>
                        <option value="baja_california_sur">Baja California Sur</option>
                        <option value="campeche">Campeche</option>
                        <option value="chiapas">Chiapas</option>
                        <option value="chihuahua">Chihuahua</option>
                        <option value="coahuila">Coahuila</option>
                        <option value="colima">Colima</option>
                        <option value="cdmx">Ciudad de México</option>
                        <option value="durango">Durango</option>
                        <option value="guanajuato">Guanajuato</option>
                        <option value="guerrero">Guerrero</option>
                        <option value="hidalgo">Hidalgo</option>
                        <option value="jalisco">Jalisco</option>
                        <option value="mexico">México</option>
                        <option value="michoacan">Michoacán</option>
                        <option value="morelos">Morelos</option>
                        <option value="nayarit">Nayarit</option>
                        <option value="nuevo_leon">Nuevo León</option>
                        <option value="oaxaca">Oaxaca</option>
                        <option value="puebla">Puebla</option>
                        <option value="queretaro">Querétaro</option>
                        <option value="quintana_roo">Quintana Roo</option>
                        <option value="san_luis_potosi">San Luis Potosí</option>
                        <option value="sinaloa">Sinaloa</option>
                        <option value="sonora">Sonora</option>
                        <option value="tabasco">Tabasco</option>
                        <option value="tamaulipas">Tamaulipas</option>
                        <option value="tlaxcala">Tlaxcala</option>
                        <option value="veracruz">Veracruz</option>
                        <option value="yucatan">Yucatán</option>
                        <option value="zacatecas">Zacatecas</option>
                    </select>
                </div>

                <!-- Teléfono -->
                <div class="form-group">
                    <label>Teléfono</label>
                    <input type="text" name="telefono" required>
                </div>

                <!-- Guardar información -->
                <div class="form-group save-info">
                    <input type="checkbox" name="guardar_info" id="guardar_info">
                    <label for="guardar_info">Guardar esta información para la próxima vez</label>
                </div>

                <!-- Botón de Pago -->
                <button type="submit">Realizar Pago</button>
            </form>
        </div>

        <!-- Columna Derecha (Resumen de Productos) -->
        <div class="column">
            <h2>Resumen de Productos</h2>
            <div class="product-list" id="product-summary">
                <!-- Aquí puedes cargar los productos del carrito usando PHP o JavaScript -->
                <div class="product-item">
                    <p>Producto 1 - $100.00</p>
                </div>
                <div class="product-item">
                    <p>Producto 2 - $200.00</p>
                </div>
                <!-- Total -->
                <p><strong>Total: $300.00</strong></p>
            </div>
        </div>
    </div>
</body>
</html>
