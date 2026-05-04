DELIMITER $$

CREATE TRIGGER verifier_montant_decision
BEFORE INSERT ON decision_budgetaire
FOR EACH ROW
BEGIN
    DECLARE montant_proposition DECIMAL(15,2);

    SELECT montant_demande
    INTO montant_proposition
    FROM proposition
    WHERE id_proposition = NEW.id_proposition;

    IF NEW.montant_alloue > montant_proposition THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Le montant alloué dépasse le montant demandé pour la proposition.';
    END IF;
END $$

CREATE TRIGGER notifier_signalement_commentaire
AFTER INSERT ON signalement
FOR EACH ROW
BEGIN
    DECLARE auteur_commentaire INT;
    DECLARE auteur_proposition INT;

    IF NEW.id_commentaire IS NOT NULL THEN
        SELECT id_utilisateur
        INTO auteur_commentaire
        FROM commentaire
        WHERE id_commentaire = NEW.id_commentaire;

        INSERT INTO notification (
            id_utilisateur,
            titre,
            message,
            type_notification
        )
        VALUES (
            auteur_commentaire,
            'Commentaire signalé',
            CONCAT('Votre commentaire a été signalé pour le motif suivant : ', NEW.motif),
            'signalement'
        );
    END IF;

    IF NEW.id_proposition IS NOT NULL THEN
        SELECT id_utilisateur
        INTO auteur_proposition
        FROM proposition
        WHERE id_proposition = NEW.id_proposition;

        INSERT INTO notification (
            id_utilisateur,
            titre,
            message,
            type_notification
        )
        VALUES (
            auteur_proposition,
            'Proposition signalée',
            CONCAT('Votre proposition a été signalée pour le motif suivant : ', NEW.motif),
            'signalement'
        );
    END IF;
END $$

CREATE TRIGGER mettre_a_jour_budget_apres_decision
AFTER INSERT ON decision_budgetaire
FOR EACH ROW
BEGIN
    DECLARE budget_proposition INT;

    SELECT id_budget
    INTO budget_proposition
    FROM proposition
    WHERE id_proposition = NEW.id_proposition;

    IF budget_proposition IS NOT NULL THEN
        UPDATE budget
        SET montant_utilise = montant_utilise + NEW.montant_alloue
        WHERE id_budget = budget_proposition;
    END IF;
END $$

DELIMITER ;