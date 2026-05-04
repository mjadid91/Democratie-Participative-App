CREATE TABLE utilisateur (
    id_utilisateur INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) NOT NULL UNIQUE,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    adresse VARCHAR(255),
    ville VARCHAR(100),
    code_postal VARCHAR(20),
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    actif BOOLEAN DEFAULT TRUE
);

CREATE TABLE groupe (
    id_groupe INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    description TEXT,
    couleur VARCHAR(50),
    image VARCHAR(255),
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    id_createur INT NOT NULL,
    FOREIGN KEY (id_createur) REFERENCES utilisateur(id_utilisateur)
        ON DELETE CASCADE
);

CREATE TABLE role (
    id_role INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE role_dans_groupe (
    id_utilisateur INT NOT NULL,
    id_groupe INT NOT NULL,
    id_role INT NOT NULL,
    date_attribution DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id_utilisateur, id_groupe, id_role),
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur)
        ON DELETE CASCADE,
    FOREIGN KEY (id_groupe) REFERENCES groupe(id_groupe)
        ON DELETE CASCADE,
    FOREIGN KEY (id_role) REFERENCES role(id_role)
        ON DELETE CASCADE
);

CREATE TABLE budget (
    id_budget INT AUTO_INCREMENT PRIMARY KEY,
    id_groupe INT NOT NULL,
    nom VARCHAR(100) NOT NULL,
    montant_total DECIMAL(15,2) NOT NULL,
    montant_utilise DECIMAL(15,2) DEFAULT 0,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_groupe) REFERENCES groupe(id_groupe)
        ON DELETE CASCADE,
    CHECK (montant_total >= 0),
    CHECK (montant_utilise >= 0)
);

CREATE TABLE proposition (
    id_proposition INT AUTO_INCREMENT PRIMARY KEY,
    id_groupe INT NOT NULL,
    id_utilisateur INT NOT NULL,
    id_budget INT NULL,
    titre VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    montant_demande DECIMAL(15,2) DEFAULT 0,
    statut ENUM('en_attente', 'approuvee', 'rejetee', 'en_vote', 'adoptee', 'refusee', 'realisee') DEFAULT 'en_attente',
    date_soumission DATETIME DEFAULT CURRENT_TIMESTAMP,
    date_fin DATE NULL,
    FOREIGN KEY (id_groupe) REFERENCES groupe(id_groupe)
        ON DELETE CASCADE,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur)
        ON DELETE CASCADE,
    FOREIGN KEY (id_budget) REFERENCES budget(id_budget)
        ON DELETE SET NULL,
    CHECK (montant_demande >= 0)
);

CREATE TABLE commentaire (
    id_commentaire INT AUTO_INCREMENT PRIMARY KEY,
    id_proposition INT NOT NULL,
    id_utilisateur INT NOT NULL,
    texte TEXT NOT NULL,
    date_commentaire DATETIME DEFAULT CURRENT_TIMESTAMP,
    est_supprime BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (id_proposition) REFERENCES proposition(id_proposition)
        ON DELETE CASCADE,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur)
        ON DELETE CASCADE
);

CREATE TABLE reaction_commentaire (
    id_commentaire INT NOT NULL,
    id_utilisateur INT NOT NULL,
    type_reaction ENUM('like', 'dislike', 'love', 'haha', 'sad') NOT NULL,
    date_reaction DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id_commentaire, id_utilisateur),
    FOREIGN KEY (id_commentaire) REFERENCES commentaire(id_commentaire)
        ON DELETE CASCADE,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur)
        ON DELETE CASCADE
);

CREATE TABLE vote (
    id_vote INT AUTO_INCREMENT PRIMARY KEY,
    id_proposition INT NOT NULL,
    type_vote ENUM('majoritaire', 'consultatif', 'decisif', 'unanime') DEFAULT 'majoritaire',
    date_debut DATETIME NOT NULL,
    date_fin DATETIME NOT NULL,
    statut ENUM('ouvert', 'termine', 'annule') DEFAULT 'ouvert',
    resultat ENUM('pour', 'contre', 'egalite', 'en_cours') DEFAULT 'en_cours',
    FOREIGN KEY (id_proposition) REFERENCES proposition(id_proposition)
        ON DELETE CASCADE
);

CREATE TABLE vote_utilisateur (
    id_vote INT NOT NULL,
    id_utilisateur INT NOT NULL,
    choix ENUM('pour', 'contre', 'abstention') NOT NULL,
    date_vote DATETIME DEFAULT CURRENT_TIMESTAMP,
    est_valide BOOLEAN DEFAULT TRUE,
    id_scrutateur INT NULL,
    PRIMARY KEY (id_vote, id_utilisateur),
    FOREIGN KEY (id_vote) REFERENCES vote(id_vote)
        ON DELETE CASCADE,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur)
        ON DELETE CASCADE,
    FOREIGN KEY (id_scrutateur) REFERENCES utilisateur(id_utilisateur)
        ON DELETE SET NULL
);

CREATE TABLE decision_budgetaire (
    id_decision INT AUTO_INCREMENT PRIMARY KEY,
    id_proposition INT NOT NULL,
    id_utilisateur INT NOT NULL,
    montant_alloue DECIMAL(15,2) NOT NULL,
    commentaire TEXT,
    date_decision DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_proposition) REFERENCES proposition(id_proposition)
        ON DELETE CASCADE,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur)
        ON DELETE CASCADE,
    CHECK (montant_alloue >= 0)
);

CREATE TABLE signalement (
    id_signalement INT AUTO_INCREMENT PRIMARY KEY,
    id_signaleur INT NOT NULL,
    id_commentaire INT NULL,
    id_proposition INT NULL,
    motif VARCHAR(255) NOT NULL,
    statut ENUM('en_attente', 'traite', 'rejete') DEFAULT 'en_attente',
    date_signalement DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_signaleur) REFERENCES utilisateur(id_utilisateur)
        ON DELETE CASCADE,
    FOREIGN KEY (id_commentaire) REFERENCES commentaire(id_commentaire)
        ON DELETE CASCADE,
    FOREIGN KEY (id_proposition) REFERENCES proposition(id_proposition)
        ON DELETE CASCADE,
    CHECK (
        (id_commentaire IS NOT NULL AND id_proposition IS NULL)
        OR
        (id_commentaire IS NULL AND id_proposition IS NOT NULL)
    )
);

CREATE TABLE notification (
    id_notification INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT NOT NULL,
    titre VARCHAR(150) NOT NULL,
    message TEXT NOT NULL,
    type_notification ENUM('info', 'signalement', 'invitation', 'vote', 'proposition', 'decision') DEFAULT 'info',
    est_lue BOOLEAN DEFAULT FALSE,
    date_notification DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur)
        ON DELETE CASCADE
);

CREATE TABLE invitation (
    id_invitation INT AUTO_INCREMENT PRIMARY KEY,
    id_groupe INT NOT NULL,
    id_inviteur INT NOT NULL,
    email_invite VARCHAR(150) NOT NULL,
    statut ENUM('en_attente', 'acceptee', 'refusee', 'expiree') DEFAULT 'en_attente',
    date_invitation DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_groupe) REFERENCES groupe(id_groupe)
        ON DELETE CASCADE,
    FOREIGN KEY (id_inviteur) REFERENCES utilisateur(id_utilisateur)
        ON DELETE CASCADE
);