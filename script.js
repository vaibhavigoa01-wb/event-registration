
const form = document.getElementById("eventForm");

form.addEventListener("submit", function (event) {
    const confirmed = confirm(
        "Are you sure you want to register for this event?"
    );

    if (!confirmed) {
        event.preventDefault();
    }
});
