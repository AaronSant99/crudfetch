// Cargar la lista de productos al iniciar la página
ListarProductos();

/**
 * Función para listar productos con opción de búsqueda
 * @param {string} busqueda - Término de búsqueda opcional
 */
function ListarProductos(busqueda) {
    fetch("listar.php", {
        method: "POST",
        body: busqueda  // Enviar término de búsqueda al servidor
    }).then(response => response.text()).then(response => {
        // Insertar el HTML de la tabla en el elemento resultado
        resultado.innerHTML = response;
    })
}

// Event listener para el botón registrar/actualizar
registrar.addEventListener("click", () => {
    // Enviar datos del formulario al servidor
    fetch("registrar.php", {
        method: "POST",
        body: new FormData(frm)  // Convertir formulario a FormData
    }).then(response => response.text()).then(response => {
        // Verificar respuesta del servidor
        if (response == "ok") {
            // Mostrar alerta de éxito para nuevo registro
            Swal.fire({
                icon: 'success',
                title: 'Registrado',
                showConfirmButton: false,
                timer: 1500
            })
            frm.reset();          // Limpiar formulario
            ListarProductos();    // Actualizar lista
        } else if (response == "modificado") {
            // Mostrar alerta de éxito para actualización
            Swal.fire({
                icon: 'success',
                title: 'Modificado',
                showConfirmButton: false,
                timer: 1500
            })
            registrar.value = "Registrar";
            idp.value = "";
            ListarProductos();
            frm.reset();
        } else {
            // Mostrar alerta de error enviada por el backend
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: response,
                confirmButtonText: 'OK'
            });
        }
    });
});

/**
 * Función para eliminar un producto
 * @param {string} id - ID del producto a eliminar
 */
function Eliminar(id) {
    // Mostrar confirmación antes de eliminar
    Swal.fire({
        title: 'Esta seguro de eliminar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'NO'
    }).then((result) => {
        if (result.isConfirmed) {
            // Proceder con la eliminación
            fetch("eliminar.php", {
                method: "POST",
                body: id  // Enviar ID del producto
            }).then(response => response.text()).then(response => {
                if (response == "ok") {
                   ListarProductos();  // Actualizar lista
                   // Mostrar confirmación de eliminación
                   Swal.fire({
                       icon: 'success',
                       title: 'Eliminado',
                       showConfirmButton: false,
                       timer: 1500
                   })
                }
                
            })
            
        }
    })
}

/**
 * Función para cargar datos de un producto en el formulario para edición
 * @param {string} id - ID del producto a editar
 */
function Editar(id) {
    // Obtener datos del producto
    fetch("editar.php", {
        method: "POST",
        body: id  // Enviar ID del producto
    }).then(response => response.json()).then(response => {
        // Cargar datos en el formulario
        idp.value = response.id;
        codigo.value = response.codigo;
        producto.value = response.producto;
        precio.value = response.precio;
        cantidad.value = response.cantidad;
        // Cambiar botón a modo "Actualizar"
        registrar.value = "Actualizar"
    })
}

// Event listener para búsqueda en tiempo real
buscar.addEventListener("keyup", () => {
    const valor = buscar.value;
    if (valor == "") {
        // Si no hay texto, mostrar todos los productos
        ListarProductos();
    }else{
        // Buscar productos que coincidan con el término
        ListarProductos(valor);
    }
});
