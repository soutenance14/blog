var submitButton = document.getElementById('submitButton');
var successMessage = document.getElementById("submitSuccessMessage");
var progress_bar = document.getElementById("progress_bar");


progress_bar.style.display = 'none';

submitButton.addEventListener('click', event => {
    // contactForm.submit();
    var name = document.getElementById("name").value; 
    var mail = document.getElementById("email").value; 
    var message = document.getElementById("message").value; 
    var post = { "nom": name, "mail": mail, "contenu": message }; 
    // le fichier js de gestion du formulaire impose l'utilisation
    // du boutton submitSuccessMessage
    // il affiche le boutton après l'envoie du formulaire
    // ce bouton doit donc être caché à ce moment
    successMessage.style.display = 'none';
    progress_bar.style.display = 'block';
    // sendData(post);
    sendData(post);
  });

  function sendData(data) 
  {
    var XHR = new XMLHttpRequest();
    var urlEncodedData = "";
    var urlEncodedDataPairs = [];
    var name;
  
    // Transformez l'objet data en un tableau de paires clé/valeur codées URL.
    for(name in data) {
      urlEncodedDataPairs.push(encodeURIComponent(name) + '=' + encodeURIComponent(data[name]));
    }
  
    // Combinez les paires en une seule chaîne de caractères et remplacez tous
    // les espaces codés en % par le caractère'+' ; cela correspond au comportement
    // des soumissions de formulaires de navigateur.
    urlEncodedData = urlEncodedDataPairs.join('&').replace(/%20/g, '+');
  
    // Définissez ce qui se passe en cas de succès de soumission de données
    // XHR.addEventListener('load', function(event) {
    //   alert('Ouais ! Données envoyées et réponse chargée.');
    // });
  
    // Définissez ce qui arrive en cas d'erreur
    XHR.addEventListener('error', function(event) {
      alert('Oups! Une erreur s\' produite,  avec l\'object XMLHttpRequest permettant l\'interraction entre serveurs, le message n\' pas été envoyé.');
    });
  
    // Configurez la requête
    // XHR.open('POST', 'https://example.com/cors.php');
    XHR.open('POST', 'sendMessage');
    
    // Ajoutez l'en-tête HTTP requise pour requêtes POST de données de formulaire
    XHR.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  
    // Finalement, envoyez les données.
    // XHR.onreadystatechange = function() 
    XHR.onreadystatechange = function() 
    {//Call a function when the state changes.
        if(XHR.readyState == 4 && XHR.status == 200) {
            if(XHR.responseText == 'success')
            {
                progress_bar.style.display = 'none';
                successMessage.style.display = 'block';
            }
        }
        // else{
        //     alert('pas de reponse');
        // }
    }
    XHR.send(urlEncodedData);
  }

  //another method
  function sendData2(data)
  {
    data = {nom: "barium", mail: "barium", contenu: "barium" };
    fetch("http://blog/sendMessage", {
        method: "POST", 
        body: JSON.stringify(data)
      }).then(res => {
        console.log("Request complete! response:", res);
        alert( res.responseText);
      });
  }
