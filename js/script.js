//Toggle class active
const navbarNav = document.querySelector(".navbar-nav");
//ketika ikon menu diklik
document.querySelector("#menu").onclick = () => {
  navbarNav.classList.toggle("active");
};

//Klik di luar side bar untuk menghilangkan nav
const menu = document.querySelector('#menu'); 

document.addEventListener('click', function(e) {
    if(!menu.contains(e.target) && !navbarNav.contains(e.target)) {
        navbarNav.classList.remove('active')
    }
})

//pop-up
const openButton = document.querySelectorAll(".see-details");
const closeButton = document.querySelectorAll(".close-popup");

openButton.forEach(button => {
  button.addEventListener("click", function (e) {
    e.preventDefault ();
    const popupId = button.getAttribute("data-popup");
    const popup = document.getElementById(popupId);
    popup.classList.add("open-popup");
  });
});

closeButton.forEach(button => {
  button.addEventListener("click", function () {
    button.closest(".pop-up").classList.remove("open-popup");
  });
});

function showForm(formId) {
  document.querySelectorAll(".form-box").forEach(form => form.classList.remove("active"));
  document.getElementById(formId).classList.add("active");
}
