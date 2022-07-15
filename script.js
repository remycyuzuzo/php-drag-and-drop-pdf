let target = document.querySelector(".drop_area");
let fileInput = document.querySelector("input[type=file]");
const preview = document.querySelector(".preview");
const form = document.querySelector("form");
const submitBtn = document.querySelector("[data-submitbtn]");

const pdfPreviewBtn = document.querySelectorAll("[data-pdfpreview]");
const closepdfpreviewBtn = document.querySelector("[data-closepdfpreview]");
const pfdPreviewModal = document.querySelector(".pdf-preview");
const pfdPreviewArea = document.querySelector(".pdf-preview .preview-area");

const PDF_FORMAT = "application/pdf";

target.addEventListener("dragover", (e) => {
  e.preventDefault();
  target.classList.add("dragging");
});

target.addEventListener("dragleave", () => {
  if (target.classList.contains("dragging")) {
    target.classList.remove("dragging");
  }
});

const convertFileUnit = (size) => {
  size /= 1024;
  let unit = "kb";
  if (size >= 1024) {
    size = size / 1024;
    unit = "mb";
  }
  return {
    size,
    unit,
  };
};

const handleFileUpload = (fileInstance, index) => {
  const file = document.createElement("div");
  const img = document.createElement("img");
  const pdfName = document.createElement("div");
  const removeBtn = document.createElement("a");
  const textBox = document.createElement("input");
  const textBoxContainer = document.createElement("div");

  textBox.type = "text";
  textBox.className = "form-control";
  textBox.placeholder = "Type in the file title";
  textBox.name = `fileTitle_${index}`;

  file.classList.add("file-list-item");

  const size = convertFileUnit(fileInstance.size);

  pdfName.innerHTML = `${fileInstance.name} | ${Math.round(size.size)}${
    size.unit
  }`;
  removeBtn.innerHTML = "remove";
  removeBtn.href = "#";

  img.src = "./images/pdf-logo.jpg";
  // file.innerHTML = "";
  textBoxContainer.appendChild(textBox);
  file.appendChild(textBoxContainer);
  file.appendChild(img);
  file.appendChild(pdfName);
  file.appendChild(removeBtn);
  preview.appendChild(file);

  // Show a button when a new file is added
  const showUploaderBtn = document.querySelector("[data-addmorefiles]");
  showUploaderBtn.classList.remove("d-none");
  showUploaderBtn.onclick = () => {
    target.classList.toggle("hidden");
  };

  // Add an event listener on a remove file link
  removeBtn.addEventListener("click", (e) => {
    e.preventDefault();
    file.remove();
  });
};

fileInput.addEventListener("change", (e) => {
  const files = e.target.files;
  for (let i = 0; i < files.length; i++) {
    const fileExt = files[i].type;
    handleFileUpload(files[i], i);
    // hide a drop area
    target.classList.add("hidden");
    if (fileExt !== PDF_FORMAT) {
      alert("Only PDF files are allowed");
      continue;
    }
  }

  if (target.classList.contains("hidden") && fileInput.length === 0) {
    target.classList.remove("hidden");
  }
});

target.addEventListener("drop", (e) => {
  e.preventDefault();
  if (target.classList.contains("dragging")) {
    target.classList.remove("dragging");
  }
  const files = e.dataTransfer.files || e.target.files;
  // console.log(files.isArray());

  for (let i = 0; i < files.length; i++) {
    const fileExt = files[i].type;

    if (fileExt !== PDF_FORMAT) {
      alert("Only PDF files are allowed");
      continue;
    }

    handleFileUpload(files[i], i);
    // hide a drop area
    target.classList.add("hidden");
  }
  //   Add dropped file into the hidden input[type=file]
  fileInput.files = files;
});

form.onsubmit = (e) => {
  submitBtn.innerHTML = `Loading ...`;
  submitBtn.disabled = true;
};

const previewPDF = (PDFUrl) => {
  const pdf = document.createElement("embed");
  pfdPreviewModal.classList.remove("hidden");
  pdf.src = `${PDFUrl}`;
  pdf.width = "100%";
  pdf.type = "application/pdf";
  pfdPreviewArea.appendChild(pdf);
};

pdfPreviewBtn.forEach((button) => {
  button.onclick = (event) => {
    event.preventDefault();
    const pdfUrl = event.target.dataset.pdfpreview;
    previewPDF(pdfUrl);
  };
});

closepdfpreviewBtn.onclick = (event) => {
  event.preventDefault();
  pfdPreviewModal.classList.add("hidden");
  pfdPreviewArea.innerHTML = "";
};
