//Toggle class active
const navbarNav = document.querySelector(".navbar-nav");

//ketika ikon menu diklik (khusus layar hp)
document.querySelector("#menu").onclick = (e) => {
  e.preventDefault();
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

//total price
const mealPrices = {
  "Protein Plan": 40000,
  "Diet Plan": 30000,
  "Royal Plan": 60000
};

const mealRadios = document.querySelectorAll('input[name="meal_plan"]');
const dayCheckboxes = document.querySelectorAll('input[name="delivery_days[]"]');
const mealTypeCheckboxes = document.querySelectorAll('input[name="meal_type[]"]');
const totalPriceDisplay = document.getElementById('total_price_display');
const totalPriceHidden = document.getElementById('total_price');

function calculateTotal() {
  const selectedPlan = document.querySelector('input[name="meal_plan"]:checked');
  if (!selectedPlan) return;

  const planPrice = mealPrices[selectedPlan.value];
  const selectedDays = Array.from(dayCheckboxes).filter(cb => cb.checked).length;
  const selectedMealTypes = Array.from(mealTypeCheckboxes).filter(cb => cb.checked).length;

  const total = planPrice * selectedDays * selectedMealTypes;

  totalPriceDisplay.value = total.toLocaleString('id-ID');
  totalPriceHidden.value = total;
}

[...mealRadios, ...dayCheckboxes, ...mealTypeCheckboxes].forEach(el =>
  el.addEventListener('change', calculateTotal)
);
