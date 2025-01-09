
   
    function submitOnEnter(event, form) {
        if (event.key === "Enter" ) {
            event.preventDefault();
            form.submit();
        }
    }
  // code pour les etoiles  : 
  //src : youtube https://www.youtube.com/watch?v=Djg-Fm-Pkgc
  //git  : https://github.com/NouvelleTechno/Stars-Rating/
  window.onload = () => {
    // On récupère tous les conteneurs de réservation
    const reservationContainers = document.querySelectorAll(".reservation");
    reservationContainers.forEach(container => {
        // On récupère les étoiles et l'input spécifique à ce conteneur
        const stars = container.querySelectorAll(".la-star");
        const note = container.querySelector("#note");


        let noteValue = parseInt(note.value);
        noteValue = isNaN(noteValue) ? 0 : noteValue  // si la val not number il faut donner 0 --si la reservtaion ne contient pas d etoile

        resetStars(stars, noteValue); 


        // On boucle sur les étoiles pour leur ajouter des écouteurs d'évènements
        stars.forEach(star => {
            // Écouteur pour le survol
            star.addEventListener("mouseover", function () {
                resetStars(stars, note.value);
                this.style.color = "gold";
                this.classList.add("las");
                this.classList.remove("lar");

                // Étoiles précédentes
                let previousStar = this.previousElementSibling;
                while (previousStar) {
                    previousStar.style.color = "gold";
                    previousStar.classList.add("las");
                    previousStar.classList.remove("lar");
                    previousStar = previousStar.previousElementSibling;
                }
            });

            // Écouteur pour le clic
            star.addEventListener("click", function () {
                note.value = this.dataset.value;
            });

            // Écouteur pour le retrait de la souris
            star.addEventListener("mouseout", function () {
                resetStars(stars, note.value);
            });
        });

        // Fonction pour réinitialiser les étoiles
        function resetStars(stars, note=0) {
            //alert(note) ; 
            stars.forEach(star => {
                if (star.dataset.value > note) {
                    star.style.color = "gray";
                    star.classList.add("lar");
                    star.classList.remove("las");
                } else {
                    star.style.color = "gold";
                    star.classList.add("las");
                    star.classList.remove("lar");
                }
            });
        }
    });
};
