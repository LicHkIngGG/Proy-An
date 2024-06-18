var express = require("express");
var path = require("path");
var bodyParser = require("body-parser");
var compiler = require("compilex"); // Se asume que 'compilex' es un paquete npm instalado

var app = express();
app.use(bodyParser());

var option = { stats: true };
compiler.init(option);

// Ruta para cargar la página principal
app.get("/", function (req, res) {
    res.sendFile(path.join(__dirname, "/index.html"));
});

// Ruta para compilar y ejecutar el código
app.post("/compilecode", function (req, res) {
    var code = req.body.code;
    var input = req.body.input;
    var inputRadio = req.body.inputRadio;
    var lang = req.body.lang;

    if (lang === "C" || lang === "C++") {
        // Compilar y ejecutar código en C o C++
        // Se asume que 'compileCPPWithInput' y 'compileCPP' son funciones de 'compilex'
        // y que toman como argumentos el entorno, el código y la entrada (si corresponde)
        if (inputRadio === "true") {
            var envData = { OS: "windows", cmd: "g++", options: { timeout: 10000 } };
            compiler.compileCPPWithInput(envData, code, input, function (data) {
                if (data.error) {
                    res.send(data.error);
                } else {
                    res.send(data.output);
                }
            });
        } else {
            var envData = { OS: "windows", cmd: "g++", options: { timeout: 10000 } };
            compiler.compileCPP(envData, code, function (data) {
                res.send(data);
            });
        }
    }

    if (lang === "Python") {
        // Compilar y ejecutar código en Python
        // Se asume que 'compilePythonWithInput' y 'compilePython' son funciones de 'compilex'
        // y que toman como argumentos el entorno, el código y la entrada (si corresponde)
        if (inputRadio === "true") {
            var envData = { OS: "windows" };
            compiler.compilePythonWithInput(envData, code, input, function (data) {
                res.send(data);
            });
        } else {
            var envData = { OS: "windows" };
            compiler.compilePython(envData, code, function (data) {
                res.send(data);
            });
        }
    }
});

// Ruta para obtener estadísticas completas del compilador
app.get("/fullStat", function (req, res) {
    compiler.fullStat(function (data) {
        res.send(data);
    });
});

// Iniciar el servidor en el puerto 8080
app.listen(8080, function () {
    console.log("Servidor iniciado en el puerto 8080");
});

// Limpiar los archivos temporales del compilador
compiler.flush(function () {
    console.log("¡Todos los archivos temporales eliminados!");
});
