<?php
require_once(__DIR__ . '/../models/mesas.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mesas</title>
    <link href="../css/style.css" rel="stylesheet">
    <style>
        .mesas-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .mesa {
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            font-size: 1.1rem;
            font-weight: bold;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .mesa:hover {
            transform: scale(1.05);
        }

        .mesa-disponible {
            background-color: #2ecc71;
            color: white;
        }
        
        .mesa-ocupada {
            background-color: #e74c3c;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Estado de las Mesas</h2>
        <div class="mesas-grid">
            <?php foreach ($mesas as $mesa): ?>
                <?php if ($mesa['numero'] == 0): ?>
                    <div class="mesa <?= obtenerClaseEstado($mesa['estado']) ?>" data-numero="0">Domicilio</div>
                <?php else: ?>
                    <div class="mesa <?= obtenerClaseEstado($mesa['estado']) ?>"
                         data-numero="<?= $mesa['numero'] ?>">
                        Mesa <?= $mesa['numero'] ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
    function mostrarToast(mensaje, tipo = 'info') {
    const toast = document.createElement('div');
    toast.textContent = mensaje;
    toast.style.position = 'fixed';
    toast.style.bottom = '20px';
    toast.style.right = '20px';
    toast.style.padding = '12px 18px';
    toast.style.backgroundColor = tipo === 'error' ? '#e74c3c' : '#27ae60';
    toast.style.color = 'white';
    toast.style.borderRadius = '8px';
    toast.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.1)';
    toast.style.zIndex = 1000;
    toast.style.opacity = 1;
    toast.style.transition = 'opacity 0.5s ease-out';

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.style.opacity = 0;
        setTimeout(() => toast.remove(), 500);
    }, 2000);
}

    document.addEventListener('DOMContentLoaded', () => {
    const mesas = document.querySelectorAll('.mesa');

    mesas.forEach(mesa => {
        mesa.addEventListener('click', () => {
            const numero = mesa.dataset.numero;
            if (numero == 0) return;

            fetch('../controllers/mesasController.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ numero })
            })
            .then(res => res.json())
            .then(data => {
                if (data.error) {
                 mostrarToast(data.error, 'error');
                return;
            }

            // Redirigir al formulario después del cambio de estado
            window.location.href = `../views/ver_pedidos.php?mesa=${numero}`;
            })
            .catch(err => {
                mostrarToast('Error de red', 'error');
                console.error('Error:', err);
            });
        });
    });
});
</script>

</body>
</html>
