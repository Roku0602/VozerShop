function myFunction() 
{
  let x = document.getElementById("myInput");
  let y = document.getElementById("eye");
  if (x.type === "password") 
  {
    x.type = "text";
    y.style.color = '#d3d3d3';
  } 
  else 
  {
    x.type = "password";
    y.style.color = '#5887ef';
  }
}