document.addEventListener("DOMContentLoaded", function () {
    const stars = document.querySelectorAll(".star");
    const ratingInput = document.getElementById("ratingInput");
    const ratingDisplay = document.getElementById("selected-rating");

    let selectedRating = 0;
    ratingDisplay.textContent = `Rating: ${selectedRating}`;

    stars.forEach((star, index) => {
        if (index < selectedRating) {
            star.style.color = "#f90";
        } else {
            star.style.color = "#46434326";
        }
    });

    stars.forEach((star, index) => {
        star.addEventListener("click", function () {
            const ratingValue = index + 1;

            selectedRating = ratingValue;
            ratingDisplay.textContent = `Rating: ${selectedRating}`;

            stars.forEach((s, i) => {
                if (i < selectedRating) {
                    s.style.color = "#f90"; 
                } else {
                    s.style.color = "#46434326";
                }
            });

            ratingInput.value = selectedRating;
        });
    });
});