

-- Migration pour créer la table client (adaptée à AppWoyofal)
CREATE TABLE IF NOT EXISTS client (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    adresse VARCHAR(200) NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    numerocompteur VARCHAR(50) UNIQUE NOT NULL,
    solde_principal NUMERIC(15,2) DEFAULT 0.0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX idx_client_numcompteur ON client(numerocompteur);

-- Table achat
CREATE TABLE IF NOT EXISTS achat (
    id SERIAL PRIMARY KEY,
    reference VARCHAR(100) NOT NULL,
    compteurnumero VARCHAR(50) NOT NULL,
    coderecharge VARCHAR(100) NOT NULL,
    nombrekwh NUMERIC(10,2) NOT NULL,
    montant NUMERIC(15,2) NOT NULL,
    tranche INT NOT NULL,
    prixkwh NUMERIC(10,2) NOT NULL,
    dateachat TIMESTAMP NOT NULL,
    statut VARCHAR(20) NOT NULL
);

-- Table journal
CREATE TABLE IF NOT EXISTS journal (
    id SERIAL PRIMARY KEY,
    dateheure TIMESTAMP NOT NULL,
    localisation VARCHAR(200),
    adresseIP VARCHAR(50),
    status VARCHAR(20) NOT NULL,
    numerocompteur VARCHAR(50) NOT NULL,
    coderecharge VARCHAR(100) NOT NULL,
    montantrecharge NUMERIC(15,2) NOT NULL,
    nombreKwt NUMERIC(10,2) NOT NULL
);

-- Index pour journal
CREATE INDEX idx_journal_numcompteur ON journal(numerocompteur);
