# AppWoyofal - Système de Prépaiement Électricité SENELEC

## 📝 Description
AppWoyofal simule le système de prépaiement d'électricité de la SENELEC avec un système de tranches progressives.

## 🏗️ Architecture
- **Langage** : PHP 8.2 Orienté Objet
- **Base de données** : PostgreSQL
- **Serveur web** : Nginx
- **Containerisation** : Docker

## 🚀 Démarrage rapide

```bash
# Cloner et démarrer
git clone <repository>
cd AppWoyofall
docker compose up -d

# Vérifier l'API
curl http://localhost:8082/health
```

## 📡 Endpoints API

| Endpoint | Méthode | Description |
|----------|---------|-------------|
| `POST /achat` | POST | Acheter crédit Woyofal |
| `GET /client/{compteur}` | GET | Rechercher client |
| `POST /clients` | POST | Créer client |
| `GET /journal` | GET | Historique transactions |

## 💳 Exemple d'achat

```bash
curl -X POST http://localhost:8082/achat \
  -H "Content-Type: application/json" \
  -d '{"numerocompteur":"COMP12345","montant":1000}'
```

## 📊 Système de tranches

- **Tranche 1** : 0-150 kWh à 96.85 FCFA/kWh
- **Tranche 2** : 151-250 kWh à 101.36 FCFA/kWh  
- **Tranche 3** : 251+ kWh à 118.45 FCFA/kWh

## 🔧 Services

- **API** : http://localhost:8082
- **PgAdmin** : http://localhost:5052
- **PostgreSQL** : localhost:5434

## 👥 Clients de test

- **COMP12345** : Dupont Jean (50000 FCFA)
- **COMP67890** : NDAO Moussa (50000 FCFA)
