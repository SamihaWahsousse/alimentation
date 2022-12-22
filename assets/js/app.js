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




function sliderChange1(val){
  document.getElementById("age-number").innerHTML= val;

} 
function sliderChange2(val){
  document.getElementById("size-number").innerHTML=val;
} 

function sliderChange3(val){
  document.getElementById("weight-number").innerHTML=val;
} 


document.getElementById("btnAddFood").addEventListener("click",function(){
  const foodName=document.querySelector("#inputRepas").value;
  const foodCalorie=document.querySelector("#inputCalories").value;
  console.log(foodName,foodCalorie);


});



//document.querySelector("#inputRepas").value;