import os

directory = r'c:\Users\Diana\Desktop\clausula solida'
button_html = '\n                    <button class="fechar-menu-mobile" id="fechar-menu-mobile" aria-label="Fechar menu">&times;</button>'

for root, dirs, files in os.walk(directory):
    for file in files:
        if file.endswith('.html') or file.endswith('.php'):
            path = os.path.join(root, file)
            try:
                with open(path, 'r', encoding='utf-8') as f:
                    content = f.read()
                
                if 'fechar-menu-mobile' not in content and '<ul class="nav-lista" id="nav-lista">' in content:
                    content = content.replace('<ul class="nav-lista" id="nav-lista">', '<ul class="nav-lista" id="nav-lista">' + button_html)
                    # Bump cache version while we're at it to force the phone to reload!
                    content = content.replace('style.css?v=8.0', 'style.css?v=9.0')
                    content = content.replace('script.js?v=8.0', 'script.js?v=9.0')
                    with open(path, 'w', encoding='utf-8', newline='\n') as f:
                        f.write(content)
                    print(f'Added to {path}')
            except Exception as e:
                pass
