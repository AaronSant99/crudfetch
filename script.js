// Cargar la lista de productos al iniciar la página
document.addEventListener("DOMContentLoaded", function () {
    ListarProductos();
});

function ListarProductos(busqueda = "") {
    fetch("listar.php", {
        method: "POST",
        body: busqueda
    })
    .then(response => response.text())
    .then(html => {
        resultado.innerHTML = html;
    });
}

// Centralizar lógica de Guardar/Modificar con switch en JS
registrar.addEventListener("click", () => {
    const formData = new FormData(frm);
    let accion = registrar.value === "Registrar" ? "Guardar" : "Modificar";
    formData.append("Accion", accion);

    fetch("registrar.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(res => {
        switch (res.accion) {
            case "guardar":
                if (res.success) {
                    Swal.fire('¡Éxito!', res.message, 'success');
                    frm.reset();
                    registrar.value = "Registrar";
                    idp.value = "";
                    ListarProductos();
                } else {
                    Swal.fire('Error', res.message, 'error');
                }
                break;
            case "modificar":
                if (res.success) {
                    Swal.fire('¡Modificado!', res.message, 'success');
                    frm.reset();
                    registrar.value = "Registrar";
                    idp.value = "";
                    ListarProductos();
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

// Buscar productos en tiempo real
buscar.addEventListener("keyup", () => {
    const valor = buscar.value;
    ListarProductos(valor);
});

// Función para cargar datos en el formulario para edición
function Editar(id) {
    fetch("editar.php", {
        method: "POST",
        body: id
    })
    .then(response => response.json())
    .then(data => {
        idp.value = data.id;
        codigo.value = data.codigo;
        producto.value = data.producto;
        precio.value = data.precio;
        cantidad.value = data.cantidad;
        registrar.value = "Actualizar";
    });
}

// Función para eliminar un producto
function Eliminar(id) {
    Swal.fire({
        title: '¿Está seguro de eliminar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'NO'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch("eliminar.php", {
                method: "POST",
                body: id
            })
            .then(response => response.json())
            .then(respuesta => {
                if (respuesta.success) {
                    Swal.fire('Eliminado', respuesta.message, 'success');
                    ListarProductos();
                } else {
                    Swal.fire('Error', respuesta.message, 'error');
                }
            }).catch(() => {
                Swal.fire('Error', 'Error de comunicación con el servidor.', 'error');
            });
        }
    });
}