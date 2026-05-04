<?php
$statut = $proposition['statut'] ?? 'en_attente';

$statutClass = match ($statut) {
    'adoptee', 'approuvee', 'realisee' => 'text-bg-success',
    'rejetee', 'refusee' => 'text-bg-danger',
    'en_vote' => 'text-bg-primary',
    default => 'text-bg-secondary',
};
?>

<main class="page-section">
    <div class="container">

        <div class="mb-4">
            <a href="routeur.php?page=propositions&id_groupe=<?= (int) $proposition['id_groupe'] ?>"
               class="btn btn-light rounded-pill px-4">
                <i class="bi bi-arrow-left me-2"></i>
                Retour aux propositions
            </a>
        </div>

        <div class="premium-card mb-4">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-3">
                <div>
                    <span class="badge <?= $statutClass ?> rounded-pill px-3 py-2">
                        <?= htmlspecialchars($statut) ?>
                    </span>

                    <h1 class="page-title mt-3 mb-2">
                        <?= htmlspecialchars($proposition['titre']) ?>
                    </h1>

                    <p class="text-muted mb-0">
                        Soumise le <?= htmlspecialchars($proposition['date_soumission']) ?>
                    </p>
                </div>

                <div class="text-end">
                    <small class="text-muted">Montant demandé</small>
                    <div class="fs-3 fw-bold text-primary">
                        <?= number_format((float) $proposition['montant_demande'], 2, ',', ' ') ?> €
                    </div>
                </div>
            </div>

            <p class="fs-5 text-muted">
                <?= nl2br(htmlspecialchars($proposition['description'])) ?>
            </p>

            <div class="d-flex flex-wrap gap-2 mt-4">
                <button class="btn btn-light rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#signalementPropositionModal">
                    <i class="bi bi-flag me-2"></i>
                    Signaler
                </button>
            </div>
        </div>

        <?php if (!empty($vote)): ?>
            <div class="premium-card mb-4">
                <h3 class="fw-bold mb-3">
                    <i class="bi bi-bar-chart text-primary me-2"></i>
                    Vote en cours
                </h3>

                <div class="row g-3 mb-4">
                    <?php foreach ($resultatsVote as $resultat): ?>
                        <div class="col-md-4">
                            <div class="card-soft p-3">
                                <small class="text-muted"><?= htmlspecialchars($resultat['choix']) ?></small>
                                <div class="fs-3 fw-bold"><?= (int) $resultat['total'] ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <form method="post" action="routeur.php?page=propositions&action=soumettreVote" class="d-flex flex-wrap gap-2">
                    <input type="hidden" name="id_vote" value="<?= (int) $vote['id_vote'] ?>">
                    <input type="hidden" name="id_proposition" value="<?= (int) $proposition['id_proposition'] ?>">

                    <button name="choix" value="pour" class="btn btn-primary rounded-pill px-4">
                        <i class="bi bi-hand-thumbs-up me-2"></i>
                        Pour
                    </button>

                    <button name="choix" value="contre" class="btn btn-light rounded-pill px-4">
                        <i class="bi bi-hand-thumbs-down me-2"></i>
                        Contre
                    </button>

                    <button name="choix" value="abstention" class="btn btn-light rounded-pill px-4">
                        Abstention
                    </button>
                </form>
            </div>
        <?php else: ?>
            <div class="premium-card mb-4">
                <h3 class="fw-bold mb-3">Créer un vote</h3>

                <form method="post" action="routeur.php?page=propositions&action=creerVote" class="row g-3">
                    <input type="hidden" name="id_proposition" value="<?= (int) $proposition['id_proposition'] ?>">

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Type de vote</label>
                        <select name="type_vote" class="form-select">
                            <option value="majoritaire">Majoritaire</option>
                            <option value="consultatif">Consultatif</option>
                            <option value="decisif">Décisif</option>
                            <option value="unanime">Unanime</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Date de fin</label>
                        <input type="datetime-local" name="date_fin" class="form-control" required>
                    </div>

                    <div class="col-12">
                        <button class="btn btn-primary rounded-pill px-4">
                            <i class="bi bi-plus-circle me-2"></i>
                            Lancer le vote
                        </button>
                    </div>
                </form>
            </div>
        <?php endif; ?>

        <div class="premium-card">
            <h3 class="fw-bold mb-4">
                <i class="bi bi-chat-left-text text-primary me-2"></i>
                Commentaires
            </h3>

            <form method="post" action="routeur.php?page=propositions&action=ajouterCommentaire" class="mb-4">
                <input type="hidden" name="id_proposition" value="<?= (int) $proposition['id_proposition'] ?>">

                <textarea name="texte" class="form-control mb-3" rows="3" placeholder="Écris ton avis..." required></textarea>

                <button class="btn btn-primary rounded-pill px-4">
                    <i class="bi bi-send me-2"></i>
                    Publier
                </button>
            </form>

            <?php if (empty($commentaires)): ?>
                <p class="text-muted mb-0">Aucun commentaire pour le moment.</p>
            <?php else: ?>
                <div class="d-flex flex-column gap-3">
                    <?php foreach ($commentaires as $commentaire): ?>
                        <div class="comment-card">
                            <div class="d-flex justify-content-between align-items-start gap-3">
                                <div>
                                    <strong>
                                        <?= htmlspecialchars($commentaire['prenom'] . ' ' . $commentaire['nom']) ?>
                                    </strong>
                                    <div class="text-muted small">
                                        @<?= htmlspecialchars($commentaire['login']) ?> ·
                                        <?= htmlspecialchars($commentaire['date_commentaire']) ?>
                                    </div>
                                </div>

                                <button class="btn btn-sm btn-light rounded-pill" data-bs-toggle="modal" data-bs-target="#signalementCommentaire<?= (int) $commentaire['id_commentaire'] ?>">
                                    <i class="bi bi-flag"></i>
                                </button>
                            </div>

                            <p class="mt-3 mb-3">
                                <?= $commentaire['est_supprime'] ? '<em class="text-muted">Commentaire supprimé</em>' : nl2br(htmlspecialchars($commentaire['texte'])) ?>
                            </p>

                            <div class="d-flex flex-wrap gap-2">
                                <?php foreach (['like' => '👍', 'love' => '❤️', 'haha' => '😂', 'sad' => '😢', 'dislike' => '👎'] as $type => $emoji): ?>
                                    <form method="post" action="routeur.php?page=propositions&action=ajouterReaction">
                                        <input type="hidden" name="id_commentaire" value="<?= (int) $commentaire['id_commentaire'] ?>">
                                        <input type="hidden" name="id_proposition" value="<?= (int) $proposition['id_proposition'] ?>">
                                        <input type="hidden" name="type_reaction" value="<?= $type ?>">
                                        <button class="btn btn-sm btn-light rounded-pill"><?= $emoji ?></button>
                                    </form>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="modal fade" id="signalementCommentaire<?= (int) $commentaire['id_commentaire'] ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <form method="post" action="routeur.php?page=signalements&action=signalerCommentaire" class="modal-content rounded-4 border-0">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Signaler ce commentaire</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <input type="hidden" name="id_commentaire" value="<?= (int) $commentaire['id_commentaire'] ?>">
                                        <input type="hidden" name="id_proposition" value="<?= (int) $proposition['id_proposition'] ?>">

                                        <label class="form-label fw-bold">Motif</label>
                                        <textarea name="motif" class="form-control" rows="3" required></textarea>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Annuler</button>
                                        <button class="btn btn-primary rounded-pill">Envoyer</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

    </div>
</main>

<div class="modal fade" id="signalementPropositionModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="post" action="routeur.php?page=signalements&action=signalerProposition" class="modal-content rounded-4 border-0">
            <div class="modal-header">
                <h5 class="modal-title">Signaler cette proposition</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" name="id_proposition" value="<?= (int) $proposition['id_proposition'] ?>">

                <label class="form-label fw-bold">Motif</label>
                <textarea name="motif" class="form-control" rows="3" required></textarea>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Annuler</button>
                <button class="btn btn-primary rounded-pill">Envoyer</button>
            </div>
        </form>
    </div>
</div>