const form = document.getElementById("formRegistro");
const mensaje = document.getElementById("mensaje");
const btn = document.getElementById("btnSubmit");


document.querySelectorAll("input, select").forEach(el => {
    el.addEventListener("input", () => {
        if (el.value.trim() === "") {
            el.classList.add("input-error");
        } else {
            el.classList.remove("input-error");
        }
    });
});


if(form){
    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const nombre = document.getElementById("nombre").value.trim();
        const tipo = document.getElementById("tipo").value.trim();
        const cantidad = parseInt(document.getElementById("cantidad").value) || 0;
        const costo = parseFloat(document.getElementById("costo").value) || 0;
        const stock = document.getElementById("stock").value;

        if (!nombre || !tipo || !stock) {
            mensaje.innerHTML = `<div class="alert error">Completa los campos obligatorios</div>`;
            return;
        }

        // usuario logueado
        let session = JSON.parse(localStorage.getItem("session")) || { user: "Admin" };

        btn.innerText = "Guardando...";
        btn.disabled = true;

        const producto = {
            nombre,
            tipo,
            cantidad,
            costo,
            stock,
            usuario: session.user
        };

       
        fetch("http://grupo9.test/api/guardar_producto.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(producto)
        })
        .then(res => res.json())
        .then(() => {

            mensaje.innerHTML = `<div class="alert success">Producto guardado correctamente</div>`;

            form.reset();
            btn.innerText = "Guardar Producto";
            btn.disabled = false;
        })
        .catch(() => {
            mensaje.innerHTML = `<div class="alert error">Error al guardar</div>`;
            btn.innerText = "Guardar Producto";
            btn.disabled = false;
        });
    });
}