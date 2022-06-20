let target = document.querySelector(".drop_area");
let fileInput = document.querySelector("input");
const preview = document.querySelector(".preview");

target.addEventListener("dragover", (e) => {
    e.preventDefault();
    target.classList.add("dragging");
});

target.addEventListener("dragleave", () => {
    target.classList.remove("dragging");
});

const handleFileUpload = (e) => {
    const img = document.createElement("img");
    const pdfName = document.createElement("div");
    const removeBtn = document.createElement("a");

    pdfName.innerHTML = `${fileInput.value}`;
    removeBtn.innerHTML = "remove";
    removeBtn.href = "#";

    img.src = "./images/pdf-logo.jpg";
    preview.innerHTML = "";
    preview.appendChild(img);
    preview.appendChild(pdfName);
    preview.appendChild(removeBtn);

    removeBtn.addEventListener("click", (e) => {
        e.preventDefault();
        fileInput.value = "";
        preview.remove();
    });
};

fileInput.addEventListener("change", (e) => handleFileUpload(e));

target.addEventListener("drop", (e) => {
    e.preventDefault();
    target.classList.remove("dragging");

    fileInput.files = e.dataTransfer.files;

    handleFileUpload(e);
});


// ntago nkumva peeeee burugukatika