console.log("coucou from app.js");







const ctx = document.getElementById('myChart');

new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: ['Big Mac', 'Pain au chocolat', 'Pates carbonara'],
    datasets: [{
      label: '',
      data: [400,250,1200],
      borderWidth: false,
      hoverOffset:20,
      backgroundColor: [
        "#FF5E5B",
        "#D8D8D8",
        "#FFED66",
        "#00CECB",
        "#FFED66",
      ],
    }]
  },
  options: {
    responsive:true,
    cutout:"90%",
    plugins:{
        legend:false,
    },
    layout:{
        padding:20
    }
  }
});