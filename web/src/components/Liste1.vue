<template>
     <div class="table-container">
        <h1>tableau</h1>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prix</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>Produit A</td>
            <td>10€</td>
          </tr>
          <tr>
            <td>2</td>
            <td>Produit B</td>
            <td>15€</td>
          </tr>
          <tr>
            <td>3</td>
            <td>Produit C</td>
            <td>20€</td>
          </tr>
        </tbody>
      </table>
    </div>
</template>
<script>

</script>

<style scoped>
.table-container {
    position: absolute;
    top: 110px; /* Ajuste la position sous la barre de recherche */
    left: 200px; /* Aligné avec la liste */
    width: calc(100% - 220px);
    padding: 20px;
  }
  
  table {
    width: 100%;
    border-collapse: collapse;
    background-color: white;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    overflow: hidden;
  }
  
  th, td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
  }
  
  th {
    background-color: #333;
    color: white;
  }
  
  tr:hover {
    background-color: #f5f5f5;
  }
  @media (max-width: 768px) {
  .table-container {
      left: 0;
      width: 100%;
      padding: 10px;
    }
}

@media (max-width: 1024px) {
.table-container {
      left: 160px;
      width: calc(100% - 180px);
    }
}
@media (max-width: 480px) {
    .table-container {
      width: 100%;
      left: 0;
      padding: 5px;
    }
  
    th, td {
      padding: 8px;
    }
}
</style>