<?php

class Utilisateur {
    protected int $id_utilisateur;
    protected string $username;
    protected string $email;
    protected string $password;
    protected string $role;
    protected DateTime $createdAt;
    private static int $nextId = 1;

    public function __construct(string $username, string $email, string $password, string $role = 'visiteur') {
        $this->id_utilisateur = self::$nextId++;
        $this->username = $username;
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_DEFAULT); // RB-018
        $this->role = $role; // RB-001
        $this->createdAt = new DateTime(); // RB-022
    }

    public function login(string $email, string $password): bool {
        return ($this->email === $email && password_verify($password, $this->password));
    }

    public function getId() { return $this->id_utilisateur; }
    public function getUsername() { return $this->username; }
    public function getRole() { return $this->role; }
    public function getEmail() { return $this->email; }
}

class Author extends Utilisateur {
    private string $bio;

    public function __construct($username, $email, $password, $bio = "") {
        parent::__construct($username, $email, $password, 'author');
        $this->bio = $bio;
    }

    public function createArticle(string $title, string $content, array $categories): Article {
        return new Article($title, $content, $this, $categories); // RB-005, RB-006
    }
}

class Moderateur extends Utilisateur {
    // Le modérateur peut gérer les articles de tout le monde (RB-009)
    public function publishArticle(Article $article) {
        $article->setStatus('published'); // RB-011, RB-012
    }

    public function createCategory(string $name, ?Categorie $parent = null): Categorie {
        return new Categorie($name, $parent); // FR-C-01
    }
}

class Editeur extends Moderateur {
    private string $moderationLevel;

    public function __construct($username, $email, $password, $level = "senior") {
        parent::__construct($username, $email, $password);
        $this->role = 'editor';
        $this->moderationLevel = $level;
    }
}

class Admin extends Moderateur {
    public function __construct($username, $email, $password) {
        parent::__construct($username, $email, $password);
        $this->role = 'admin'; // RB-003
    }

    public function createUser(string $u, string $e, string $p, string $r): Utilisateur {
        return match($r) {
            'author' => new Author($u, $e, $p),
            'editor' => new Editeur($u, $e, $p),
            'admin'  => new Admin($u, $e, $p),
            default  => new Utilisateur($u, $e, $p, 'visitor'),
        };
    }
}

class Categorie {
    private int $id_categorie;
    private string $name;
    private ?Categorie $parent;
    private static int $nextId = 1;

    public function __construct(string $name, ?Categorie $parent = null) {
        $this->id_categorie = self::$nextId++;
        $this->name = $name;
        $this->parent = $parent; // RB-013
    }

    public function getId() { return $this->id_categorie; }
    public function getName() { return $this->name; }
}

// class Admin extends Moderateur {



// }


class Moderateur extends Utilisateur {
    public function approveComment(int $id_commentaire): bool { return false; }
    public function deleteComment(int $id_commentaire): bool { return false; }
}

class Admin extends Moderateur {
    protected int $isSuperA;

    public function getModerationLevel(): int { return $this->moderationLevel; }
    public function setModerationLevel(int $level): void { $this->moderationLevel = $level; }

    public function createUser(string $username, string $email): void { }
    public function deleteUser(int $id_utilisateur): bool { return false; }
}



class Editeur extends Moderateur {
    protected int $moderationLevel;


}

class Article {
    protected int $id_article;
    protected string $titre;
    protected string $content;
    protected string $status;

    public function getTitre(): string { return $this->titre; }
    public function setTitre(string $titre): void { $this->titre = $titre; }

    public function getStatus(): string { return $this->status; }
    public function setStatus(string $status): void { $this->status = $status; }
}



?>