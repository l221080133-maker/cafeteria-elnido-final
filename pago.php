<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forma de Pago - Al Nido</title>
    <style>
        body {
            background-color: #121212;
            color: #ffffff;
            font-family: 'Arial', sans-serif;
            text-align: center;
            padding: 50px 20px;
            margin: 0;
        }
        .contenedor-pago {
            max-width: 450px;
            margin: 0 auto;
            background-color: #1e1e1e;
            padding: 30px;
            border-radius: 12px;
            border: 2px solid #ccff00;
            box-shadow: 0px 0px 20px rgba(204, 255, 0, 0.2);
        }
        h2 { 
            color: #ccff00; 
            margin-bottom: 10px;
            font-size: 24px;
            letter-spacing: 1px;
        }
        .slogan {
            color: #888;
            font-style: italic;
            margin-bottom: 25px;
            font-size: 14px;
        }
        .opcion-pago {
            background-color: #252525;
            border: 2px solid #333;
            padding: 18px;
            margin: 15px 0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: bold;
        }
        .opcion-pago:hover {
            border-color: #ccff00;
            background-color: #2a2a2a;
            transform: translateY(-2px);
        }
        .opcion-pago.seleccionada {
            border-color: #ccff00;
            background-color: #333;
        }
        #formulario-tarjeta {
            background-color: #252525;
            padding: 20px;
            border-radius: 8px;
            margin-top: 15px;
            border: 1px solid #444;
            text-align: left;
        }
        #formulario-tarjeta h3 {
            margin-top: 0;
            color: #fff;
            font-size: 16px;
            margin-bottom: 15px;
        }
        .campo-input {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            background-color: #1a1a1a;
            border: 1px solid #444;
            color: #fff;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .campo-input:focus {
            border-color: #ccff00;
            outline: none;
        }
        .fila-tarjeta {
            display: flex;
            gap: 10px;
        }
        .btn-finalizar {
            background-color: #ccff00;
            color: #000;
            border: none;
            padding: 14px 30px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 20px;
            width: 100%;
            transition: 0.2s;
        }
        .btn-finalizar:hover { 
            background-color: #b5e600; 
        }
        .oculto { 
            display: none; 
        }
    </style>
</head>
<body>

    <div class="contenedor-pago">
        <h2>MÉTODO DE PAGO</h2>
        <div class="slogan">"Ódiame más, mi café es tu envidia"</div>
        
        <div id="btn-efectivo" class="opcion-pago" onclick="seleccionarMetodo('efectivo')">
            💵 Pago en Efectivo (Al recoger)
        </div>
        
        <div id="btn-tarjeta" class="opcion-pago" onclick="seleccionarMetodo('tarjeta')">
            💳 Tarjeta de Crédito / Débito
        </div>

        <div id="formulario-tarjeta" class="oculto">
            <h3>Datos de la Tarjeta (Simulador)</h3>
            <input type="text" class="campo-input" placeholder="Número de Tarjeta (16 dígitos)" maxlength="16">
            <div class="fila-tarjeta">
                <input type="text" class="campo-input" placeholder="MM/AA" maxlength="5" style="width: 50%;">
                <input type="password" class="campo-input" placeholder="CVV" maxlength="3" style="width: 50%;">
            </div>
            <input type="text" class="campo-input" placeholder="Nombre del Titular">
        </div>

        <button class="btn-finalizar" onclick="finalizarOrden()">CONFIRMAR PEDIDO CAMPEÓN</button>
    </div>

    <script>
        let metodoSeleccionado = '';

        function seleccionarMetodo(tipo) {
            metodoSeleccionado = tipo;
            
            const btnEfectivo = document.getElementById('btn-efectivo');
            const btnTarjeta = document.getElementById('btn-tarjeta');
            const formTarjeta = document.getElementById('formulario-tarjeta');
            
            btnEfectivo.classList.remove('seleccionada');
            btnTarjeta.classList.remove('seleccionada');
            
            if (tipo === 'tarjeta') {
                btnTarjeta.classList.add('seleccionada');
                formTarjeta.classList.remove('oculto');
            } else {
                btnEfectivo.classList.add('seleccionada');
                formTarjeta.classList.add('oculto');
            }
        }

        function finalizarOrden() {
            if (metodoSeleccionado === '') {
                alert('⚠️ Por favor, selecciona una forma de pago antes de continuar.');
                return;
            }
            
            if (metodoSeleccionado === 'tarjeta') {
                alert('💳 [SIMULADOR] Procesando pago con tarjeta bancaria de forma segura...\n\n¡Transacción Autorizada con éxito!');
            } else {
                alert('💵 [SIMULADOR] Registro de pago en efectivo guardado.\n\nRecuerda pagar al momento de recibir tu orden.');
            }
            
            alert('🚀 ¡COMPRA EXITOSA!\n\nTu orden ha sido enviada. Regresando al menú principal.');
            window.location.href = 'index.php'; 
        }
    </script>
</body>
</html>