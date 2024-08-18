// script.js

document.getElementById('item').addEventListener('input', updateForm);

function updateForm() {
    const menuName = document.getElementById('item').value;
    if (menuName.length > 0) {
        const fileInput = document.getElementById('excel_file');
        const file = fileInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const data = new Uint8Array(e.target.result);
                const workbook = XLSX.read(data, { type: 'array' });
                const sheetName = workbook.SheetNames[0];
                const sheet = workbook.Sheets[sheetName];
                const json = XLSX.utils.sheet_to_json(sheet, { header: 1 });
                
                for (let i = 1; i < json.length; i++) { // Assuming first row is header
                    const row = json[i];
                    if (row[0].trim().toLowerCase() === menuName.trim().toLowerCase()) {
                        document.getElementById('calories').value = row[1];
                        document.getElementById('protein').value = row[2];
                        document.getElementById('carbohydrate').value = row[3];
                        break;
                    }
                }
            };
            reader.readAsArrayBuffer(file);
        }
    }
}

function showNotification(message) {
    var notification = document.createElement('div');
    notification.id = 'notification';
    notification.textContent = message;
    document.body.appendChild(notification);
    
    // Show the notification
    notification.classList.add('show');

    // Hide the notification after 5 seconds
    setTimeout(function() {
        notification.classList.remove('show');
        setTimeout(function() {
            document.body.removeChild(notification);
        }, 500); // Allow time for the fade-out animation
    }, 5000); // Show for 5 seconds
}
