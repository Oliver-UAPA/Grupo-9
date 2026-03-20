let productos = [];
let paginaActual = 1;
const porPagina = 5;
let editIndex = null;


document.addEventListener("DOMContentLoaded", () => {
    checkAuth();
    mostrarUsuario();
    cargarProductos();
});


function cargarProductos() {
    fetch("http://grupo9.test/api/get_productos.php")
    .then(res => res.json())
    .then(data => {
        productos = data;
        render();
    });
}


function render() {
    const tabla = document.getElementById("tablaRegistros");
    tabla.innerHTML = "";

    let inicio = (paginaActual - 1) * porPagina;
    let datos = productos.slice(inicio, inicio + porPagina);

    datos.forEach((p, i) => {
        tabla.innerHTML += `
        <tr>
            <td>${p.nombre}</td>
            <td>${p.tipo}</td>
            <td>${p.cantidad}</td>
            <td>$${p.costo}</td>
            <td>${p.stock}</td>
            <td>${p.usuario || "Admin"}</td>
            <td>
                <button class="btn-edit" onclick="abrirModal(${inicio + i})">Editar</button>
                <button class="btn-delete" onclick="eliminar(${p.id})">Eliminar</button>
            </td>
        </tr>`;
    });

    
    document.getElementById("totalProductos").innerText = productos.length;

    let totalCantidad = productos.reduce((sum, p) => sum + (parseInt(p.cantidad) || 0), 0);
    document.getElementById("totalCantidad").innerText = totalCantidad;

    let totalCosto = productos.reduce((sum, p) =>
        sum + ((parseInt(p.cantidad) || 0) * (parseFloat(p.costo) || 0)), 0
    );
    document.getElementById("totalCosto").innerText = "$" + totalCosto.toLocaleString();

    let totalStock = productos.filter(p => p.stock === "si").length;
    document.getElementById("totalStock").innerText = totalStock;

    paginacion();
}


function paginacion() {
    let total = Math.ceil(productos.length / porPagina);
    let cont = document.getElementById("paginacion");
    cont.innerHTML = "";

    for (let i = 1; i <= total; i++) {
        cont.innerHTML += `<button onclick="cambiar(${i})">${i}</button>`;
    }
}

function cambiar(p) {
    paginaActual = p;
    render();
}


function eliminar(id) {
    if (confirm("Eliminar producto?")) {

        fetch("http://grupo9.test/api/delete_producto.php", {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify({ id })
        })
        .then(res => res.json())
        .then(() => {
            cargarProductos();
        });
    }
}


function abrirModal(i) {
    editIndex = i;
    document.getElementById("modal").style.display = "flex";

    let p = productos[i];

    editNombre.value = p.nombre;
    editTipo.value = p.tipo;
    editCantidad.value = p.cantidad;
    editCosto.value = p.costo;
    editStock.value = p.stock;
}

function cerrarModal() {
    document.getElementById("modal").style.display = "none";
}

document.getElementById("btnGuardar").addEventListener("click", () => {

    let p = productos[editIndex];
    let usuarioActual = JSON.parse(localStorage.getItem("session")) || { user: "Admin" };

    fetch("http://grupo9.test/api/update_producto.php", {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({
            id: p.id,
            nombre: editNombre.value,
            tipo: editTipo.value,
            cantidad: parseInt(editCantidad.value) || 0,
            costo: parseFloat(editCosto.value) || 0,
            stock: editStock.value,
            usuario: usuarioActual.user
        })
    })
    .then(res => res.json())
    .then(() => {
        cerrarModal();
        cargarProductos();
    });
});