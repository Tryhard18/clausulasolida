/**
 * ClÃ¡usula SÃ³lida â€” LÃ³gica do Cliente
 * Menu, animaÃ§Ãµes, validaÃ§Ã£o de formulÃ¡rio, submissÃ£o AJAX, interaÃ§Ãµes premium
 */
'use strict';

document.addEventListener('DOMContentLoaded', () => {

    // =====================================================
    // 1. MODO ESCURO (THEME TOGGLE)
    // =====================================================
    const themeToggle = document.getElementById('theme-toggle');
    
    // Aplicar o tema guardado ao carregar (ReforÃ§o)
    if (localStorage.getItem('theme') === 'dark') {
        document.body.classList.add('dark-mode');
        document.documentElement.classList.add('dark-mode');
    }

    if (themeToggle) {
        themeToggle.addEventListener('click', () => {
            document.body.classList.toggle('dark-mode');
            const isDark = document.documentElement.classList.toggle('dark-mode');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        });
    }

    // =====================================================
    // 2. MENU RESPONSIVO (HAMBURGER)
    // =====================================================
    const menuToggle = document.getElementById('menu-toggle');
    const navLista = document.getElementById('nav-lista');
    const navOverlay = document.getElementById('nav-overlay');
    const cabecalho = document.getElementById('cabecalho');

    function fecharMenu() {
        menuToggle?.classList.remove('ativo');
        navLista?.classList.remove('aberto');
        navOverlay?.classList.remove('aberto');
        menuToggle?.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
    }

    menuToggle?.addEventListener('click', () => {
        const aberto = navLista.classList.toggle('aberto');
        menuToggle.classList.toggle('ativo');
        navOverlay?.classList.toggle('aberto');
        menuToggle.setAttribute('aria-expanded', aberto ? 'true' : 'false');
        document.body.style.overflow = aberto ? 'hidden' : '';
    });

    navOverlay?.addEventListener('click', fecharMenu);
    navLista?.querySelectorAll('a').forEach(link => link.addEventListener('click', fecharMenu));
    document.getElementById('fechar-menu-mobile')?.addEventListener('click', fecharMenu);
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') fecharMenu(); });

    // =====================================================
    // 3. HEADER E PARALLAX (BLOBS & IMAGENS SOBRE)
    // =====================================================
    const blobs = document.querySelectorAll('.blob');
    const imgPrincipal = document.querySelector('.img-principal');
    const imgSecundaria = document.querySelector('.img-secundaria');
    const imgTerciaria = document.querySelector('.img-terciaria');

    window.addEventListener('scroll', () => {
        const scroll = window.scrollY;

        // Header scrolled state
        cabecalho?.classList.toggle('scrolled', scroll > 50);

        // Parallax Blobs
        blobs.forEach((blob, index) => {
            const speed = (index + 1) * 0.15;
            blob.style.transform = `translateY(${scroll * speed}px)`;
        });

        // Parallax Imagens Sobre
        if (imgPrincipal) imgPrincipal.style.transform = `translateY(${scroll * 0.05}px)`;
        if (imgSecundaria) imgSecundaria.style.transform = `translateY(${scroll * -0.03}px)`;
        if (imgTerciaria) imgTerciaria.style.transform = `translateY(${scroll * 0.08}px)`;
    }, { passive: true });

    // =====================================================
    // 4. CUSTOM CURSOR
    // =====================================================
    const cursor = document.getElementById('cursor-follower');
    if (cursor) {
        document.addEventListener('mousemove', (e) => {
            cursor.style.left = e.clientX + 'px';
            cursor.style.top = e.clientY + 'px';
        });

        const interactiveElements = document.querySelectorAll('a, button, .portfolio-item, .servico-cartao, .btn-magnetico');
        interactiveElements.forEach(el => {
            el.addEventListener('mouseenter', () => cursor.classList.add('hover'));
            el.addEventListener('mouseleave', () => cursor.classList.remove('hover'));
        });
    }

    // =====================================================
    // 5. ANIMAÃ‡Ã•ES ON SCROLL (IntersectionObserver)
    // =====================================================
    const elementosAnimar = document.querySelectorAll('.animar');
    if (elementosAnimar.length > 0 && 'IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, i) => {
                if (entry.isIntersecting) {
                    setTimeout(() => entry.target.classList.add('visivel'), i * 100);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
        elementosAnimar.forEach(el => observer.observe(el));
    }

    // =====================================================
    // 6. CONTAGEM ANIMADA DE NÃšMEROS
    // =====================================================
    const numeros = document.querySelectorAll('[data-contagem]');
    if (numeros.length > 0 && 'IntersectionObserver' in window) {
        const contarObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animarContagem(entry.target);
                    contarObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        numeros.forEach(el => contarObserver.observe(el));
    }

    function animarContagem(el) {
        const alvo = parseInt(el.getAttribute('data-contagem'), 10);
        const sufixo = el.getAttribute('data-sufixo') || '';
        const duracao = 2000;
        const inicio = performance.now();
        function atualizar(agora) {
            const progresso = Math.min((agora - inicio) / duracao, 1);
            const ease = 1 - Math.pow(1 - progresso, 3);
            el.textContent = Math.floor(alvo * ease) + sufixo;
            if (progresso < 1) requestAnimationFrame(atualizar);
        }
        requestAnimationFrame(atualizar);
    }

    // =====================================================
    // 7. VALIDAÃ‡ÃƒO E SUBMISSÃƒO DO FORMULÃRIO
    // =====================================================
    const formulario = document.getElementById('form-contacto');
    if (formulario) {
        const campos = {
            nome: { el: document.getElementById('campo-nome'), obrigatorio: true, minLen: 2 },
            email: { el: document.getElementById('campo-email'), obrigatorio: true, tipo: 'email' },
            telefone: { el: document.getElementById('campo-telefone'), obrigatorio: false, pattern: /^[\d\s+\-()]{7,20}$/ },
            assunto: { el: document.getElementById('campo-assunto'), obrigatorio: false },
            mensagem: { el: document.getElementById('campo-mensagem'), obrigatorio: true, minLen: 10 }
        };

        const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        function validarCampo(nome, campo) {
            const valor = campo.el?.value.trim() || '';
            const erroEl = document.getElementById(`erro-${nome}`);
            let mensagemErro = '';

            if (campo.obrigatorio && !valor) {
                mensagemErro = 'Este campo Ã© obrigatÃ³rio.';
            } else if (valor && campo.minLen && valor.length < campo.minLen) {
                mensagemErro = `MÃ­nimo de ${campo.minLen} caracteres.`;
            } else if (campo.tipo === 'email' && valor && !regexEmail.test(valor)) {
                mensagemErro = 'Introduza um e-mail vÃ¡lido.';
            } else if (campo.pattern && valor && !campo.pattern.test(valor)) {
                mensagemErro = 'Formato invÃ¡lido.';
            }

            if (mensagemErro) {
                campo.el?.classList.add('erro');
                if (erroEl) { erroEl.textContent = mensagemErro; erroEl.classList.add('visivel'); }
                return false;
            } else {
                campo.el?.classList.remove('erro');
                if (erroEl) { erroEl.textContent = ''; erroEl.classList.remove('visivel'); }
                return true;
            }
        }

        formulario.addEventListener('submit', async (e) => {
            e.preventDefault();
            let valido = true;
            Object.entries(campos).forEach(([nome, campo]) => {
                if (!validarCampo(nome, campo)) valido = false;
            });
            if (!valido) return;

            const btnEnviar = document.getElementById('btn-enviar');
            const formMensagem = document.getElementById('form-mensagem');
            btnEnviar.disabled = true;
            btnEnviar.classList.add('loading');

            try {
                const formData = new FormData(formulario);
                const resposta = await fetch('processar_contacto.php', { method: 'POST', body: formData });
                const dados = await resposta.json();
                formMensagem.textContent = dados.mensagem;
                formMensagem.className = 'form-mensagem ' + (dados.sucesso ? 'sucesso' : 'erro');
                formMensagem.style.display = 'block';
                if (dados.sucesso) formulario.reset();
            } catch (erro) {
                formMensagem.textContent = 'Erro de ligaÃ§Ã£o.';
                formMensagem.className = 'form-mensagem erro';
                formMensagem.style.display = 'block';
            } finally {
                btnEnviar.disabled = false;
                btnEnviar.classList.remove('loading');
            }
        });
    }

    // =====================================================
    // 8. TOAST NOTIFICATIONS
    // =====================================================
    window.mostrarToast = function (mensagem, tipo = 'sucesso') {
        let container = document.getElementById('toast-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toast-container';
            document.body.appendChild(container);
        }

        const toast = document.createElement('div');
        toast.className = `toast ${tipo}`;

        const icone = tipo === 'sucesso'
            ? '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>'
            : '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>';

        toast.innerHTML = `
            <div class="toast-icone">${icone}</div>
            <div class="toast-texto">${mensagem}</div>
        `;

        container.appendChild(toast);
        setTimeout(() => toast.classList.add('ativo'), 10);
        setTimeout(() => {
            toast.classList.remove('ativo');
            setTimeout(() => toast.remove(), 500);
        }, 4000);
    };

    // =====================================================
    // 9. BOTÃ•ES MAGNÃ‰TICOS
    // =====================================================
    const botoesMagneticos = document.querySelectorAll('.btn-magnetico');
    botoesMagneticos.forEach(btn => {
        btn.addEventListener('mousemove', (e) => {
            const rect = btn.getBoundingClientRect();
            const x = e.clientX - rect.left - rect.width / 2;
            const y = e.clientY - rect.top - rect.height / 2;
            btn.style.transform = `translate(${x * 0.3}px, ${y * 0.5}px)`;
        });
        btn.addEventListener('mouseleave', () => {
            btn.style.transform = 'translate(0, 0)';
        });
    });

    // =====================================================
    // 10. SCROLL SUAVE PARA Ã‚NCORAS
    // =====================================================
    document.querySelectorAll('a[href*="#"]').forEach(link => {
        link.addEventListener('click', (e) => {
            const href = link.getAttribute('href');
            const parts = href.split('#');
            const isSamePage = parts[0] === '' || parts[0] === window.location.pathname.split('/').pop();

            if (isSamePage) {
                const alvo = document.getElementById(parts[1]);
                if (alvo) {
                    e.preventDefault();
                    alvo.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        });
    });

    // =====================================================
    // 11. ANO DINÃ‚MICO NO FOOTER
    // =====================================================
    const anoEl = document.getElementById('ano-atual');
    if (anoEl) anoEl.textContent = new Date().getFullYear();

});

// =====================================================
// 12. MODAIS (POP-UPS DE SERVIÃ‡OS)
// =====================================================
function abrirModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.classList.add('ativo');
        document.body.style.overflow = 'hidden';
    }
}

function fecharModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.classList.remove('ativo');
        document.body.style.overflow = '';
    }
}

function fecharModalFora(event, id) {
    if (event.target.id === id) {
        fecharModal(id);
    }
}

