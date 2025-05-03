
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
  
  
  
  
  
// Function to perform OCR on image
async function Recognize(image) {
    let result = await worker.recognize(image);
    console.log(result.data.text);
    console.log('Finished recognizing');
    document.getElementById("inputField").value = result.data.text;
    return result.data.text;
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
  