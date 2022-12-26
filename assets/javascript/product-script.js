let mainImg = document.getElementById("main-img")
let smallImg = document.getElementsByClassName("small-img")

smallImg[0].onclick = function()
{
    mainImg.src = smallImg[0].src;
}
smallImg[1].onclick = function()
{
    mainImg.src = smallImg[1].src;
}
smallImg[2].onclick = function()
{
    mainImg.src = smallImg[2].src;
}
smallImg[3].onclick = function()
{
    mainImg.src = smallImg[3].src;
}

const myInput = document.getElementById("quantity");
function stepper(btn)
{
    let id = btn.getAttribute("id");
    let min = myInput.getAttribute("min");
    let max = myInput.getAttribute("max");
    let step = myInput.getAttribute("step");
    let val = myInput.getAttribute("value");
    let calcStep = (id == "increment") ? (step * 1) : (step * -1);

    console.log(id, calcStep);

    let newVal = parseInt(val) + calcStep;

    if(newVal >= min && newVal <= max)
    {
        myInput.setAttribute("value", newVal);
    }
}