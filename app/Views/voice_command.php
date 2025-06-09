<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Voice Command Example</title>
</head>

<body>
    <h2>Voice Command (CodeIgniter 4 + Web Speech API)</h2>
    <button id="startBtn">Mulai Rekam Suara</button>
    <p>Hasil: <span id="resultText"></span></p>
    <p>Respon Server: <span id="serverResponse"></span></p>

    <script>
        const startBtn = document.getElementById('startBtn');
        const resultText = document.getElementById('resultText');
        const serverResponse = document.getElementById('serverResponse');

        if (!('webkitSpeechRecognition' in window) && !('SpeechRecognition' in window)) {
            alert('Browser kamu tidak mendukung Web Speech API.');
        }

        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        const recognition = new SpeechRecognition();

        recognition.lang = 'id-ID'; // Bahasa Indonesia
        recognition.interimResults = false;
        recognition.maxAlternatives = 1;

        startBtn.onclick = () => {
            recognition.start();
        };

        recognition.onresult = (event) => {
            const transcript = event.results[0][0].transcript;
            resultText.textContent = transcript;

            // Kirim ke server via fetch
            fetch('<?= base_url('voice-command/process') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        command: transcript
                    }),
                })
                .then(res => res.json())
                .then(data => {
                    serverResponse.textContent = data.message;
                })
                .catch(err => {
                    serverResponse.textContent = 'Error: ' + err.message;
                });
        };

        recognition.onerror = (event) => {
            serverResponse.textContent = 'Error: ' + event.error;
        };
    </script>
</body>

</html>