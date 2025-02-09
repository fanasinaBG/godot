const express = require("express");
const db = require("./db");

const router = express.Router();

router.get("/", (req, res) => {
    db.query("SELECT * FROM plat", (err, results) => {
      if (err) {
        res.status(500).json({ error: err.message });
        return;
      }
      res.json(results);
    });
  });
  
  module.exports = router;
