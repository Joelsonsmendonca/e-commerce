var btnEntrar = document.querySelector("#entrar");
var btnCriar = document.querySelector("#criar");

var body = document.querySelector("body");

btnEntrar.addEventListener("click", function () {
    body.className = "entrar-js";
});

btnCriar.addEventListener("click", function () {
    body.className = "criar-js";
})