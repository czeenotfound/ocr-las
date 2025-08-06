
//Initate Tesseract model wasm using worker:

//Glob variable OCR worker:
const worker = Tesseract.createWorker({
    logger: m => console.log(m)
  });
  Tesseract.setLogging(true);
   
  
  
  //Initiate Tesseract worker:
  async function Init()
  {
    //console.log('Initiate worker')
    await worker.load();
    await worker.loadLanguage('eng');
    await worker.initialize('eng');
    
    //Recognize only numbers:
    await worker.setParameters({ tessedit_char_whitelist: '0123456789',});
    
    //Enable start button:
    enableWebcamButton.classList.remove('invisible');
    enableWebcamButton.innerHTML = 'Start camera';
    console.log('Finished loading tesseract');
  }
  
  
  
  
  
let isVerifying = false;
let retryCount = 0;
const MAX_RETRIES = 3;

// Add a helper to show status in the modal
function showOCRStatus(msg) {
    let statusDiv = document.getElementById('ocr-status');
    if (!statusDiv) {
        // Create the status div if it doesn't exist
        const liveView = document.getElementById('liveView');
        statusDiv = document.createElement('div');
        statusDiv.id = 'ocr-status';
        statusDiv.style = 'position:absolute;top:10px;left:50%;transform:translateX(-50%);z-index:10;color:#fff;background:rgba(0,0,0,0.7);padding:8px 16px;border-radius:8px;font-weight:bold;';
        liveView.appendChild(statusDiv);
    }
    statusDiv.innerText = msg;
}
function clearOCRStatus() {
    let statusDiv = document.getElementById('ocr-status');
    if (statusDiv) statusDiv.innerText = '';
}

// Function to perform OCR on image, with 5s scan interval
let lastScanTime = 0;
async function Recognize(image) {
    const now = Date.now();
    if (now - lastScanTime < 5000) return; // Only scan every 5 seconds
    lastScanTime = now;
    let result = await worker.recognize(image);
    let idNumber = result.data.text.trim();
    document.getElementById("inputField").value = idNumber;
    if (idNumber.length > 0 && !isVerifying) {
        retryCount = 0; // Reset retry count on success
        showOCRStatus('ID found! Verifying...');
        verifyID(idNumber);
    } else if (idNumber.length === 0) {
        retryCount++;
        if (retryCount <= MAX_RETRIES) {
            if (typeof stopWebcam === 'function' && typeof enableCam === 'function') {
                stopWebcam();
                setTimeout(() => {
                    enableCam();
                }, 500);
            }
        } else {
            retryCount = 0;
        }
    }
    return idNumber;
}

// Update verifyID to clear the status after 5 seconds or after reload
function verifyID(idNumber) {
    isVerifying = true;
    const inputField = document.getElementById("inputField");
    inputField.value = idNumber;
    const form = inputField.closest("form");
    if (form) {
        showOCRStatus('ID found! Verifying...');
        setTimeout(() => {
            form.submit();
        }, 500); // Small delay for user to see the message
    }
}

  // Function to update OCR result continuously
  function updateOCRResult() {
      // Call the Recognize function here
      Recognize(image).then(() => {
          // Call this function again after a delay (e.g., every second)
          setTimeout(updateOCRResult, 400); // Update OCR result every second
      });
  }
  updateOCRResult()
  
  //Function terminates the worker:
  async function ShutDownWorker()
  {
    await worker.terminate();
  }
  