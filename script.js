/**
 * SCRIPT.JS - Lógica del lado cliente para el CRUD de productos
 * Usa Fetch API para comunicación con el servidor
 */

// Se ejecuta cuando la página termina de cargar
document.addEventListener("DOMContentLoaded", function () {
    ListarProductos(); // Carga la lista inicial de productos
});

/**
 * Lista todos los productos o filtra por criterio de búsqueda
 * @param {string} busqueda - Criterio de búsqueda (opcional)
 */
function ListarProductos(busqueda = "") {
    // Envía petición POST a listar.php
    fetch("listar.php", {
        method: "POST",
        body: busqueda // Criterio de búsqueda en el body
    })
    .then(response => response.text()) // Convierte respuesta a texto
    .then(html => {
        resultado.innerHTML = html; // Inserta HTML en la tabla
    });
}

/**
 * Maneja el evento click del botón Registrar/Actualizar
 * Determina si es una operación de guardar o modificar
 */
registrar.addEventListener("click", () => {
    // Obtiene los datos del formulario
    const formData = new FormData(frm);
    
    // Determina la acción según el texto del botón
    let accion = registrar.value === "Registrar" ? "Guardar" : "Modificar";
    formData.append("Accion", accion); // Añade la acción a los datos

    // Envía petición POST a registrar.php
    fetch("registrar.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json()) // Convierte respuesta a JSON
    .then(res => {
        // Procesa la respuesta según la acción
        switch (res.accion) {
            case "guardar":
                if (res.success) {
                    Swal.fire('¡Éxito!', res.message, 'success');
                    frm.reset(); // Limpia el formulario
                    registrar.value = "Registrar"; // Resetea el botón
                    idp.value = ""; // Limpia el ID
                    ListarProductos(); // Actualiza la lista
                } else {
                    Swal.fire('Error', res.message, 'error');
                }
                break;
            case "modificar":
                if (res.success) {
                    Swal.fire('¡Modificado!', res.message, 'success');
                    frm.reset(); // Limpia el formulario
                    registrar.value = "Registrar"; // Resetea el botón
                    idp.value = ""; // Limpia el ID
                    ListarProductos(); // Actualiza la lista
                } else {
                    Swal.fire('Error', res.message, 'error');
                }
                break;
            default:
                Swal.fire('Error', res.message, 'error');
                break;
        }
    });
});

/**
 * Busca productos en tiempo real mientras el usuario escribe
 */
buscar.addEventListener("keyup", () => {
    const valor = buscar.value; // Obtiene el valor del campo de búsqueda
    ListarProductos(valor); // Filtra productos con el criterio
});

/**
 * Carga los datos de un producto en el formulario para edición
 * @param {number} id - ID del producto a editar
 */
function Editar(id) {
    // Envía petición POST a editar.php con el ID
    fetch("editar.php", {
        method: "POST",
        body: id
    })
    .then(response => response.json()) // Convierte respuesta a JSON
    .then(data => {
        // Llena el formulario con los datos del producto
        idp.value = data.id;
        codigo.value = data.codigo;
        producto.value = data.producto;
        precio.value = data.precio;
        cantidad.value = data.cantidad;
        registrar.value = "Actualizar"; // Cambia el botón a "Actualizar"
    });
}

/**
 * Elimina un producto con confirmación del usuario
 * @param {number} id - ID del producto a eliminar
 */
function Eliminar(id) {
    // Muestra diálogo de confirmación con SweetAlert
    Swal.fire({
        title: '¿Está seguro de eliminar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'NO'
    }).then((result) => {
        // Si el usuario confirma la eliminación
        if (result.isConfirmed) {
            // Envía petición POST a eliminar.php
            fetch("eliminar.php", {
                method: "POST",
                body: id
            })
            .then(response => response.json()) // Convierte respuesta a JSON
            .then(respuesta => {
                if (respuesta.success) {
                    Swal.fire('Eliminado', respuesta.message, 'success');
                    ListarProductos(); // Actualiza la lista
                } else {
                    Swal.fire('Error', respuesta.message, 'error');
                }
            }).catch(() => {
                // Maneja errores de comunicación
                Swal.fire('Error', 'Error de comunicación con el servidor.', 'error');
            });
        }
    });
}