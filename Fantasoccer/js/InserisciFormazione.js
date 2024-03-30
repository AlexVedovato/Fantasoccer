function dragStart(ev) {
  ev.dataTransfer.effectAllowed='swap';
  ev.dataTransfer.setData("Text", ev.target.getAttribute('id'));
  return true;
}

// these functions prevents default behavior of browser
function dragEnter(ev) {
  event.preventDefault();
  return true;
}

function dragOver(ev) {
  event.preventDefault();
  return true;
}

// function defined for when drop element on target
function dragDrop(ev,ruolo) {
  var data = ev.dataTransfer.getData("Text");
  if(document.getElementById(data).getAttribute("class").split("_")[1]==ruolo){
    if(ev.target.childElementCount<1){
      ev.target.appendChild(document.getElementById(data));
      ev.stopPropagation();
      return false;
    }
  }
}