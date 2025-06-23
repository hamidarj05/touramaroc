<?php 

class User{

    public $nom ;
    public $prenom ;
    public $telephone ;
    public $pays ;
    public $ville ;
    public $adresse ;
    public $email ;
    public $password ;
    public $confirmPassword ;
    // public $dateActuiel ;
    // public $date_creation ;

    public function __construct($nom , $prenom , $telephone , $pays  ,  $ville , $adresse , $email , $password , $confirmPassword){
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->telephone = $telephone;
        $this->pays = $pays;
        $this->ville = $ville;
        $this->adresse = $adresse;
        $this->email = $email;
        $this->password = $password;
        $this->confirmPassword = $confirmPassword;
    }

    public function valideNom(){
        if (empty($this->nom) || strlen($this->nom) < 2 || strlen($this->nom) > 20) {
            return "Le nom doit contenir entre 2 et 20 caractères" ;
        }
        return true ;
    }
    public function validePrenom(){
        if (empty($this->prenom) || strlen($this->prenom) < 2 || strlen($this->prenom) > 20) {
            return "Le prenom doit contenir entre 2 et 20 caractères" ;
        }
        return true ;
    }
    
    public function valideTelephone(){
        if (empty($this->telephone) || !preg_match('/^\d{10,20}$/', $this->telephone)) {
            return "Le numéro de téléphone doit contenir 10 chiffres" ;
        }
        return true ;
    }
    public function validePays(){
        if (empty($this->pays)) {
            return "Le pays doit être renseigné" ;
        }
        return true ;
    }
    public function valideVille(){
        if (empty($this->ville)) {
            return "La ville doit être renseignée" ;
        }
        return true ;
    }

    public function valideAdresse(){
        if (empty($this->adresse)) {
            return "L'adresse doit être renseignée" ;
        }
        return true ;
    }
    public function valideEmail() {
        if (empty($this->email) || !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return "L'email doit être valide";
        }
        return true;
    }

    public function validePassword(){
        if (empty($this->password) || strlen($this->password) < 6 || strlen($this->password) > 20) {
            return "Le mot de passe doit contenir entre 6 et 20 caractères" ;
        }
        return true ;
    }
    public function valideConfirmPassword(){
        if ($this->password !== $this->confirmPassword) {
            return "Les mots de passe ne correspondent pas" ;
        }
        return true ;
    }

    public function validateInfo(){
        $errors = [];
        $errors[] = $this->valideNom();
        $errors[] = $this->validePrenom();
        $errors[] = $this->valideTelephone();
        $errors[] = $this->validePays();
        $errors[] = $this->valideVille();
        $errors[] = $this->valideAdresse();
        // $errors[] = $this->valideEmail();
        // $errors[] = $this->validePassword();
        // $errors[] = $this->valideConfirmPassword();

        // Filter out the true values
    // Garde uniquement les messages d'erreur
        $filtered = array_filter($errors, fn($e) => $e !== true);

        if (empty($filtered)) {
            return "valide";
        } else {
            return implode("\n", $filtered);
        }
    }

    // public function valideEmailAndPassword(){
    //     $errors = [];
    //     $errors[] = $this->valideEmail();
    //     $errors[] = $this->validePassword();
    //     $errors[] = $this->valideConfirmPassword();

    //     // Filter out the true values
    //     return array_filter($errors, function($error) {
    //         return $error !== true;
    //     });

    //     $message = $errors ? implode("\n", $errors) : "valide";
    //     return $message;
    // }


    public function valideEmailAndPassword() {
    $errors = [];
    $errors[] = $this->valideEmail();
    $errors[] = $this->validePassword();
    $errors[] = $this->valideConfirmPassword();

    // Garde uniquement les messages d'erreur
    $filtered = array_filter($errors, fn($e) => $e !== true);

    if (empty($filtered)) {
        return "valide";
    } else {
        return implode("\n", $filtered);
    }
}
}

$p = new User("nom", "prenom", "0123456789", "maroc", "tangier", "beni makkada", 'mohamedsmd@gmail.com', "password123", "password123");



// echo $p->validateInfo();


        if ($p->valideEmail() !== true ) {
            echo $p->valideEmail();
        }

?>