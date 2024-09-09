const saveListsToLocal = (lists) => {
    localStorage.setItem("taskLists", JSON.stringify(lists));
    renderLists();
  };
  
  const getListsFromLocal = () => {
    const storedLists = localStorage.getItem("taskLists");
    return storedLists ? JSON.parse(storedLists) : [];
  };
  
  const renderLists = () => {
    const lists = getListsFromLocal();
    const section = document.querySelector("section");
    section.innerHTML = "";
  
    lists.forEach((list, index) => {
      const card = document.createElement("div");
      card.classList.add("card");
  
      card.innerHTML = `
              <div class="div-list">
                  <div class="tag-progress ${list.status}">${list.statusLabel}</div>  
                  <div class="more-options">
                      <button class="more-options-btn edit-button" data-index="${index}">
                          <img src="../img/icons/edit.png" alt="edit-button">
                      </button>
                      <button class="more-options-btn delete-button" data-index="${index}">
                          <img src="../img/icons/delete.png" alt="delete-button">
                      </button>
                  </div>
              </div>
              <h3><a href="tarefa_detalhes.html?id=${list.id}">${list.name}</a></h3>
              <p>${list.description}</p>
              <p class="list-type">Tipo: ${list.type}</p>
              <p class="date">Criada em ${list.date}</p>
          `;
      section.appendChild(card);
    });
  
    document.querySelectorAll(".edit-button").forEach((button) => {
      button.addEventListener("click", handleEdit);
    });
  
    document.querySelectorAll(".delete-button").forEach((button) => {
      button.addEventListener("click", handleDelete);
    });
  };
  
  const taskForm = document.querySelector("#taskForm");
  
  let currentEditIndex = null;
  
  taskForm.addEventListener("submit", (event) => {
    event.preventDefault();
  
    const taskName = document.querySelector("#taskName").value;
    const taskDescription = document.querySelector("#taskDescription").value;
    const listType = document.querySelector("#listType").value;
  
    if (currentEditIndex === null) {
      const newList = {
        id: Date.now(),
        name: taskName,
        description: taskDescription || "Sem descrição",
        type: listType,
        status: "em_progresso",
        statusLabel: "Em progresso",
        date: new Date().toLocaleDateString(),
        tarefas: [],
      };
  
      const lists = getListsFromLocal();
      lists.push(newList);
      saveListsToLocal(lists);
    } else {
      const lists = getListsFromLocal();
  
      lists[currentEditIndex] = {
        ...lists[currentEditIndex],
        name: taskName,
        description: taskDescription,
        type: listType,
      };
  
      saveListsToLocal(lists);
      currentEditIndex = null;
    }
  
    modal.style.display = "none";
    taskForm.reset();
  });
  
  const handleEdit = (event) => {
    const index = event.target.closest("button").getAttribute("data-index");
    const lists = getListsFromLocal();
    const listToEdit = lists[index];
  
    document.querySelector("#taskName").value = listToEdit.name;
    document.querySelector("#taskDescription").value = listToEdit.description;
    document.querySelector("#listType").value = listToEdit.type;
  
    currentEditIndex = index;
  
    modal.style.display = "flex";
  };
  
  const handleDelete = (event) => {
    const index = event.target.closest("button").getAttribute("data-index");
    const lists = getListsFromLocal();
    lists.splice(index, 1);
    saveListsToLocal(lists);
  };
  
  document.addEventListener("DOMContentLoaded", () => {
    renderLists();
  });
  