/**
 * footer-loader.js
 * Dynamically loads the shared footer and adjusts paths based on page depth.
 */
document.addEventListener("DOMContentLoaded", function() {
    const footerPlaceholder = document.getElementById('footer-placeholder');
    if (!footerPlaceholder) return;

    // Determine path depth (check if we are in a subfolder like /servicos/)
    const path = window.location.pathname;
    const isSubPage = path.includes('/servicos/') || (path.split('/').length > (path.endsWith('/') ? 2 : 2) && !path.endsWith('index.html') && path.includes('\\'));
    
    // Better way to check depth for local files and servers
    const segments = path.split(/[\\\/]/).filter(s => s.length > 0);
    // If the file is in a subfolder, we need to go up
    // Simplified check: if the URL contains "servicos/", it's a subpage
    const needsPathCorrection = path.toLowerCase().includes('servicos');
    const prefix = needsPathCorrection ? '../' : '';

    fetch(prefix + 'footer.html')
        .then(response => response.text())
        .then(data => {
            // Adjust paths in the footer content if necessary
            let footerHtml = data;
            
            if (needsPathCorrection) {
                // Prepend ../ to links that don't already have it and aren't external
                // This regex finds href="index.html", href="sobre.html", etc.
                footerHtml = footerHtml.replace(/href="(?!http|mailto|tel|#)([^"]+)"/g, (match, p1) => {
                    // If the link already starts with ../, don't add another
                    if (p1.startsWith('../')) return match;
                    // If it's a link to a service inside the same folder, don't go up
                    if (p1.startsWith('servicos/')) return `href="${p1.replace('servicos/', '')}"`;
                    return `href="../${p1}"`;
                });

                // Correct image paths
                footerHtml = footerHtml.replace(/src="([^"]+)"/g, (match, p1) => {
                    if (p1.startsWith('http') || p1.startsWith('../')) return match;
                    return `src="../${p1}"`;
                });
            }

            footerPlaceholder.innerHTML = footerHtml;

            // Re-trigger reveal animations if they exist in the main script
            if (window.RevealInit) {
                window.RevealInit();
            } else {
                // Fallback reveal logic if the main script isn't exposed
                const observerOptions = { threshold: 0.1 };
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('visible');
                        }
                    });
                }, observerOptions);
                
                footerPlaceholder.querySelectorAll('.reveal').forEach(el => observer.observe(el));
            }
        })
        .catch(err => console.error('Error loading footer:', err));
});
