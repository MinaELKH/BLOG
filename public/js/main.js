


  function openModal(modalId) {
    document.getElementById(modalId).classList.remove('hidden');
  }
  
  function openModal(modalId , id) {
   // alert(id) ;
    document.getElementById(modalId).classList.remove('hidden');
    document.getElementById("id_ref").value = id ; 
  }

  function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
        // lors de fermture de  modal  s il y a des param dans l url on doit revenir a l url sans param
    const baseUrl = window.location.origin + window.location.pathname;
    //             // renvoie http://localhost    +   /chefCuisine/home.php : fichier actuelle  
    window.history.replaceState(null, null, baseUrl);
    // cette methode permet de remplacer l url sans rechareg la page
  }
  if(document.body.id == "pageHome" || document.body.id == "pageLayout"){
    //alert("helo")
      const menuToggle = document.getElementById('menuToggle');
      const dropdownMenu = document.getElementById('dropdownMenu');
      menuToggle.addEventListener('click', (event) => {
      event.preventDefault(); // 
      dropdownMenu.classList.toggle('hidden'); 
    });
  
  
    document.addEventListener('click', (event) => {
      if (!menuToggle.contains(event.target) && !dropdownMenu.contains(event.target)) {
        dropdownMenu.classList.add('hidden'); 
      }
    });
  }
//ajouter un commentaire en cliquant sur touche entrer
  function submitOnEnter(event, form) {
    if (event.key === "Enter") {
      event.preventDefault(); 
      form.submit();
    }
  }


