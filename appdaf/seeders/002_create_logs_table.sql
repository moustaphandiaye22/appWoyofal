-
-- Seeders pour AppWoyofal
-- Insertion de clients de test
INSERT INTO client (nom, prenom, adresse, telephone, numerocompteur, solde_principal)
VALUES
    ('DIOP', 'Awa', 'Dakar Plateau', '771234567', 'COMP12345', 10000.00),
    ('NDAO', 'Moussa', 'Parcelles Assainies', '781234567', 'COMP67890', 5000.00);

-- Insertion d'achats de test
INSERT INTO achat (reference, compteurnumero, coderecharge, nombrekwh, montant, tranche, prixkwh, dateachat, statut)
VALUES
    ('REF-TEST1', 'COMP12345', '123456789012', 20.0, 1000.00, 1, 50.00, NOW(), 'success'),
    ('REF-TEST2', 'COMP67890', '987654321098', 40.0, 3000.00, 2, 75.00, NOW(), 'success');

-- Insertion de journaux de test
INSERT INTO journal (dateheure, localisation, adresseIP, status, numerocompteur, coderecharge, montantrecharge, nombreKwt)
VALUES
    (NOW(), 'Dakar', '192.168.1.1', 'success', 'COMP12345', '123456789012', 1000.00, 20.0),
    (NOW(), 'Dakar', '192.168.1.2', 'success', 'COMP67890', '987654321098', 3000.00, 40.0);