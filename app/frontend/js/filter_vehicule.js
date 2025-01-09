document.getElementById("filterForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const formData = new FormData(this);

  const searchValue = formData.get("search");
  console.log(searchValue);

  fetch("filter_vehicules.php", {
    method: "POST", // Utilise POST
    body: formData, // Envoie les données du formulaire avec FormData
  })
    .then((response) => response.json()) // Récupère la réponse JSON
    .then((data) => {
      console.log(data); // Affiche la réponse du serveur
      const container = document.getElementById("vehiculesContainer");
      container.innerHTML = ""; // Vider le conteneur avant d'afficher de nouveaux résultats

      if (data.length === 0) {
        container.innerHTML = "<p>Aucun véhicule trouvé.</p>";
        return;
      }

      // Affichage des véhicules
      data.forEach((objet) => {
        const vehiculeCard = `
        <div class="bg-white rounded-lg shadow-lg p-4 max-w-sm">
           <div class="flex justify-between items-center">
            <div>
             <h2 class="text-lg font-bold">
             ${objet.nom} ${objet.marque}
             </h2>
             <p class="text-gray-500 ">
             ${objet.nom_categorie}
             </p>
              
            </div>
            <i class="fas fa-heart text-red-500 self-start">
            </i>
           </div>
        
           <img   src="${objet.photo}"  alt="" class="w-full h-48 object-cover rounded-lg my-4" height="300"  width="600"/>
             <div class="text-black font-bold">
             $${objet.prix}/d
            </div>
           <div class="flex justify-between items-center text-gray-500">
          
            <div class="flex items-center space-x-2">
            <input type="hidden" value="${objet.id_vehicule}">
            <form method="post" action="AvisOfVehicule.php">
              <button  name="AfficherAvis" value="${objet.id_vehicule}"  >
                        <i class="fas fa-user">${objet.totalAvis}</i>
                        
                        <i class="fas fa-comment text-xs"></i>  
              </button>     
            <form>
            </div>
            <div class="flex items-center ">
              <i class="fas fa-star text-yellow-500">
              </i>
              <i class="fas fa-star text-yellow-500">
              </i>
              <i class="fas fa-star text-yellow-500">
              </i>
              <i class="fas fa-star text-yellow-500">
              </i>
              <i class="fas fa-star-half-alt text-yellow-500">
              </i>
             </div>
            </div>
              <button class="mt-4 w-full bg-primary-500 hover:bg-primary-600 text-white py-2 opacity-50"
                 value="${objet.prix}"   onclick="openModal('modalReservation', ${objet.id_vehicule})">
                   Réserver
                 </button>
           </div>
          </div>
        
                      `;
        container.insertAdjacentHTML("beforeend", vehiculeCard); // Affichage dans le conteneur
      });
    })
    .catch((error) => {
      console.error("Erreur:", error);
    });
});
