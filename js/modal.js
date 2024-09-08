const modal = document.querySelector("#myModal");
const addTaskBtn = document.querySelector(".add-task-btn");
const closeModalBtn = document.querySelector(".close");

addTaskBtn.onclick = function () {
  modal.style.display = "flex";
};

closeModalBtn.onclick = function () {
  modal.style.display = "none";
};