const mysql = require("mysql2");

// URL de connexion MySQL (veillez à ne pas exposer ce mot de passe publiquement)
const dbUrl = "mysql://root:OGvgmloSVyjLeGDuJqeswTJVrPoJTrmN@autorack.proxy.rlwy.net:45609/railway";

// Créer une connexion à la base de données
const db = mysql.createConnection(dbUrl);

// Tester la connexion
db.connect((err) => {
  if (err) {
    console.error("Erreur MySQL :", err);
    return;
  }
  console.log("✅ Connecté à MySQL !");
});

module.exports = db;

