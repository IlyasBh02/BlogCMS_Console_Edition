<?php

<?php

class Utilisateur {
    protected int $id_utilisateur;
    protected string $username;
    protected string $email;
    protected string $password;
    protected string $role;

    public function getUsername(): string { return $this->username; }
    public function getEmail(): string { return $this->email; }

    public function setUsername(string $username): void { $this->username = $username; }
    public function setEmail(string $email): void { $this->email = $email; }
    public function setPassword(string $password): void { $this->password = $password; }

    public function login(string $email, string $password): bool { return false; }
    public function logout(): void { }
}



class Author extends Utilisateur {




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

class Categorie {
    protected int $id_categorie;
    protected string $name;

    public function getName(): string { return $this->name; }
    public function setName(string $name): void { $this->name = $name; }
}

?>