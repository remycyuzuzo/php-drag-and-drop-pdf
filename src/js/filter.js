const searchTextBox = document.querySelector("[data-search]");
const fileTitle = document.querySelectorAll(".file [data-pdfpreview]");
if (searchTextBox) {
  searchTextBox.addEventListener("keyup", (e) => {
    fileTitle.forEach((item) => {
      const title = item.innerText;
      if (!title.toLowerCase().includes(e.target.value.toLowerCase())) {
        item.closest(".file").style.display = "none";
      } else {
        item.closest(".file").style.display = "flex";
      }
    });
  });
}
