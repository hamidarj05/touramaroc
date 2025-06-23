
function getCookie(name) {
  const cname = name + "=";
  const decoded = decodeURIComponent(document.cookie);
  const cookies = decoded.split(';');
  for (let i = 0; i < cookies.length; i++) {
    let c = cookies[i].trim();
    if (c.indexOf(cname) === 0) {
      return c.substring(cname.length, c.length);
    }
  }
  return null;
}

function AfficherInput() {
  const codeStocke = getCookie('Code'); // Utiliser notre fonction custom

  if (codeStocke) {
    AfficherDelai();

    const input = document.getElementById('verificationCode');

    input.addEventListener('input', () => {
      const inputCode = input.value.trim();

      if (inputCode.length === 4 && inputCode === codeStocke) {
        alert('Code valide !');
        window.location.href = 'php/insertInDB.php'; 
      }
    });
  } else {
    console.log("Le cookie 'Code' n'est pas trouvé.");
  }
}

// Appelle la fonction après chargement du DOM
document.addEventListener('DOMContentLoaded', AfficherInput);




function AfficherDelai() {
  for (let i = 60; i >= 0; i--) {
    setTimeout(() => {
      document.getElementById('delai').textContent = "Entrez votre code après : " + i + " secondes";
      if (i == 0){
        document.getElementById('delai').textContent = "Temps écoulé, veuillez renvoyer le code.";
        // window.location.reload();
      }
    }, (60 - i) * 1000);
  }


}


