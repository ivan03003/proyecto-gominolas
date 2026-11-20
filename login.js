const formulario = document.getElementById("loginForm");

formulario.addEventListener("submit", function(event) {
    event.preventDefault();
    const control = document.getElementById("control").value.trim();
    const password = document.getElementById("password").value;
    const usuarios = JSON.parse(
localStorage.getItem("usuarios") ||"[]"
    );
    const usuarioEncontrado = usuarios.find(usuario =>
        usuario.control === control &&
        usuario.password === password
    );
    if (usuarioEncontrado) {
        alert("¡Bienvenido, " + usuarioEncontrado.nombre + "!");
        sessionStorage.setItem(
            "usuarioActivo",
            usuarioEncontrado.control
        );
        window.location.href = "inicio.html";

    }else{
        alert("Numero de control o contraseña incorrectos.");
    }
})