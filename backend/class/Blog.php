<?php
class Blog
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }


    // Créer un nouvel article

    public function creerArticle($auteur, $titre, $contenu, $image)
    {
        $sql = "INSERT INTO articles (auteur, titre, contenu, date_blog, image) 
                VALUES (:auteur, :titre, :contenu, NOW(), :image)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':auteur' => $auteur,
            ':titre' => $titre,
            ':contenu' => $contenu,
            ':image' => $image
        ]);
    }

    // Récupérer tous les articles (pour l'admin)
    
    public function obtenirTousArticles()
    {
        $sql = "SELECT * FROM articles ORDER BY date_blog DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les articles paginés (pour le frontend)
    public function obtenirArticlesPaginés($offset, $limit)
    {
        $sql = "SELECT * FROM articles ORDER BY date_blog DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    // Récupérer un article par son ID
    
    public function obtenirArticleParId($id)
    {
        $sql = "SELECT * FROM articles WHERE blog_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    //   Mettre à jour un article
   
    public function mettreAJourArticle($id, $auteur, $titre, $contenu, $image)
    {
        $sql = "UPDATE articles SET 
                auteur = :auteur, 
                titre = :titre, 
                contenu = :contenu, 
                image = :image 
                WHERE blog_id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':auteur' => $auteur,
            ':titre' => $titre,
            ':contenu' => $contenu,
            ':image' => $image
        ]);
    }

    
    // Supprimer un article
    
    public function supprimerArticle($id)
    {
        $sql = "DELETE FROM articles WHERE blog_id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    
    // Récupérer le nombre total d'articles
    
    public function obtenirTotalArticles()
    {
        return $this->conn->query("SELECT COUNT(*) FROM articles")->fetchColumn();
    }

    
    // Récupérer les articles populaires
    
    public function obtenirArticlesPopulaires($limit = 3)
    {
        $sql = "SELECT * FROM articles ORDER BY vues DESC LIMIT :limit";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    // Récupérer les articles par catégorie
    
    public function obtenirArticlesParCategorie($categorie_id, $limit = 5)
    {
        $sql = "SELECT * FROM articles 
                WHERE category_id = :categorie_id 
                ORDER BY date_blog DESC 
                LIMIT :limit";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':categorie_id', $categorie_id, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Incrémenter le compteur de vues
    
    public function incrementerVues($id)
    {
        $sql = "UPDATE articles SET vues = vues + 1 WHERE blog_id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
?>