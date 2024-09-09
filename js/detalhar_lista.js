let currentEditTask = null;

const getListsFromLocal = () => {
  const storedLists = localStorage.getItem("taskLists");
  return storedLists ? JSON.parse(storedLists) : [];
};

const saveListsToLocal = (lists) => {
  localStorage.setItem("taskLists", JSON.stringify(lists));
  renderTasks();
};

const renderTasks = () => {
  const urlParams = new URLSearchParams(window.location.search);
  const listId = parseInt(urlParams.get("id"), 10);
  const lists = getListsFromLocal();
  const list = lists.find((list) => list.id === listId);

  const article = document.querySelector("article.tasks");
  article.innerHTML = "";

  if (list) {
    list.tarefas.forEach((task) => {
      const taskItem = document.createElement("div");
      taskItem.classList.add("task-item", task.status);

      taskItem.innerHTML = `
                <h2>${task.name}</h2>
                <p>Status: ${task.status}</p>
                <p>Estimativa: ${task.pomodoroEstimate} Pomodoros</p>
                <div class="task-actions">
                    <button class="edit-btn" data-task-id="${task.id}">Editar</button>
                    <button class="delete-btn" data-task-id="${task.id}">Deletar</button>
                    <button class="pomodoro-btn">Concluir Tarefa</button>
                </div>
                <button class="expand-btn">Mostrar Detalhes</button>
                <div class="task-details">
                    <p>Data de Início: ${task.startDate}</p>
                    <p>Data de Término: ${task.endDate}</p>
                    <p>Descrição: ${task.description}</p>
                </div>
            `;
      article.appendChild(taskItem);
    });

    document.querySelectorAll(".edit-btn").forEach((button) => {
      button.addEventListener("click", handleEdit);
    });

    document.querySelectorAll(".delete-btn").forEach((button) => {
      button.addEventListener("click", handleDelete);
    });

    expandTaskDetails();
  }
};

const handleEdit = (event) => {
  const taskId = parseInt(event.target.getAttribute("data-task-id"), 10);

  const urlParams = new URLSearchParams(window.location.search);
  const listId = parseInt(urlParams.get("id"), 10);

  const lists = getListsFromLocal();
  const list = lists.find((list) => list.id === listId);
  const taskToEdit = list.tarefas.find((task) => task.id === taskId);

  if (taskToEdit) {
    document.querySelector("#taskName").value = taskToEdit.name || "";
    document.querySelector("#taskDescription").value =
      taskToEdit.description || "";
    document.querySelector("#startDate").value = taskToEdit.startDate || "";
    document.querySelector("#endDate").value = taskToEdit.endDate || "";
    document.querySelector("#pomodoroEstimate").value =
      taskToEdit.pomodoroEstimate || "";

    currentEditTask = { listId, taskId };

    const modal = document.getElementById("myModal");
    if (modal) {
      modal.style.display = "flex";
    }
  }
};

const handleDelete = (event) => {
  const taskId = parseInt(event.target.getAttribute("data-task-id"), 10);

  const urlParams = new URLSearchParams(window.location.search);
  const listId = parseInt(urlParams.get("id"), 10);

  const lists = getListsFromLocal();
  const list = lists.find((list) => list.id === listId);

  if (list) {
    list.tarefas = list.tarefas.filter((task) => task.id !== taskId);
    saveListsToLocal(lists);
  }
};

const closeModal = () => {
  const modal = document.getElementById("myModal");
  if (modal) {
    modal.style.display = "none";
  }
};

document.querySelector(".close").addEventListener("click", closeModal);
window.addEventListener("click", (event) => {
  const modal = document.getElementById("myModal");
  if (modal && event.target === modal) {
    closeModal();
  }
});

const taskForm = document.querySelector("#taskForm");

taskForm.addEventListener("submit", (event) => {
  event.preventDefault();

  const taskName = document.querySelector("#taskName").value;
  const taskDescription = document.querySelector("#taskDescription").value;
  const startDate = document.querySelector("#startDate").value;
  const endDate = document.querySelector("#endDate").value;
  const pomodoroEstimate = parseInt(
    document.querySelector("#pomodoroEstimate").value,
    10
  );

  const lists = getListsFromLocal();
  const urlParams = new URLSearchParams(window.location.search);
  const listId = parseInt(urlParams.get("id"), 10);
  const list = lists.find((list) => list.id === listId);

  if (currentEditTask === null) {
    const newTask = {
      id: Date.now(),
      name: taskName,
      description: taskDescription || "Sem descrição",
      startDate,
      endDate,
      pomodoroEstimate,
      status: "pendente",
    };

    console.log(list);
    list.tarefas.push(newTask);
  } else {
    const taskIndex = list.tarefas.findIndex(
      (task) => task.id === currentEditTask.taskId
    );

    if (taskIndex !== -1) {
      list.tarefas[taskIndex] = {
        id: currentEditTask.taskId,
        name: taskName,
        description: taskDescription || "Sem descrição",
        startDate,
        endDate,
        pomodoroEstimate,
        status: list.tarefas[taskIndex].status, 
      };

      currentEditTask = null;
    }
  }

  saveListsToLocal(lists); 
  closeModal();
  taskForm.reset();
});

const expandTaskDetails = () => {
  const expandButtons = document.querySelectorAll(".expand-btn");

  expandButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const taskItem = this.closest(".task-item");
      taskItem.classList.toggle("expanded");
      this.textContent = taskItem.classList.contains("expanded")
        ? "Ocultar Detalhes"
        : "Mostrar Detalhes";
    });
  });
};

document.addEventListener("DOMContentLoaded", () => {
  renderTasks();
});
