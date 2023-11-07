document.addEventListener('DOMContentLoaded', function() {
    const faqContainers = document.getElementsByClassName('faq-container');
    
    for (let i = 0; i < faqContainers.length; i++) {
        faqContainers[i].addEventListener('click', function() {
            this.classList.toggle('active');
        });
    }
});

//search scripts
document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById("searchInput");
    const searchButton = document.getElementById("searchButton");

    searchInput.addEventListener("input", function() {
        if (searchInput.value.trim() === "") {
            searchButton.disabled = true;
        } else {
            searchButton.disabled = false;
        }
    });

    searchButton.addEventListener("click", function() {
        if (searchInput.value.trim() !== "") {
            document.getElementById("searchForm").submit();
        }
    });
});