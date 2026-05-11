<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf = $_SESSION['csrf_token'];
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <!-- Meta Tags Essenciais -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo isset($pageTitle) ? $pageTitle . " — Cláusula Sólida" : "Cláusula Sólida — Agência de Eventos e Publicidade"; ?></title>
    <meta name="description" content="A Cláusula Sólida é uma agência criativa especializada em organização de eventos, publicidade, marketing digital e ativação de marca.">
    <meta name="keywords" content="eventos, publicidade, agência criativa, marketing, organização de eventos, ativação de marca, design corporativo, marketing digital">
    <meta name="author" content="Cláusula Sólida">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://www.clausulasolida.pt<?php echo $_SERVER['PHP_SELF']; ?>">

    <!-- Open Graph -->
    <meta property="og:title" content="Cláusula Sólida — Agência de Eventos e Publicidade">
    <meta property="og:description" content="Soluções criativas e eventos memoráveis para a sua marca.">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="pt_PT">
    <meta property="og:site_name" content="Cláusula Sólida">

    <!-- Favicon SVG -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='8' fill='%2310b981'/><text x='50' y='68' font-size='55' font-weight='bold' fill='%230f172a' text-anchor='middle' font-family='serif'>CS</text></svg>" type="image/svg+xml">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@600;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Estilos -->
    <link rel="stylesheet" href="style.css?v=8.0">
    <script>
        // Aplicar tema imediatamente para evitar flash
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark-mode');
            document.addEventListener('DOMContentLoaded', () => document.body.classList.add('dark-mode'));
        }
    </script>
    <!-- Estrutura de Dados (JSON-LD) para Google -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "Cláusula Sólida",
      "url": "https://www.clausulasolida.pt",
      "logo": "https://www.clausulasolida.pt/assets/logo.png",
      "description": "Agência criativa especializada em eventos, publicidade e marketing digital.",
      "address": {
        "@type": "PostalAddress",
        "addressCountry": "Portugal"
      },
      "sameAs": [
        "https://facebook.com/clausulasolida",
        "https://instagram.com/clausulasolida",
        "https://linkedin.com/company/clausulasolida"
      ]
    }
    </script>
</head>
<body>
    <header class="cabecalho" id="cabecalho" role="banner">
        <div class="container">
            <a href="index.php" class="logo" aria-label="Cláusula Sólida — Página Inicial">
                <div class="logo-icon" aria-hidden="true">CS</div>
                <span>Cláusula Sólida</span>
            </a>

            <button class="menu-toggle" id="menu-toggle" aria-label="Abrir menu de navegação" aria-expanded="false" aria-controls="nav-lista">
                <span></span><span></span><span></span>
            </button>
            <div class="nav-overlay" id="nav-overlay"></div>

            <nav aria-label="Navegação principal">
                <ul class="nav-lista" id="nav-lista" role="menubar">
<?php
                    $currentPage = basename($_SERVER['PHP_SELF']);
                    $menuItems = [
                        'index.php' => 'Início',
                        'servicos.php' => 'Serviços',
                        'sobre.php' => 'Sobre Nós',
                        'portfolio.php' => 'Portfólio',
                        'contacto.php' => 'Contacto'
                    ];
                    foreach ($menuItems as $url => $label) {
                        $activeClass = ($currentPage == $url) ? ' class="active"' : '';
                        echo "<li role='none'><a href='$url' role='menuitem'$activeClass>$label</a></li>";
                    }
                    ?>
                </ul>
                <button id="theme-toggle" class="theme-toggle" aria-label="Alternar modo claro/escuro">
                    <svg class="moon-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                    <svg class="sun-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
                </button>
            </nav>
        </div>
    </header>


