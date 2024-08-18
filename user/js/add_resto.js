document.addEventListener("DOMContentLoaded", function() {
    const addMoreHoursButton = document.getElementById('add_more_hours');
    const operationalHoursContainer = document.getElementById('operational_hours');
    let hourIndex = 1; // Start index for new hour inputs

    addMoreHoursButton.addEventListener('click', function() {
        // Clone the template for new operational hours
        const hourTemplate = document.getElementById('hour_template');
        const newHour = hourTemplate.cloneNode(true);
        newHour.style.display = 'block';
        
        // Update the names of the new elements to ensure they are unique
        newHour.querySelectorAll('select, input').forEach(element => {
            const name = element.name.replace(/\[\d+\]/, `[${hourIndex}]`);
            element.name = name;
        });

        // Add event listener for delete button
        newHour.querySelector('.delete_hour').addEventListener('click', function() {
            operationalHoursContainer.removeChild(newHour);
        });

        // Append the new hour inputs to the container
        operationalHoursContainer.appendChild(newHour);
        hourIndex++;
    });

    // Add event listener for existing delete buttons (if any)
    operationalHoursContainer.addEventListener('click', function(event) {
        if (event.target.classList.contains('delete_hour')) {
            const hourToDelete = event.target.closest('.operational_hour');
            operationalHoursContainer.removeChild(hourToDelete);
        }
    });
});

document.getElementById('add_more_hours').addEventListener('click', function() {
    var template = document.getElementById('hour_template');
    var clone = template.cloneNode(true);
    clone.style.display = 'block';
    clone.id = '';
    document.getElementById('operational_hours').appendChild(clone);
});

document.getElementById('operational_hours').addEventListener('click', function(e) {
    if (e.target && e.target.className === 'delete_hour') {
        e.target.parentElement.remove();
    }
});