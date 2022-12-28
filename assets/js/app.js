//s'assurer que le document est bien chargé avant d'effectuer des appels JQUERY




//chart des foods et ses calories 
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
 // const foodName=document.querySelector("#inputRepas").value;
 // const foodCalorie=document.querySelector("#inputCalories").value;
  console.log(foodName,foodCalorie);


});

function editLink(foodName,calories,idFood) {
  console.log('samiha bb ' + foodName +calories);

const foodInput =document.getElementById("inputRepasEdit");
foodInput.value = foodName;
const calorieInput= document.getElementById("inputCaloriesEdit");
calorieInput.value=calories;

const idInput =document.getElementById("inputIdFood");
idInput.value=idFood;





}



/*
$(".editLink").click(function () {
    
  // alert('test');
  console.log('samiha bb');
  /* var food = $("#name").val();
    var marks = $("#marks").val();
    var str = "You Have Entered " 
        + "Name: " + name 
        + " and Marks: " + marks;
    $("#modal_body").html(str); 
});*/

//document.querySelector("#inputRepas").value;