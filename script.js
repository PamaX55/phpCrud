function Refresh(){
  location.reload();
}

// Show menu creation form
document.getElementById("create-btn").addEventListener("click", function(){
  document.getElementById("createmenu-div").style.visibility = "visible";
  document.getElementById("newmenu-name").focus();
})

// Close menu creation form
document.getElementById("createmenu-quit").addEventListener("click", function(){
  document.getElementById("createmenu-div").style.visibility = "hidden";
  document.getElementById("createmenu-form").reset();
})

// Open menu update form
function OpenUpdateForm(id){
  document.getElementById("updatemenu-div").style.visibility = "visible";
  document.getElementById("updatemenu-id").setAttribute('value', id);
  document.getElementById("updatemenu-name").focus();
}

// Close menu update form
document.getElementById("updatemenu-quit").addEventListener("click", function(){
  document.getElementById("updatemenu-div").style.visibility = "hidden";
  document.getElementById("updatemenu-form").reset();
})

// Open menu preview page
function OpenMenuPreview(id){
  window.location.href = 'preview.php?menu=' + encodeURIComponent(id);
}

// Submit delete form
function DeleteMenu(id){
  formdata = new FormData();
  formdata.append('action', 'delete');
  formdata.append('id', id);

  submitForm(formdata);
}

// Submit create form
function CreateMenu(event){
  event.preventDefault();
  var formdata = new FormData(document.getElementById("createmenu-form"));
  formdata.append('action', 'create');

  submitForm(formdata);
}

// Submit update form
function UpdateMenu(event){
  event.preventDefault();
  var formdata = new FormData(document.getElementById("updatemenu-form"));
  formdata.append('action', 'update');

  submitForm(formdata);
}

function submitForm(formdata){
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "src/Controller/Controller.php", true);

  xhr.onreadystatechange = function () {
    if(xhr.readyState == 4 && xhr.status == 200){
      alert(xhr.responseText);
      Refresh();
    }
  };

  xhr.send(formdata);
}