document.addEventListener('DOMContentLoaded', function () {
    const carouselElement = document.querySelector('#heroCarousel');
    if (carouselElement) {
        const carousel = new bootstrap.Carousel(carouselElement, {
            interval: 3000, // Waktu dalam milidetik (3 detik)
            ride: 'carousel'
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const crossIcon = document.getElementById('crossIcon');
    const cancelButton = document.getElementById('cancelButton');

    searchInput.addEventListener('focus', function() {
        crossIcon.style.display = 'block';
        cancelButton.style.display = 'block';
    });

    searchInput.addEventListener('input', function() {
        if (searchInput.value.length > 0) {
            crossIcon.style.display = 'block';
            cancelButton.style.display = 'block';
        } else {
            crossIcon.style.display = 'none';
            cancelButton.style.display = 'none';
        }
    });

    crossIcon.addEventListener('click', function() {
        searchInput.value = '';
        crossIcon.style.display = 'none';
        cancelButton.style.display = 'none';
        searchInput.focus();
    });

    cancelButton.addEventListener('click', function() {
        searchInput.value = '';
        crossIcon.style.display = 'none';
        cancelButton.style.display = 'none';
        searchInput.blur();
    });

    document.addEventListener('click', function(event) {
        if (!event.target.closest('.search-bar__container')) {
            crossIcon.style.display = 'none';
            cancelButton.style.display = 'none';
        }
    });
});

// Check for Web Speech API support
if ('webkitSpeechRecognition' in window) {
    const recognition = new webkitSpeechRecognition();
    recognition.continuous = false;
    recognition.interimResults = false;
    recognition.lang = 'en-US'; // Adjust language as needed

    const searchInput = document.getElementById('searchInput');
    const speechToTextButton = document.getElementById('speechToText');

    // Start speech recognition on button click
    speechToTextButton.addEventListener('click', () => {
        recognition.start();
    });

    // Handle speech recognition result
    recognition.onresult = async (event) => {
        const transcript = event.results[0][0].transcript;
        searchInput.value = transcript;
        recognition.stop();
        searchInput.focus();

        // Optional: send recognized text to the server
        try {
            const response = await fetch('http://localhost:5000/speech-to-text', {
                method: 'POST',
                body: JSON.stringify({ text: transcript }),
                headers: {
                    'Content-Type': 'application/json'
                }
            });

            const result = await response.json();
            console.log(result); // Handle the server response here
        } catch (error) {
            console.error('Error:', error);
        }
    };

    // Handle speech recognition error
    recognition.onerror = (event) => {
        console.error('Speech recognition error detected:', event.error);
        recognition.stop();
    };

    // Optional: Handle speech recognition end
    recognition.onend = () => {
        console.log('Speech recognition ended');
    };
} else {
    console.log('Speech recognition not supported');
}


document.addEventListener('DOMContentLoaded', function() {
    const cameraButton = document.getElementById('cameraButton');
    const cameraFeedSection = document.getElementById('cameraFeedSection');
    const video = document.createElement('video');
    video.width = 640;
    video.height = 480;
    const canvas = document.createElement('canvas');
    canvas.width = 640;
    canvas.height = 480;
    const ctx = canvas.getContext('2d');
    
    // Add video and canvas to the camera feed section
    cameraFeedSection.appendChild(video);
    cameraFeedSection.appendChild(canvas);
    
    async function startCamera() {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ video: true });
            video.srcObject = stream;
            video.play();
            cameraFeedSection.style.display = 'block'; // Show camera feed section

            // Load COCO-SSD model
            const model = await cocoSsd.load();
            detectObjects(model);
        } catch (error) {
            console.error('Error accessing the camera:', error);
        }
    }

    async function detectObjects(model) {
        while (true) {
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            const predictions = await model.detect(canvas);
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

            predictions.forEach(prediction => {
                ctx.beginPath();
                ctx.rect(prediction.bbox[0], prediction.bbox[1], prediction.bbox[2], prediction.bbox[3]);
                ctx.lineWidth = 2;
                ctx.strokeStyle = 'red';
                ctx.fillStyle = 'red';
                ctx.stroke();
                ctx.fillText(`${prediction.class} (${Math.round(prediction.score * 100)}%)`, prediction.bbox[0], prediction.bbox[1] > 10 ? prediction.bbox[1] - 5 : 10);
            });

            await new Promise(resolve => setTimeout(resolve, 1000)); // Detect every 1 second
        }
    }

    cameraButton.addEventListener('click', function() {
        // Ganti path dengan path yang sesuai pada sistem Anda
        window.open('../user/detect/index.html', '_blank');
    });
});

document.getElementById('cameraButton').addEventListener('click', function() {
    var cameraFeedSection = document.getElementById('cameraFeedSection');
    if (cameraFeedSection.style.display === 'none') {
        cameraFeedSection.style.display = 'block';
    } else {
        cameraFeedSection.style.display = 'none';
    }
});
