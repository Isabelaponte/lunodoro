const modal = document.getElementById("myModal");
const addTaskBtn = document.querySelector(".add-task-btn");
const closeModalBtn = document.querySelector(".close");

addTaskBtn.onclick = function () {
  modal.style.display = "flex";
};

window.onclick = function (event) {
  event.preventDefault();
  if (event.target === modal) {
    modal.style.display = "none";
  }
};
