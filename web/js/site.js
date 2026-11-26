/* Comportamiento general del sitio */
window.Sitio = (function () {
    'use strict';

    /* ---------- Mensajes (SweetAlert) ---------- */

    function mensaje(opciones) {
        if (!window.Swal) {
            alert((opciones.title || '') + '\n' + (opciones.html || opciones.text || '').replace(/<[^>]+>/g, ''));
            return Promise.resolve({ isConfirmed: true });
        }
        var estilo = getComputedStyle(document.documentElement);
        return Swal.fire(Object.assign({
            confirmButtonText: 'Aceptar',
            background: estilo.getPropertyValue('--superficie').trim() || undefined,
            color: estilo.getPropertyValue('--texto').trim() || undefined,
            confirmButtonColor: estilo.getPropertyValue('--primario').trim() || undefined
        }, opciones));
    }

    /* Los data-confirm de Yii (borrar, etc.) usan SweetAlert en lugar del confirm() del navegador */
    if (window.yii) {
        yii.confirm = function (texto, ok, cancelar) {
            mensaje({
                icon: 'warning', title: 'Confirmá', text: texto, showCancelButton: true,
                confirmButtonText: 'Sí, continuar', cancelButtonText: 'Cancelar', focusCancel: true
            }).then(function (r) {
                if (r.isConfirmed) { ok && ok(); } else { cancelar && cancelar(); }
            });
        };
    }

    function aviso(titulo) {
        if (window.Swal) {
            Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: titulo, timer: 1500, showConfirmButton: false });
        }
    }

    /* ---------- Compartir ---------- */

    function copiar(texto) {
        if (navigator.clipboard && window.isSecureContext) {
            return navigator.clipboard.writeText(texto);
        }
        return Promise.reject();
    }

    document.addEventListener('click', function (e) {
        var boton = e.target.closest('[data-copiar]');
        if (boton) {
            var link = boton.getAttribute('data-copiar');
            copiar(link).then(function () { aviso('Link copiado'); }, function () {
                mensaje({ icon: 'info', title: 'Copiá el link', text: link });
            });
        }
        var nativo = e.target.closest('[data-compartir-nativo]');
        if (nativo && navigator.share) {
            navigator.share({ title: nativo.getAttribute('data-titulo'), url: nativo.getAttribute('data-url') }).catch(function () {});
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        if (!navigator.share) { return; }
        document.querySelectorAll('[data-compartir-nativo]').forEach(function (b) { b.classList.remove('d-none'); });
    });

    /* ---------- Fotos en grande (galería y ficha) ---------- */

    document.addEventListener('click', function (e) {
        var boton = e.target.closest('[data-ampliar]');
        if (!boton || !window.Swal) { return; }
        Swal.fire({
            imageUrl: boton.getAttribute('data-ampliar'), imageAlt: boton.getAttribute('data-titulo') || 'Foto',
            title: boton.getAttribute('data-titulo') || undefined, width: 'min(96vw, 960px)',
            showConfirmButton: false, showCloseButton: true, background: '#111', color: '#fff'
        });
    });

    /* ---------- WhatsApp: pedido de presupuesto ---------- */

    function abrirWhatsApp(url, lineas) {
        window.open(url + '?text=' + encodeURIComponent(lineas.join('\n')), '_blank', 'noopener');
    }

    document.addEventListener('submit', function (e) {
        var form = e.target.closest('[data-consulta]');
        if (!form) { return; }
        e.preventDefault();
        var lineas = ['¡Hola! Quiero pedir un presupuesto.'];
        form.querySelectorAll('[data-etiqueta]').forEach(function (c) {
            var valor = c.value.trim();
            if (c.type === 'date' && valor) { valor = valor.split('-').reverse().join('/'); }
            if (valor) { lineas.push(c.getAttribute('data-etiqueta') + ': ' + valor); }
        });
        var incluye = Array.prototype.map.call(form.querySelectorAll('[data-incluye]:checked'), function (c) { return c.value; });
        if (incluye.length) { lineas.push('Incluir: ' + incluye.join(', ')); }
        abrirWhatsApp(form.getAttribute('data-consulta'), lineas);
    });

    /* ---------- Tu pedido: se guarda en el navegador del visitante ---------- */

    // La carpeta del sitio distingue el pedido de otros sitios del mismo dominio (localhost)
    var CLAVE = 'pedido:' + (document.querySelector('.marca') ? document.querySelector('.marca').getAttribute('href') : '/');

    function leerPedido() {
        try { return JSON.parse(localStorage.getItem(CLAVE)) || {}; } catch (e) { return {}; }
    }

    var pedido = {};

    function pesos(n) { return '$ ' + n.toLocaleString('es-AR'); }

    function mostrarPedido() {
        var lista = document.querySelector('[data-pedido-lista]');
        if (!lista) { return; }
        var cantidad = 0, total = 0, sinPrecio = false;
        lista.innerHTML = '';
        Object.keys(pedido).forEach(function (id) {
            var p = pedido[id];
            cantidad += p.cantidad;
            total += p.cantidad * p.precio;
            sinPrecio = sinPrecio || !p.precio;
            var li = document.createElement('li');
            li.innerHTML = '<span class="nombre"></span><button type="button" data-restar aria-label="Quitar uno">−</button>'
                + '<strong></strong><button type="button" data-sumar aria-label="Agregar uno">+</button>';
            li.querySelector('.nombre').textContent = p.nombre;
            li.querySelector('strong').textContent = p.cantidad;
            li.setAttribute('data-id', id);
            lista.appendChild(li);
        });
        if (!cantidad) { lista.innerHTML = '<li>Todavía no agregaste nada.</li>'; }
        document.querySelector('[data-pedido-total]').textContent = total
            ? 'Total estimado: ' + pesos(total) + (sinPrecio ? ' + productos a consultar' : '') : '';
        document.querySelector('[data-pedido-cantidad]').textContent = cantidad;
        document.querySelector('.pedido-boton').classList.toggle('d-none', !cantidad);
        document.querySelector('[data-pedido-form]').classList.toggle('d-none', !cantidad);
    }

    function guardarPedido() {
        try { localStorage.setItem(CLAVE, JSON.stringify(pedido)); } catch (e) { /* modo privado */ }
        mostrarPedido();
    }

    document.addEventListener('click', function (e) {
        var agregar = e.target.closest('[data-agregar]');
        if (agregar) {
            var id = agregar.getAttribute('data-agregar');
            pedido[id] = {
                nombre: agregar.getAttribute('data-nombre'),
                precio: parseFloat(agregar.getAttribute('data-precio')) || 0,
                cantidad: (pedido[id] ? pedido[id].cantidad : 0) + 1
            };
            guardarPedido();
            aviso('Agregado a tu pedido');
            return;
        }
        var boton = e.target.closest('[data-sumar], [data-restar]');
        if (boton) {
            var clave = boton.closest('[data-id]').getAttribute('data-id');
            pedido[clave].cantidad += boton.hasAttribute('data-sumar') ? 1 : -1;
            if (pedido[clave].cantidad < 1) { delete pedido[clave]; }
            guardarPedido();
            return;
        }
        if (e.target.closest('[data-pedido-vaciar]')) {
            pedido = {};
            guardarPedido();
        }
    });

    document.addEventListener('submit', function (e) {
        if (!e.target.matches('[data-pedido-form]')) { return; }
        e.preventDefault();
        var lineas = ['¡Hola! Quiero hacer un pedido:'];
        var total = 0;
        Object.keys(pedido).forEach(function (id) {
            var p = pedido[id];
            total += p.cantidad * p.precio;
            lineas.push('• ' + p.cantidad + ' x ' + p.nombre + (p.precio ? ' (' + pesos(p.cantidad * p.precio) + ')' : ''));
        });
        if (total) { lineas.push('Total estimado: ' + pesos(total)); }
        lineas.push('', 'Nombre: ' + document.getElementById('p-nombre').value.trim(),
            'Entrega: ' + document.getElementById('p-entrega').value);
        var nota = document.getElementById('p-nota').value.trim();
        if (nota) { lineas.push('Detalle: ' + nota); }
        abrirWhatsApp(document.getElementById('pedido').getAttribute('data-whatsapp'), lineas);
    });

    document.addEventListener('DOMContentLoaded', function () {
        CLAVE = 'pedido:' + (document.querySelector('.marca') ? document.querySelector('.marca').getAttribute('href') : '/');
        pedido = leerPedido();
        mostrarPedido();
    });

    /* ---------- Vista previa de las fotos elegidas ---------- */

    document.addEventListener('change', function (e) {
        if (!e.target.matches('[data-vista-previa]')) { return; }
        var destino = document.querySelector(e.target.getAttribute('data-vista-previa'));
        if (!destino) { return; }
        destino.innerHTML = '';
        Array.prototype.forEach.call(e.target.files || [], function (archivo) {
            if (!/^image\//.test(archivo.type)) { return; }
            var img = document.createElement('img');
            img.src = URL.createObjectURL(archivo);
            img.alt = '';
            destino.appendChild(img);
        });
    });

    /* ---------- Compresión de fotos antes de subir ----------
       Los campos con data-comprimir="1600" achican cada foto a ese lado máximo y la pasan a JPG
       en el navegador: una foto de celular de 8 MB queda en unos 300 KB. El servidor la vuelve a
       procesar igual (si el navegador no puede comprimir, se sube la original). */

    var comprimidas = new WeakSet();

    function comprimir(archivo, lado) {
        if (!/^image\/(jpeg|png|webp)$/.test(archivo.type) || comprimidas.has(archivo) || !window.createImageBitmap) {
            return Promise.resolve(archivo);
        }
        // imageOrientation: la foto sale derecha según el EXIF del celular
        return createImageBitmap(archivo, { imageOrientation: 'from-image' }).then(function (bmp) {
            var escala = Math.min(1, lado / Math.max(bmp.width, bmp.height));
            // Ya es chica y liviana, o es un PNG chico (un logo con transparencia): se deja como está
            if (escala === 1 && archivo.size < 600 * 1024) {
                comprimidas.add(archivo);
                return archivo;
            }
            var lienzo = document.createElement('canvas');
            lienzo.width = Math.round(bmp.width * escala);
            lienzo.height = Math.round(bmp.height * escala);
            var ctx = lienzo.getContext('2d');
            ctx.fillStyle = '#fff';   // fondo blanco para PNG con transparencia
            ctx.fillRect(0, 0, lienzo.width, lienzo.height);
            ctx.drawImage(bmp, 0, 0, lienzo.width, lienzo.height);
            return new Promise(function (listo) {
                lienzo.toBlob(function (blob) {
                    if (!blob || blob.size >= archivo.size) {   // no mejoró: queda la original
                        comprimidas.add(archivo);
                        return listo(archivo);
                    }
                    var nueva = new File([blob], archivo.name.replace(/\.\w+$/, '') + '.jpg', { type: 'image/jpeg' });
                    comprimidas.add(nueva);
                    listo(nueva);
                }, 'image/jpeg', 0.85);
            });
        }).catch(function () { return archivo; });
    }

    document.addEventListener('change', function (e) {
        var campo = e.target;
        if (!campo.matches('input[type=file][data-comprimir]') || !window.DataTransfer) { return; }
        var archivos = Array.prototype.slice.call(campo.files);
        if (!archivos.length || archivos.every(function (f) { return comprimidas.has(f); })) { return; }

        // Mientras se preparan las fotos no se puede enviar el formulario
        var botones = campo.form ? campo.form.querySelectorAll('[type=submit]') : [];
        botones.forEach(function (b) { b.disabled = true; });

        var lado = parseInt(campo.getAttribute('data-comprimir'), 10) || 1600;
        Promise.all(archivos.map(function (f) { return comprimir(f, lado); })).then(function (listas) {
            var juntas = new DataTransfer();
            listas.forEach(function (f) { juntas.items.add(f); });
            campo.files = juntas.files;
            botones.forEach(function (b) { b.disabled = false; });
            campo.dispatchEvent(new Event('change', { bubbles: true }));   // actualiza la vista previa
        });
    });

    /* ---------- Botón "Sacar foto": suma cada foto de la cámara al campo de fotos ---------- */

    document.addEventListener('change', function (e) {
        if (!e.target.matches('[data-camara-para]')) { return; }
        var camara = e.target;
        var destino = document.querySelector(camara.getAttribute('data-camara-para'));
        if (!destino || !camara.files.length || !window.DataTransfer) { return; }
        var juntas = new DataTransfer();
        if (destino.multiple) {
            Array.prototype.forEach.call(destino.files, function (f) { juntas.items.add(f); });
        }
        Array.prototype.forEach.call(camara.files, function (f) { juntas.items.add(f); });
        destino.files = juntas.files;
        camara.value = '';   // listo para sacar otra
        destino.dispatchEvent(new Event('change', { bubbles: true }));
    });

    return { mensaje: mensaje };
})();
