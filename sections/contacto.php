<!-- CONTACTO -->
<section class="contacto" id="contacto" style="padding: 10rem 0; background: var(--cor-fundo-secao);">
    <div class="container">
        <div class="contacto-grid" style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 5rem; align-items: start;">
            <div class="contacto-info animar">
                <h2 style="font-size: clamp(2.5rem, 5vw, 3.5rem); margin-bottom: 2rem;">Vamos Criar Algo <span class="texto-gradiente">Memorável</span>?</h2>
                <p style="font-size: 1.2rem; color: var(--cor-texto-muted); margin-bottom: 3rem;">
                    Seja um evento corporativo, uma ativação de marca ou uma campanha digital disruptiva, a nossa equipa está pronta para elevar a sua visão.
                </p>
                
                <div class="contacto-detalhes">
                    <div class="contacto-item" style="display: flex; align-items: center; gap: 1.5rem; margin-bottom: 2rem;">
                        <div class="icone-glow" style="flex-shrink: 0;"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg></div>
                        <div>
                            <span style="display: block; font-size: 0.85rem; color: var(--cor-texto-muted); text-transform: uppercase;">Telefone</span>
                            <strong style="font-size: 1.1rem;">+351 210 123 456</strong>
                        </div>
                    </div>
                    <div class="contacto-item" style="display: flex; align-items: center; gap: 1.5rem; margin-bottom: 2rem;">
                        <div class="icone-glow" style="flex-shrink: 0;"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg></div>
                        <div>
                            <span style="display: block; font-size: 0.85rem; color: var(--cor-texto-muted); text-transform: uppercase;">E-mail</span>
                            <strong style="font-size: 1.1rem;">geral@clausulasolida.pt</strong>
                        </div>
                    </div>
                    <div class="contacto-item" style="display: flex; align-items: center; gap: 1.5rem;">
                        <div class="icone-glow" style="flex-shrink: 0;"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg></div>
                        <div>
                            <span style="display: block; font-size: 0.85rem; color: var(--cor-texto-muted); text-transform: uppercase;">Localização</span>
                            <strong style="font-size: 1.1rem;">Av. da Liberdade, 110, Lisboa</strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="animar">
                <form id="form-contacto" class="formulario-premium" action="processar_contacto.php" method="POST" style="background: var(--cor-fundo-claro); padding: 3.5rem; border-radius: 32px; border: 1px solid var(--cor-borda); box-shadow: 0 40px 100px rgba(0,0,0,0.1);">
                    <input type="hidden" name="csrf_token" value="<?php echo $csrf ?? ''; ?>">
                    <div class="campo-grupo" style="margin-bottom: 2rem;">
                        <label for="campo-nome" style="display: block; margin-bottom: 0.75rem; font-weight: 600;">Nome Completo</label>
                        <input type="text" id="campo-nome" name="nome" placeholder="Como o podemos tratar?" required style="width: 100%; padding: 1.25rem; border-radius: 12px; border: 1px solid var(--cor-borda); background: var(--cor-fundo-secao); color: var(--cor-texto);">
                    </div>
                    <div class="campo-grupo" style="margin-bottom: 2rem;">
                        <label for="campo-email" style="display: block; margin-bottom: 0.75rem; font-weight: 600;">E-mail Profissional</label>
                        <input type="email" id="campo-email" name="email" placeholder="seu@email.com" required style="width: 100%; padding: 1.25rem; border-radius: 12px; border: 1px solid var(--cor-borda); background: var(--cor-fundo-secao); color: var(--cor-texto);">
                    </div>
                    <div class="campo-grupo" style="margin-bottom: 2rem;">
                        <label for="campo-assunto" style="display: block; margin-bottom: 0.75rem; font-weight: 600;">Interesse principal</label>
                        <select id="campo-assunto" name="assunto" style="width: 100%; padding: 1.25rem; border-radius: 12px; border: 1px solid var(--cor-borda); background: var(--cor-fundo-secao); color: var(--cor-texto); cursor: pointer;">
                            <option value="eventos">Organização de Eventos</option>
                            <option value="publicidade">Campanhas Publicitárias</option>
                            <option value="digital">Marketing Digital</option>
                            <option value="outro">Outro Assunto</option>
                        </select>
                    </div>
                    <div class="campo-grupo" style="margin-bottom: 2.5rem;">
                        <label for="campo-mensagem" style="display: block; margin-bottom: 0.75rem; font-weight: 600;">O seu desafio</label>
                        <textarea id="campo-mensagem" name="mensagem" rows="5" placeholder="Conte-nos um pouco sobre o que pretende alcançar..." required style="width: 100%; padding: 1.25rem; border-radius: 12px; border: 1px solid var(--cor-borda); background: var(--cor-fundo-secao); color: var(--cor-texto); resize: none;"></textarea>
                    </div>
                    <button type="submit" id="btn-enviar" class="btn btn-primario glow-effect btn-magnetico" style="width: 100%; padding: 1.5rem; font-size: 1.1rem;">
                        Enviar Mensagem
                    </button>
                    <div id="form-mensagem" class="form-mensagem" style="display: none; margin-top: 1.5rem; padding: 1rem; border-radius: 8px; text-align: center;"></div>
                </form>
            </div>
        </div>
    </div>
</section>


