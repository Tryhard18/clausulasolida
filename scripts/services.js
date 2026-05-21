const serviceData = {
    'outdoors': {
        icon: 'fas fa-ad',
        title: 'Outdoors',
        desc: 'Publicidade de grande formato localizada em vias de grande circulação, garantindo visibilidade massiva e impacto constante.',
        features: [
            'Formatos 4x3m, 8x3m e Especiais',
            'Iluminação para visibilidade 24h',
            'Redes nacionais e locais para cobertura estratégica'
        ]
    },
    'mupis': {
        icon: 'fas fa-tv',
        title: 'Mupis',
        desc: 'Painéis de publicidade urbana instalados em locais estratégicos como paragens de autocarro, centros comerciais e zonas pedonais.',
        features: [
            'Mupis Retro-iluminados de alta definição',
            'Suportes Digitais Interactivos',
            'Excelente proximidade com o consumidor final'
        ]
    },
    'empenas': {
        icon: 'fas fa-building',
        title: 'Empenas',
        desc: 'Publicidade em fachadas cegas de edifícios, oferecendo uma área de exposição gigante e destaque na paisagem urbana.',
        features: [
            'Lonas de grande dimensão e alta resistência',
            'Localizações premium em centros urbanos movimentados',
            'Elevado impacto visual e taxa de recordação'
        ]
    },
    'sinaletica': {
        icon: 'fas fa-map-signs',
        title: 'Sinaléticas',
        desc: 'Soluções de orientação e identificação que reforçam a presença da marca em espaços físicos de forma funcional.',
        features: [
            'Placas de sinalização e diretórios personalizados',
            'Totems informativos e direccionais',
            'Materiais resistentes e acabamentos premium duradouros'
        ]
    },
    'monopostes': {
        icon: 'fas fa-broadcast-tower',
        title: 'Monopostes',
        desc: 'Estruturas de publicidade de grande altura para visibilidade a longa distância em autoestradas e acessos urbanos.',
        features: [
            'Visibilidade a quilómetros de distância',
            'Ideal para grandes marcas e reconhecimento corporativo',
            'Estruturas robustas, seguras e de fácil manutenção'
        ]
    },
    'publicidade-exterior': {
        icon: 'fas fa-ad',
        title: 'Publicidade Exterior',
        desc: 'Damos visibilidade à sua marca nos locais de maior circulação com suportes de alto impacto e qualidade profissional.',
        features: [
            'Gestão completa de Outdoors e Mupis',
            'Localizações estratégicas em todo o país',
            'Monitorização e manutenção constante das campanhas'
        ]
    }
};

function openDetailsModal(id) {
    const data = serviceData[id];
    if (!data) return;

    const content = `
        <div class="why-icon"><i class="${data.icon}"></i></div>
        <h2>${data.title}</h2>
        <p>${data.desc}</p>
        <ul>
            ${data.features.map(f => `<li><i class="fas fa-check-circle"></i> ${f}</li>`).join('')}
        </ul>
    `;

    document.getElementById('modal-content').innerHTML = content;
    const modal = document.getElementById('details-modal');
    modal.style.display = 'flex';
    setTimeout(() => modal.classList.add('active'), 10);
    document.body.style.overflow = 'hidden';
}

function closeDetailsModal() {
    const modal = document.getElementById('details-modal');
    modal.classList.remove('active');
    setTimeout(() => {
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }, 400);
}

// Close on escape
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeDetailsModal();
});

function toggleHomePublicidade(btn) {
    const details = document.getElementById('publicidade-details');
    details.classList.toggle('active');
    btn.classList.toggle('active');
    
    if (details.classList.contains('active')) {
        btn.textContent = 'Ver Menos';
        details.scrollIntoView({ behavior: 'smooth', block: 'start' });
    } else {
        btn.textContent = 'Saiba Mais';
    }
}

function toggleDetails(btn) {
    const content = btn.nextElementSibling;
    content.classList.toggle('active');
    btn.classList.toggle('active');
    
    if (content.classList.contains('active')) {
        btn.innerHTML = 'Ver Menos <i class="fas fa-chevron-up"></i>';
    } else {
        btn.innerHTML = 'Saiba Mais <i class="fas fa-chevron-down"></i>';
    }
}
