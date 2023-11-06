document.addEventListener('DOMContentLoaded', function() {
    const faqContainers = document.getElementsByClassName('faq-container');
    
    for (let i = 0; i < faqContainers.length; i++) {
        faqContainers[i].addEventListener('click', function() {
            this.classList.toggle('active');
        });
    }
});