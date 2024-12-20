<!-- Biblioteca de Cookie Consent -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.css" />
<script src="https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.js"></script>
<script>
    window.addEventListener('load', function() {
        window.cookieconsent.initialise({
            "palette": {
                "popup": { "background": "#1A224B", "text": "#fff" },
                "button": { "background": "#f1d600", "text": "#000" }
            },
            "theme": "classic",
            "position": "bottom",
            "type": "opt-in",
            "content": {
                "message": "Usamos cookies para asegurar que obtengas la mejor experiencia.",
                "dismiss": "Aceptar todas",
                "deny": "Rechazar",
                "link": "Saber más",
                "href": "../controlador/cookies.php" 
            }
        });
    });
</script>