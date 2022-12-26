function myFunction() 
{
  let x = document.getElementById("myInput");
  let y = document.getElementById("eye");
  if (x.type === "password") 
  {
    x.type = "text";
    y.style.color = '#5887ef';
  } 
  else 
  {
    x.type = "password";
    y.style.color = '#d3d3d3';
  }
}

function myFunction2() 
{
  let x = document.getElementById("myInput2");
  let y = document.getElementById("eye2");
  if (x.type === "password") 
  {
    x.type = "text";
    y.style.color = '#5887ef';
  } 
  else 
  {
    x.type = "password";
    y.style.color = '#d3d3d3';
  }
}